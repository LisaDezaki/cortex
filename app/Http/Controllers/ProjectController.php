<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\FileUploadService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
	protected $uploadService;

	public function __construct(FileUploadService $uploadService)
	{
		$this->uploadService = $uploadService;
	}

    /**
     * Display the user's list of projects.
     */
	public function index(): Response
    {
        return Inertia::render('Projects/Index');
    }


	/**
     * Display a specific project's details.
     */
	public function show(Request $request, Project $project): Response
	{
		$project->load([
			'characters',
			'characters.location',
			'characters.factions',
			'characters.relationships',
			'characters.inverseRelationships',
			// 'characters.customFields',
			// 'characters.customFieldValues',
			// 'characters.customFieldOptions',
			'factions',
			'factions.members',
			'locations',
			'customFields',
			'customFields.options',
		]);

		return Inertia::render('Projects/Show', [
			'project' => new ProjectResource($project)
		]);
	}


	/**
     * Display a specific project's update form.
     */
	// public function edit(Request $request, Project $project): Response
	// {
	// 	return Inertia::render('Projects/Edit', [
	// 		'project' => $project
	// 	]);
	// }


	/**
     * Display the Create New Project view.
     */
	// public function create(Request $request): RedirectResponse
    // {
	// 	$project = Auth::user()->projects()->create();
	// 	$project->save();
	// 	return Redirect::route("projects.edit", [
	// 		'project' => $project->id
	// 	]);
    // }


	/**
     * Store a new project in the database.
     */
    public function store(Request $request): RedirectResponse
    {
		//	Validate form data and create the project.
        $validatedData = $this->validate($request);
		$project = Auth::user()->projects()->create($validatedData);

		//	Move temporary image to permanent location.
		if ($request->image) {
			$project->image = $this->uploadService->moveToPermanent(
				$request->image,
				null,
				strtolower(str_replace(' ', '-', $project->name))
			);
		}
		
		//	Save project and redirect to new project page.
		$project->save();
		return Redirect::route("projects.show", [
			'project' => $project->id
		]);
    }


	/**
     * Update an existing project in the database.
     */
    public function update(Request $request, Project $project): RedirectResponse
    {
		//	Validate form data
        $validatedData = $this->validate($request, $project);
		$project->fill($validatedData);

		//	Move temporary image to permanent location
		// $project->image = $this->storeFile($request, $project);
		if ($request->image) {
			$project->image = $this->uploadService->moveToPermanent(
				$request->image,
				null,
				strtolower(str_replace(' ', '-', $project->name))
			);
		}
		//	Update project and return to project page
		$project->update();
        return Redirect::route("projects.show", [
			'project' => $project->id
		]);
    }


	public function destroy(Request $request, Project $project): RedirectResponse
    {
		//	Authorization
		// if (! $request->user()->can('delete', $project)) {
		// 	abort(403, 'Unauthorized to delete this project.');
		// }

		$request->validate([
			'confirm_name' => 'required|string'
		]);
	
		if ($request->confirm_name !== $project->name) {
			return Redirect::back()->withErrors([
				'confirm_name' => 'The entered name does not match the project you\'re trying to delete.'
			]);
		}

		//	Remove image
		// $this->deleteImage($project);

		// Delete project
		$project->delete();

        return Redirect::route('projects');
    }

	public function activate(Project $project, Request $request)
	{
		$user = Auth::user();
		if ($project->user_id = $user->id) {
			$user->active_project = $project->id;
			$user->update();
		}
		return Inertia::location(url()->previous());
	}

	
	public function deactivate(Request $request)
	{
		$user = Auth::user();
		$user->active_project = null;
		$user->update();
		return Inertia::location(url()->previous());
	}

	public function validate(Request $request, Project $project = null) {

		$rules = [
            'name' => ['nullable', 'max:255'],
            'description' => ['nullable'],
            'image' => ['nullable', 'string'],
        ];

		return $request->validate($rules);

	}

	// public function storeFile(Request $request, Project $project): string|null
	// {
	// 	if (!$request->input('image')) { return null; }

	// 	$userId = Auth::user()->id;
		
	// 	$tempPath = $request->input('image');
	// 	$tempPath = str_replace('/storage/', '', $tempPath);

	// 	$newPath = str_replace(
	// 		"temp/",
	// 		"users/$userId/projects/$project->id/",
	// 		$tempPath
	// 	);

	// 	Storage::disk('public')->move($tempPath, $newPath);
	// 	return Storage::url($newPath);
	// }

	// public function storeFile(Request $request, Project $project, bool $replace = false): string {

	// 	if ($replace) {
    //         $this->deleteImage($project);
    //     }

    //     $path = $request->file('file')->store('projects', 'public');
    //     // $project->update(['image' => "/storage/{$path}"]);
	// 	return $path;
	// }

	// public function deleteImage(Project $project): void {

	// 	// If the project has an image path stored...
	// 	if ($project->image) {
	// 		// Remove the /storage/ prefix to get the relative path on the disk
	// 		$imagePath = str_replace('/storage/', '', $project->image);
	// 		// Specify the disk and delete the file
	// 		Storage::disk('public')->delete($imagePath);
	// 	}

	// }
}