<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Http\Resources\CustomFieldResource;
use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldValue;
use App\Models\Faction;
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
		'name'                  => ['sometimes', 'string', 'max:255'],
		'alias'                 => ['sometimes', 'nullable', 'string', 'max:255'],
		'description'           => ['sometimes', 'nullable', 'string'],
		'starred'				=> ['sometimes', 'boolean'],

		'media'					=> ['sometimes', 'nullable', 'array'],
		'media.*.name'			=> ['nullable',	 'string'],
		'media.*.path'			=> ['nullable',  'string'],
		'media.*.type'			=> ['required',  'string', 'in:banner,gallery,portrait'],
		'media.*.url'			=> ['nullable',  'string'],

		'factions'         		=> ['sometimes', 'nullable', 'array'],
		'factions.*'  			=> ['required',  'string', 'uuid', 'distinct', 'exists:factions,id'],

		'location'				=> ['sometimes', 'nullable', 'string', 'uuid', 'exists:locations,id'],

		'relationships'         				 => ['sometimes', 'nullable', 'array'],
		'relationships.*.character_role'  		 => ['required',  'string'],
		'relationships.*.related_character_id'	 => ['required',  'string', 'uuid', 'distinct', 'exists:characters,id'],
		'relationships.*.related_character_role' => ['required',  'string'],

		'customField'			=> ['sometimes', 'array'],
		'customField.id'    	=> ['required_with:customField',  'string', 'uuid', 'distinct', 'exists:custom_fields,id'],
		'customField.value' 	=> ['nullable'],

		'custom_fields'			=> ['sometimes', 'array'],
		'custom_fields.*.id'    => ['required_with:custom_fields',  'string', 'uuid', 'distinct', 'exists:custom_fields,id'],
		'custom_fields.*.value' => ['nullable',  'string']
	];

	/**
	 * INDEX
	 * 
	 * Show the list of Characters
	 */
	public function index()
	{
		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => Character::class
		])->with('options')->get();

		return Inertia::render('Characters/Index', [
			'customFields'	=> CustomFieldResource::collection($customFields)
		]);
	}


	/**
	 * CREATE / STORE
	 * 
	 * When a CharacterCreateRequest is received, it will be handled by the Store
	 * method in the CharacterController. The user will likely only be submitting
	 * a name to initially create a Character.
	 */
	public function create() {}		//	Character creation is handled through a simple modal
	public function store(Request $request): RedirectResponse
	{
		//	Attempt to validated the $request
		//	Flash an error if validation fails
		try {
			$validatedData = $request->validate($this->validationRules);
		} catch (\Exception $e) {
			Session::flash('error', "Failed to create character: ".$e);
        	return Redirect::back();
		}
		
		$character = Auth::user()->activeProject()->characters()->create($validatedData);

		if ($request->has('media') && $request['media'] !== null) {
			foreach ($request['media'] as $media) {
				$this->mediaService->attachMedia($character, $media['type'], $media);
			}
			unset($validatedData['media']);
		}
		
		$character->save();
		Session::flash('success', "Character created: $character->name");
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
			'image',
			'media',
			'mapData.location.media',
			'factions.image',
			'relationships.image',
			'inverseRelationships.image',
			'customFieldValues.customField',
		]);

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => Character::class
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
		
		//	Attempt to validated the $request
		//	Flash an error if validation fails
		try {
			$validatedData = $request->validate($this->validationRules);
		} catch (\Exception $e) {
			Session::flash('error', "Failed to create character: ".$e);
        	return Redirect::back();
		}

		//	Media
		if ($request->has('media') && $request['media'] !== null) {
			foreach ($request['media'] as $media) {
				$this->mediaService->attachMedia($character, $media['type'], $media);
			}
			unset($validatedData['media']);
		}

		//	Factions
		if ($request->has('factions')) {
			$character->factions()->sync($request['factions']);
			unset($validatedData['factions']);
		}

		//	Relationships
		if ($request->has('relationships')) {
			foreach ($validatedData['relationships'] as $rel) {
				$relatedCharacter = Character::find($rel['related_character_id']);
				$character->relationships()->save($relatedCharacter, $rel);
			}
			unset($validatedData['relationships']);
		}

		//	Location
		if ($request->has('location')) {
			$character->mapData()->updateOrCreate([], [
				'location_id' => $validatedData['location']
				//	other pivot data
			]);
			unset($validatedData['location']);
		}

		//	Custom Fields
		if ($request->has('customField')) {
			$this->handleCustomFields([$validatedData['customField']], $character);
		}

		// if ($request->has('custom_fields')) {
		// 	$this->handleCustomFields($validatedData['custom_fields'], $character);
		// }

		//	Update
		// $character->fill($validatedData);
		$character->update($validatedData);
		Session::flash('success', "Character updated: $character->name");
        return Redirect::back();
	}



	/**
	 * DELETE
	 * 
	 * Remove the entity and all associated data from the database.
	 * Characters have soft-deletes, meaning they can be restored.
	 */

	public function destroy(Request $request, Character $character)
	{
		//	TODO:	Make sure logged in user is authorized before proceeding.

		Session::flash('success', "Character deleted: $character->name");
		$character->delete();
		return Redirect::route("characters");
	}



	public function settings(Request $request): Response
	{
		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => Character::class
		])->with('options')->get();

		return Inertia::render('Characters/Settings', [
			'customFields' => CustomFieldResource::collection($customFields)
		]);
	}



	public function handleCustomFields(array $custom_fields, Character $character)
	{
		//  Handle custom fields
		foreach ($custom_fields as $field) {
			if (empty($field['value'])) {

				//  Delete custom field value
				CustomFieldValue::where([
					'fieldable_id' => $character->id,
					'custom_field_id' => $field['id']
				])->delete();

			} else {

				//  Create the new custom field
				CustomFieldValue::updateOrCreate(
					[
						'fieldable_id' => $character->id,
						'custom_field_id' => $field['id']
					],
					[
						'value' => $field['value']
					]
				);
				
			}
		}
	}

}