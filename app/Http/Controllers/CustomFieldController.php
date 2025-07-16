<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CustomFieldController extends Controller
{


	protected $validationRules = [
		'entity_type' => ['required', 'in:character'],
		'type'        => ['string', 'required', 'in:text,number,range,switch,select,entity,upload'],
		'name'        => ['string', 'required'],
		'label'       => ['string', 'nullable'],
		'placeholder' => ['string', 'nullable'],
		'description' => ['string', 'nullable'],
		'required'    => ['boolean'],
		'options'     => ['array', 'nullable', 'min:2', 'required_if:type,select'], // At least 2 items
    	'options.*'   => ['string', 'distinct'] // Each item must be a unique string
	];


	/**
     * Display a listing of the characters.
     *
	 * @return \Inertia\Response
	 */
	public function index(): Response|RedirectResponse
	{
		$project = Auth::user()->activeProject();
		if (!$project) {
			return Redirect::route("dashboard");
		}
		$custom_fields = $project->customFields()->with('options')->get();
		return Inertia::render('CustomFields/Index', [
			'custom_fields' => $custom_fields
		]);
	}



	/**
	 * Display the character creation view.
	 *
	 * @return \Inertia\Response
	 */
	public function create(): Response
	{
		return Inertia::render('CustomFields/Create');
	}



	/**
	 * Handle an incoming character creation request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 */
	public function store(Request $request)
	{
		//  Validate custom field data
		$validatedData = $request->validate($this->validationRules);
		$fieldOptions  = $validatedData['options'];
		
		//  Create the new custom field
		$field              = new CustomField($validatedData);
		$field->project_id  = Auth::user()->active_project;
		$field->label       = $field->label       ?: $field->name;
		$field->placeholder = $validatedData['placeholder'] ?: null;
		unset($field->options);
		$field->save();

		if ($fieldOptions && $field->type == 'select') {

			dd($fieldOptions);

			foreach ($fieldOptions as $option) {

				// CustomFieldOption::updateOrCreate([
				// 	'custom_field_id' => $field->id,
				// 	'label' => $option
				// ], [
				// 	'value' => Str::slug($option)
				// ]);

				$field_option = new CustomFieldOption();
				$field_option->custom_field_id = $field->id;
				$field_option->label = $option;
				$field_option->value = Str::slug($option);
				$field_option->save();
			}
		}

		return Inertia::render('customfields', [
			'success' => true,
			'message' => 'Field created!',
		]);

		// return Redirect::route("customfields");

		// switch ($request->type) {
		// 	case 'text':
		// 		dd($request);
		// 		// break;
		// 	case 'select':
		// 		dd($request);
		// 		// break;
		// 	case 'number':
		// 		dd($request);
		// 		// break;
		// 	case 'range':
		// 		dd($request);
		// 		// break;
		// }

		// Validate user request.
		// $validatedData = $request->validate($this->validationRules);

		//	Create the new character.
		
		// $character->project_id = Auth::user()->active_project;

		//	Move temporary image to permanent location.
		// $character->image = $this->storeFile($request, $character);
		
		// Redirect user to new character page.
		// $character->save();
		// return Redirect::route("characters.show", [
		// 	'character' => $character->slug
		// ]);
	}


	/**
	 * Handle an incoming character update request.
	 *
	 * @param  \App\Models\Character  $character
	 * @param  \Illuminate\Http\Request  $request
	 */

	public function update(CustomField $field, Request $request)
	{
		$validatedData = $request->validate($this->validationRules);
		$fieldOptions  = $validatedData['options'];

		$field->fill($validatedData);
		$field->label       = $field->label       ?: $field->name;
		$field->placeholder = $validatedData['placeholder'] ?: null;
		unset($field->options);

		$field->save();

		if ($field->type == 'select' && $fieldOptions) {
			CustomFieldOption::where('custom_field_id', $field->id)->delete();
			foreach ($fieldOptions as $option) {

				// TODO: remove all options before adding them back
				// CustomFieldOption::updateOrCreate([
				// 	'custom_field_id' => $field->id,
				// 	'label' => $option,
				// 	'value' => Str::slug($option)
				// ]);
				$field_option = new CustomFieldOption();
				$field_option->custom_field_id = $field->id;
				$field_option->label = $option;
				$field_option->value = Str::slug($option);
				$field_option->save();
			}
		}

		// if ($field->type && $options) {
		// 	foreach ($options as $option) {
		// 		$field_option = new CustomFieldOption();
		// 		$field_option->custom_field_id = $field->id;
		// 		$field_option->label = $option;
		// 		$field_option->value = Str::slug($option);
		// 		$field_option->save();
		// 	}
		// }

		return Inertia::render('customfields', [
			'success' => true,
			'message' => 'Field created!',
		]);
		
		// return Redirect::route("customfields");



		// Validate user request
		// $validatedData = $request->validate($this->validationRules);
		// $character->fill($validatedData);

		//	Move temporary image to permanent location.
		// $character->image = $this->storeFile($request, $character);

		// Redirect user to new character page.
		// $character->update();
		// return Redirect::route("characters.show", [
		// 	'character' => $character->slug
		// ]);
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


	public function storeFile(Request $request, Character $character): string|null
	{
		if (!$request->input('image')) { return null; }

		$userId = Auth::user()->id;
		$projectId = Auth::user()->active_project;
		
		$tempPath = $request->input('image');
		$tempPath = str_replace('/storage/', '', $tempPath);

		$newPath = str_replace(
			"temp/",
			"users/$userId/projects/$projectId/characters/$character->id/",
			$tempPath
		);

		Storage::disk('public')->move($tempPath, $newPath);
		return Storage::url($newPath);
	}







}