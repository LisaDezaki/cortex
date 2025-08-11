<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Http\Resources\CustomFieldResource;
use App\Models\Character;
use App\Models\CustomField;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
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

	protected $validationRules = [
		'name'                  => ['required',  'string'],
		'description'           => ['nullable',  'string'],
		'portrait'              => ['nullable',  'string'],

		'faction_id'            => ['nullable',  'exists:factions,id'],
		'location_id'           => ['nullable',  'exists:locations,id'],
		'relationships'         => ['sometimes',  'array'],
		'relationships.*'		=> ['present'],
		// 'relationships.*.id'    => ['required',  'distinct', 'exists:characters,id'],
		// 'relationships.*.role'  => ['required', 'string'],
		// 'relationships.*.related_role' => ['required', 'string'],

		'custom_fields'			=> ['sometimes', 'array'],
        'custom_fields.*'       => ['present'],
		'custom_fields.*.id'    => ['required', 'distinct', 'exists:custom_fields,id'],
		'custom_fields.*.value' => ['nullable', 'string']
	];

	public function index()
	{
		$active_project = Auth::user()->active_project;
		if (!$active_project) {
			return Redirect::route('projects');
		}

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'character'
		])->with('options')->get();

		return Inertia::render('Characters/Index', [
			'customFields' => CustomFieldResource::collection($customFields)
		]);
	}

	public function create()
	{
		$activeProject = Auth::user()->active_project;
		if (!$activeProject) {
			return Redirect::route('projects');
		}

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'character'
		])->with('options')->get();

		$traitsPersonality = File::get(database_path('data/options/personality.json'));

		return Inertia::render('Characters/Create', [
			'customFields' => CustomFieldResource::collection($customFields),
			'traitsPersonality' => json_decode($traitsPersonality, true)
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$validatedData = $request->validate($this->validationRules);
		$character = Auth::user()->activeProject()->characters()->create($validatedData);
		$this->handlePortrait($request, $character);
		$this->handleCustomFields($validatedData['custom_fields'], $character);

		if ($request->has('faction_id')) {
			$character->faction()->associate($validatedData['faction_id']);
		}

		if ($request->has('location_id')) {
			$character->location()->associate($validatedData['location_id']);
		}

		if ($request->has('relationships')) {
			$character->relationships()->sync($validatedData['relationships']);
		}

		$character->save();

		return Redirect::route("characters.show", [
			'character' => $character->slug
		]);
	}

	public function show(Character $character): Response
	{
		$character->load([
			'location',
			'factions',
			'portrait',
			'relationships.portrait',
			'inverseRelationships.portrait',
			'customFieldValues.customField'
		]);

		return Inertia::render('Characters/Show', [
			'character'  => new CharacterResource($character),
		]);
	}

	public function edit(Character $character): Response
	{
		$character->load([
			'location',
			'factions',
			'portrait',
			'relationships.portrait',
			'inverseRelationships.portrait',
			'customFieldValues.customField'
		]);

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'character'
		])->with('options')->get();

		$traitsPersonality = File::get(database_path('data/options/personality.json'));

		return Inertia::render('Characters/Edit', [
			'character'  => new CharacterResource($character),
			'customFields' => CustomFieldResource::collection($customFields),
			'traitsPersonality' => json_decode($traitsPersonality, true)
		]);
	}

	public function update(Request $request, Character $character): RedirectResponse
	{
		$validatedData = $request->validate($this->validationRules);
		$character->fill($validatedData);
		$this->handlePortrait($request, $character);
		$this->handleCustomFields($validatedData['custom_fields'], $character);

		// if ($request->has('faction_id')) {
		// 	$character->factions()->associate($validatedData['faction_id']);
		// }

		if ($request->has('location_id')) {
			$character->location()->associate($validatedData['location_id']);
		}

		// if ($request->has('relationships')) {
		// 	$character->relationships()->sync($validatedData['relationships']);
		// }

		$character->update();
		
		return Redirect::route("characters.show", [
			'character' => $character->slug
		]);
	}

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
		
		Session::flash('message', "<strong>{$character->name}</strong> has been deleted.");
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

	public function handlePortrait(Request $request, Character $character)
	{
		$request->validate([
			'portrait' => 'string|nullable',
		]);

		$user = Auth::user();
		$userDir    = "user_"   .substr($user->id, 0, 8);
		$projectDir = "project_".substr($user->active_project, 0, 8);

		$this->mediaService->updateImage(
			$character,
			$character->portrait(),
			$request->portrait,
			"$userDir/$projectDir/characters"
		);
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