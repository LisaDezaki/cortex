<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Media;
use App\Models\Project;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
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
		'name' 		  	=> ['sometimes', 'string', 'max:255'],
		'type' 		  	=> ['nullable',  'string'],
		'description' 	=> ['nullable',  'string'],

		'media'			=> ['sometimes', 'array'],
		'media.*.name'	=> ['nullable',	 'string'],
		'media.*.path'	=> ['nullable',  'string'],
		'media.*.type'	=> ['required',  'string', 'in:banner,gallery,map'],
		'media.*.url'	=> ['nullable',  'string']
	];

	public function validate(Request $request)
	{
		$rules = [
            'name' 		  	=> ['sometimes', 'string', 'max:255'],
			'type' 		  	=> ['nullable',  'string'],
			'description' 	=> ['nullable',  'string'],

			'media'			=> ['sometimes', 'array'],
			'media.*.name'	=> ['nullable',	 'string'],
			'media.*.path'	=> ['nullable',  'string'],
			'media.*.type'	=> ['required',  'string', 'in:banner,gallery,map'],
			'media.*.url'	=> ['nullable',  'string']
        ];
		return $request->validate($rules);
	}

	/**
	 * INDEX
	 * 
	 * Show the list of Characters
	 */

	public function index(): Response
    {
        return Inertia::render('Projects/Index');
    }

	/**
	 * CREATE / STORE
	 * 
	 * When a LocationCreateRequest is received, it will be handled by the Store
	 * method in the LocationController. The user will likely only be submitting
	 * a name to initially create a Location.
	 */

	public function create() {}
	public function store(Request $request): RedirectResponse
    {
		//	Attempt to validated the $request
		//	Flash an error if validation fails
		try {
			$validatedData = $request->validate($this->validationRules);
		} catch (\Exception $e) {
			Session::flash('error', "Validation failed: ".$e);
        	return Redirect::back();
		}

        // $validatedData = $this->validate($request);
		$project = Auth::user()->projects()->create($validatedData);
		$project->save();
		Session::flash('success', "$request->name created successfully.");
		return Redirect::route("dashboard");
    }

	public function show(Request $request, Project $project)
	{
		$project->load([
			'characters',
			'locations',
			'factions'
		]);

		return Inertia::render('Projects/Show', [
			"project" => new ProjectResource($project)
		]);
	}

	/**
	 * EDIT / UPDATE
	 * 
	 * When a CharacterUpdateRequest is received, it will be handled by the Update
	 * method in the CharacterController. The user may submit any piece of
	 * Character model to update, and so it must be updated on a per-item basis.
	 */

	public function edit(Project $project) {}
    public function update(Request $request, Project $project)
    {
		//	Attempt to validated the $request
		//	Flash an error if validation fails
		try {
			$validatedData = $request->validate($this->validationRules);
		} catch (\Exception $e) {
			Session::flash('error', "Validation failed: ".$e);
        	return Redirect::back();
		}
		// $validatedData = $this->validate($request);

		if ($request->has('media')) {
			foreach ($request['media'] as $media) {
				$this->mediaService->attachMedia($project, $media['type'], $media);
			}
			unset($validatedData['media']);
		}

		$project->fill($validatedData);
		$project->update();

		Session::flash('success', "$project->name updated successfully.");
        return Redirect::route("dashboard");
    }

	/**
	 * DESTROY
	 * 
	 */

	public function destroy(Request $request, Project $project): RedirectResponse
    {
		$validator = Validator::make($request->all(), [
			'confirm_name' => ['required', 'string', 'in:'.$project->name],
		], [
			'confirm_name.required' => 'For security reasons, you must type the name of the project in order to delete it.',
			'confirm_name.in' => 'The entered name does not match the project you\'re trying to delete. Are you having second thoughts?',
		]);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}

		$project->delete();
		Session::flash('success', "$project->name project deleted successfully.");
        return Redirect::route('dashboard');
    }

	public function dashboard(): Response
    {
        return Inertia::render('Dashboard');
    }

	public function settings()
	{
		return Inertia::render('Projects/Settings');
	}

	public function activate(Project $project)
	{
		$user = Auth::user();
		if ($user->id === $project->user_id) {
			$user->active_project = $project->id;
			$user->update();
		}

		// Session::flash('success', "Project activated: $project->name");
        return Redirect::back();
	}
	
	public function deactivate()
	{
		$user = Auth::user();
		$user->active_project = null;
		$user->update();

		// Session::flash('success', "Project deactivated.");
        return Redirect::route('dashboard');
	}
	
}