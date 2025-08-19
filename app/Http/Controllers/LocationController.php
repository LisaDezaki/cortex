<?php

namespace App\Http\Controllers;

use App\Http\Resources\CustomFieldResource;
use App\Http\Resources\LocationResource;
use App\Http\Requests\StoreLocationRequest;
use App\Models\CustomField;
use App\Models\Location;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
	protected $mediaService;

	public function __construct(MediaService $mediaService)
	{
		$this->mediaService = $mediaService;
	}

	protected $validationRules = [
		'name' => ['string', 'required'],
		'description' => ['string', 'nullable'],
		'banner' => ['string', 'nullable'],
		'map' => ['string', 'nullable'],
		'custom_fields' => 'sometimes|array',
        'custom_fields.*' => 'present',
		'custom_fields.*.id' => 'required|distinct|exists:custom_fields,id',
		'custom_fields.*.value' => 'nullable|string'
	];

    public function index()
    {
		$active_project = Auth::user()->active_project;
		if (!$active_project) {
			return Redirect::route('dashboard');
		}

		$worldTree = Location::where([
			'project_id'   => Auth::user()->active_project,
			'is_world_map' => true
		])->with(['map', 'descendants.map'])->first();
		
		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'faction'
		])->with('options')->get();

        return Inertia::render('Locations/Index', [
			'customFields' => CustomFieldResource::collection($customFields),
			'worldTree'  => new LocationResource($worldTree)
		]);
    }

    public function create()
    {
		$active_project = Auth::user()->active_project;
		if (!$active_project) {
			return Redirect::route('projects');
		}
		
		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'faction'
		])->with('options')->get();

		return Inertia::render('Locations/Create', [
			'customFields' => CustomFieldResource::collection($customFields)
		]);
    }

    public function store(StoreLocationRequest $request)
    {
        $validatedData = $request->validate($this->validationRules);
		$location = Auth::user()->activeProject()->locations()->create($validatedData);
		$this->handleBanner($request, $location);
		$this->handleMap($request, $location);
		// $this->handleCustomFields($validatedData['custom_fields'], $location);
		$location->save();
		return Redirect::route("locations.show", [
			'location' => $location->slug
		]);
    }

	public function show(Location $location)
	{
		$location->load([
			'banner',
			'parent',
			'children',
			'characters.portrait',
			'map',
		]);

		return Inertia::render('Locations/Show', [
			'location' => new LocationResource($location),
		]);
    }

    public function edit(Location $location)
    {
		$active_project = Auth::user()->active_project;
		if (!$active_project) {
			return Redirect::route('projects');
		}

        $location->load([
			'banner',
			'characters.portrait',
			'map',
		]);

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'faction'
		])->with('options')->get();

		return Inertia::render('Locations/Edit', [
			'location' => new LocationResource($location),
			'customFields' => CustomFieldResource::collection($customFields)
		]);
    }

    public function update(Request $request, Location $location)
    {
		$validatedData = $request->validate($this->validationRules);

		$location->fill($validatedData);

		$this->handleBanner($request, $location);
		$this->handleMap($request, $location);
		// $this->handleCustomFields($validatedData['custom_fields'], $location);
		unset($location->banner);
		unset($location->map);
		$location->update();
		return Redirect::route("locations.show", [
			'location' => $location->slug
		]);
    }

    public function destroy(Location $location)
    {
        //
    }

	public function settings(Request $request): Response
    {
    	return Inertia::render('Locations/Settings');
    }

	public function handleBanner(Request $request, Location $location)
	{
		$request->validate([
			'banner' => 'string|nullable',
		]);

		$user = Auth::user();
		$userDir    = "user_"   .substr($user->id, 0, 8);
		$projectDir = "project_".substr($user->active_project, 0, 8);

		$this->mediaService->updateImage(
			$location,
			$location->banner(),
			$request->banner,
			"$userDir/$projectDir/locations"
		);
	}

	public function handleMap(Request $request, Location $location)
	{
		$request->validate([
			'map' => 'string|nullable',
		]);

		$user = Auth::user();
		$userDir    = "user_"   .substr($user->id, 0, 8);
		$projectDir = "project_".substr($user->active_project, 0, 8);

		$this->mediaService->updateImage(
			$location,
			$location->map(),
			$request->map,
			"$userDir/$projectDir/locations"
		);
	}
}
