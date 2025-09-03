<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Http\Resources\CollectionResource;
use App\Http\Resources\CustomFieldResource;
use App\Models\Character;
use App\Models\Collection;
use App\Models\CustomField;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class CharacterController extends Controller
{
	protected $mediaService;

	public function __construct(MediaService $mediaService)
	{
		$this->mediaService = $mediaService;
	}

	/**
	 * VALIDATION
	 * 
	 * Validate the incoming requests.
	 * Validation will fail if the incoming request includes any fields that are not
	 * included in this list.
	 */

	protected $validationRules = [
		'name'                  => ['sometimes', 'required', 'string'],
		'description'           => ['nullable',  'string'],
		'banner'                => ['nullable',  'string'],
		'portrait'              => ['nullable',  'string'],

		'media'					=> ['sometimes', 'array'],
		'media.*'				=> ['present'],
		'media.*.name'			=> ['string', 'nullable'],
		'media.*.path'			=> ['string', 'nullable'],
		'media.*.type'			=> ['string', 'required', 'in:banner,emblem,gallery,map,portrait'],
		'media.*.url'			=> ['string', 'nullable'],

		'faction_id'            => ['nullable',  'exists:factions,id'],
		'location_id'           => ['nullable',  'exists:locations,id'],
		'relationships'         => ['sometimes',  'array'],
		'relationships.*'		=> ['present'],
		'relationships.*.id'    => ['required',  'distinct', 'exists:characters,id'],
		'relationships.*.role'  => ['required', 'string'],
		'relationships.*.related_role' => ['required', 'string'],

		'custom_fields'			=> ['sometimes', 'array'],
        'custom_fields.*'       => ['present'],
		'custom_fields.*.id'    => ['required', 'distinct', 'exists:custom_fields,id'],
		'custom_fields.*.value' => ['nullable', 'string']
	];

	/**
	 * INDEX
	 * 
	 * Show the list of Characters
	 */

	public function index()
	{
		$collections = Collection::where([
			'project_id' => Auth::user()->active_project,
			'collection_type' => Character::class
		])->with(['items'])->get();

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => Character::class
		])->with('options')->get();

		return Inertia::render('Characters/Index', [
			'collections'	=> CollectionResource::collection($collections),
			'customFields'	=> CustomFieldResource::collection($customFields)
		]);
	}
	public function collections()
	{
		$collections = Collection::where([
			'project_id' => Auth::user()->active_project,
			'collection_type' => Character::class
		])->with(['items'])->get();

		return Inertia::render('Characters/Collections', [
			'collections'	=> CollectionResource::collection($collections),
		]);
	}

	/**
	 * CREATE / STORE
	 * 
	 * When a CharacterCreateRequest is received, it will be handled by the Store
	 * method in the CharacterController. The user will likely only be submitting
	 * a name to initially create a Character.
	 */

	public function create() {}
	public function store(Request $request): RedirectResponse
	{
		$validatedData = $request->validate($this->validationRules);
		$character = Auth::user()->activeProject()->characters()->create($validatedData);
	
		if ($request->has('portrait')) {
			$this->mediaService->attachMedia($character, 'portrait', $request->portrait);
			unset($validatedData['portrait']);
		}

		if ($request->has('banner')) {
			$this->mediaService->attachMedia($character, 'banner', $request->banner);
			unset($validatedData['banner']);
		}

		if ($request->has('faction_id')) {
			$character->faction()->associate($validatedData['faction_id']);
		}

		if ($request->has('location_id')) {
			$character->location()->associate($validatedData['location_id']);
		}

		if ($request->has('relationships')) {
			$character->relationships()->sync($validatedData['relationships']);
		}

		if ($request->has('custom_fields')) {
			$this->handleCustomFields($validatedData['custom_fields'], $character);
		}

		$character->save();
		return Redirect::route("characters.show", [
			'character' => $character->slug
		]);
	}

	/**
	 * SHOW
	 * 
	 * Render the Character entity page for the requested Character.
	 */

	public function show(Character $character): Response
	{
		$character->load([
			'collections.items',
			'location',
			'media',
			'factions',
			'banner',
			'portrait',
			'relationships.portrait',
			'inverseRelationships.portrait',
			'customFieldValues.customField'
		]);

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'character'
		])->with('options')->get();

		return Inertia::render('Characters/Show', [
			'character'  => new CharacterResource($character),
			'customFields' => CustomFieldResource::collection($customFields)
		]);
	}


	/**
	 * EDIT / UPDATE
	 * 
	 * When a CharacterUpdateRequest is received, it will be handled by the Update
	 * method in the CharacterController. The user may submit any piece of
	 * Character model to update, and so it must be updated on a per-item basis.
	 */

	public function edit(Character $character) {}
	public function update(Request $request, Character $character): RedirectResponse
	{
		$validatedData = $request->validate($this->validationRules);

		if ($request->has('media')) {
			foreach ($request['media'] as $media) {
				$this->mediaService->attachMedia($character, $media['type'], $media);
			}
		}

		// if ($request->has('banner')) {
		// 	$this->mediaService->attachMedia($character, 'banner', $request->banner);
		// 	unset($validatedData['banner']);
		// }

		// if ($request->has('portrait')) {
		// 	$this->mediaService->attachMedia($character, 'portrait', $request->portrait);
		// 	unset($validatedData['portrait']);
		// }

		if ($request->has('custom_fields')) {
			$this->handleCustomFields($validatedData['custom_fields'], $character);
		}

		if ($request->has('location_id')) {
			$character->location()->associate($validatedData['location_id']);
		}

		unset($validatedData['media']);
		
		$character->fill($validatedData);
		$character->update();
		// return Redirect::route("characters.show", [
		// 	'character' => $character->slug
		// ]);

		return back()->with([
			'success' => 'Character updated successfully!',
			'character' => $character
		]);
	}


	/**
	 * DELETE
	 * 
	 * Remove the entity and all associated data from the database.
	 * Characters have soft-deletes, meaning they can be restored.
	 */

	public function destroy(Request $request, Character $character)
	{
		$request->validate([
			'confirm_name' => 'required|string'
		]);
	
		if ($request->confirm_name !== $character->name) {
			return Redirect::back()->withErrors([
				'confirm_name' => 'The entered name does not match the character you\'re trying to delete.'
			]);
		}
		
		Session::flash('success', "$character->name has been deleted.");
		$character->delete();
		 
		return Redirect::route("characters");
	}



	public function settings(Request $request): Response
	{
		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'character'
		])->with('options')->get();

		return Inertia::render('Characters/Settings', [
			'customFields' => CustomFieldResource::collection($customFields)
		]);
	}



	public function handleCustomFields(array $custom_fields)
	{
		// foreach ($custom_fields as $field) {
		// 	if (empty($field['value'])) { continue; }

		// 	//  Create the new custom field
		// 	CustomFieldValue::updateOrCreate(
		// 		[
		// 			'fieldable_id' => $character->id,
		// 			'custom_field_id' => $field['id']
		// 		],
		// 		[
		// 			'value' => $field['value'],
		// 		]
		// 	);
		// }

		// //  Handle custom fields
		// foreach ($validatedData['custom_fields'] as $field) {
		// 	if (empty($field['value'])) {

		// 		//  Delete custom field value
		// 		CustomFieldValue::where([
		// 			'fieldable_id' => $character->id,
		// 			'custom_field_id' => $field['id']
		// 		])->delete();

		// 	} else {

		// 		//  Create the new custom field
		// 		CustomFieldValue::updateOrCreate(
		// 			[
		// 				'fieldable_id' => $character->id,
		// 				'custom_field_id' => $field['id']
		// 			],
		// 			[
		// 				'value' => $field['value']
		// 			]
		// 		);
				
		// 	}
		// }
	}

}