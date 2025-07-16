<?php

namespace App\Http\Controllers;

use App\Http\Resources\CharacterResource;
use App\Models\Character;
use App\Models\CustomFieldValue;
use App\Models\Location;
use App\Services\FileUploadService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CharacterController extends Controller
{
	protected $uploadService;

	public function __construct(FileUploadService $uploadService)
	{
		$this->uploadService = $uploadService;
	}

	protected $validationRules = [
		// Standard fields
		'name' => ['string', 'required'],
		'alias' => ['string', 'nullable'],
		'description' => ['string', 'nullable'],
		'image' => ['string', 'nullable'],
		// Dynamic custom fields
		'custom_fields' => 'sometimes|array',
        // 'custom_fields.*.name' => 'required|string',  // Field name
        'custom_fields.*' => 'present',        // Field value (can be null)
	];

	/* VIEWS */

	public function index(): Response
	{
		return Inertia::render('Characters/Index');
	}

	public function create(): Response
	{
		return Inertia::render('Characters/Create');
	}

	public function show(Character $character): Response
	{
		$character->load([
			'location',
			'factions',
			'relationships',
			'inverseRelationships',
			'customFieldValues.customField'
		]);

		return Inertia::render('Characters/Show', [
			'character'  => new CharacterResource($character)
		]);
	}

	public function edit(Character $character): Response
	{
		$character->load([
			'location',
			'factions',
			'relationships',
			'inverseRelationships',
			'customFieldValues.customField'
		]);

		return Inertia::render('Characters/Edit', [
			'character'  => new CharacterResource($character)
		]);
	}

	/* REQUESTS */

	public function store(Request $request): RedirectResponse
	{

		// Validate user request.
		$validatedData = $request->validate($this->validationRules);

		//	Create the new character.
		$character = new Character($validatedData);
		$character->project_id = Auth::user()->active_project;

		$userEmail = Auth::user()->email;

		$character->save();

		//  Handle custom fields
		foreach ($validatedData['custom_fields'] as $field) {
			if (empty($field['value'])) { continue; }

			//  Create the new custom field
			CustomFieldValue::updateOrCreate(
				[
					'entity_id' => $character->id,
					'custom_field_id' => $field['id']
				],
				[
					'value' => $field['value']
				]
			);
		}

		//	Move temporary image to permanent location.
		if ($request->image) {
			$character->image = $this->uploadService->moveToPermanent(
				$request->image,
				"characters",
				$character->slug ?: strtolower(str_replace(' ', '-', $request->name))
			);
		}
		
		// Redirect user to new character page.
		$character->save();
		return Redirect::route("characters.show", [
			'character' => $character->slug
		]);
	}









	/**
	 * Handle an incoming update character request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Character  $character
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, Character $character): RedirectResponse
	{

		// Validate user request
		$validatedData = $request->validate($this->validationRules);

		// dd($request->image, $character->image);

		//  Handle image upload

		if ( $character->image == $request->image ) {
			// No change to image, skip
			$character->fill($validatedData);
		} else if ($request->image) {
			// Image provided, move to permanent location
			$character->fill($validatedData);
			$character->image = $this->uploadService->moveToPermanent(
				$request->image,
				"characters",
				$character->slug ?: strtolower(str_replace(' ', '-', $request->name))
			);
		} else {
			// No image provided, delete existing image and set to null
			Storage::delete($character->image);
			$character->fill($validatedData);
			$character->image = null;
		}

		//  Handle custom fields

		//  TODO: Check to see why this is not working.
		// dd($validatedData['custom_fields']);

		foreach ($validatedData['custom_fields'] as $field) {
			if (empty($field['value'])) {

				//  Delete custom field value
				CustomFieldValue::where([
					'entity_id' => $character->id,
					'custom_field_id' => $field['id']
				])->delete();

			} else {

				//  Create the new custom field
				CustomFieldValue::updateOrCreate(
					[
						'entity_id' => $character->id,
						'custom_field_id' => $field['id']
					],
					[
						'value' => $field['value']
					]
				);
				
			}
		}

		// Redirect user to new character page.
		
		$character->update();
		return Redirect::route("characters.show", [
			'character' => $character->slug
		]);
	}

	/**
	 * Handle an incoming delete character request.
	 *
	 * @return \Illuminate\Http\RedirectResponse
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
		
		Session::flash('message', "<strong>{$character->name}</strong> has been deleted.");
		$character->delete();
		 
		return Redirect::route("characters");
	}





	public function customfields(Request $request): Response
	{
		return Inertia::render('CustomFields/Index');
	}

	public function settings(Request $request): Response
	{
		return Inertia::render('Characters/Settings');
	}


	// public function storeFile(Request $request, Character $character): string|null
	// {
	// 	if (!$request->input('image')) { return null; }

	// 	$userId = Auth::user()->id;
	// 	$projectId = Auth::user()->active_project;
		
	// 	$tempPath = $request->input('image');
	// 	$tempPath = str_replace('/storage/', '', $tempPath);

	// 	$newPath = str_replace(
	// 		"temp/",
	// 		"users/$userId/projects/$projectId/characters/$character->id/",
	// 		$tempPath
	// 	);

	// 	Storage::disk('public')->move($tempPath, $newPath);
	// 	return Storage::url($newPath);
	// }







}