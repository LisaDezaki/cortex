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

	public function index(): Response
    {
        return Inertia::render('Projects/Index');
    }

	public function create()
	{
		//
	}

	public function store(Request $request): RedirectResponse
    {
        $validatedData = $this->validate($request);
		$project = Auth::user()->projects()->create($validatedData);
		$this->handleBanner($request, $project);
		$project->save();
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

	public function edit()
	{
		//
	}

    public function update(Request $request, Project $project)
    {
        $validatedData = $this->validate($request);
		$project->fill($validatedData);
		$this->handleBanner($request, $project);
		$project->update();
        return Redirect::route("dashboard");
    }

	public function destroy(Request $request, Project $project): RedirectResponse
    {
		//	Authorization
		// if (! $request->user()->can('delete', $project)) {
		// 	abort(403, 'Unauthorized to delete this project.');
		// }

		$validator = Validator::make($request->all(), [
			'confirm_name' => ['required', 'string', 'in:'.$project->name],
		], [
			'confirm_name.required' => 'For security reasons, you must type the name of the project in order to delete it.',
			'confirm_name.in' => 'The entered name does not match the project you\'re trying to delete. Are you having second thoughts?',
		]);

		if ($validator->fails()) {
			return Redirect::back()->withErrors($validator)->withInput();
		}
	
		// if ($request->confirm_name !== $project->name) {
		// 	return Redirect::back()->withErrors([
		// 		'confirm_name' => 'The entered name does not match the project you\'re trying to delete.'
		// 	]);
		// }

		//	Remove image
		// $this->deleteImage($project);

		// Delete project
		$project->delete();

        return Redirect::route('projects');
    }

	public function settings()
	{
		return Inertia::render('Projects/Settings');
	}

	public function handleBanner(Request $request, Project $project)
	{

		$request->validate([
			'banner' => 'string|nullable',
		]);

		$user = Auth::user();
		$userFolder    = "user_"   .substr($user->id, 0, 8);
		$projectFolder = "project_".substr($user->active_project, 0, 8);

		$this->mediaService->updateImage(
			$project,
			$project->banner(),
			$request->banner,
			"$userFolder/$projectFolder"
		);
	}

	public function activate(Project $project)
	{
		$user = Auth::user();
		if ($project->user_id = $user->id) {
			$user->active_project = $project->id;
			$user->update();
		}

		return redirect()->back()->with([
        	'test' => new ProjectResource($project)
    	]);
	}
	
	public function deactivate()
	{
		$user = Auth::user();
		$user->active_project = null;
		$user->update();
		// return Redirect::route("dashboard");
		return redirect()->back();
	}

	public function validate(Request $request)
	{

		$rules = [
            'name' 		  => ['nullable', 'max:255'],
            'description' => ['nullable'],
            'banner'      => ['nullable',
				function ($attribute, $value, $fail) {

					if (Media::where('id', $value)->exists()) {
						$fail('The ID belongs to existing media.');
						return;
					}
					
					if ($value) {
						if (!Storage::disk('public')->exists($value)) {
							$fail('The temporary file was lost.');
						}
						return;
					}
					
					$fail('The banner must be either a valid Media ID or an image file.');
            	}
			],
        ];

		return $request->validate($rules);

	}

	public function dashboard(): Response
    {
        return Inertia::render('Dashboard');
    }
}