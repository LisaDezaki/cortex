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
		'name'			=> ['sometimes', 'string'],
		'description'	=> ['nullable',  'string'],
		'banner'		=> ['nullable',  'string'],
		'icon'			=> ['nullable',  'string'],
		'map'			=> ['nullable',  'string'],

		'media'  		=> ['sometimes', 'array'],
		'media.*'		=> ['present',   'distinct'],
		'media.*.path'	=> ['required'],
		'media.*.type'	=> ['required',  'string', 'in:banner,icon,map'],

		'custom_fields' 	  	=> ['sometimes', 'array'],
        'custom_fields.*'     	=> ['present', 'distinct'],
		'custom_fields.*.id'    => ['required', 'distinct', 'exists:custom_fields,id'],
		'custom_fields.*.value' => ['nullable', 'string']
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

    public function create() {}
    public function store(StoreLocationRequest $request)
    {
        $validatedData = $request->validate($this->validationRules);
		$location = Auth::user()->activeProject()->locations()->create($validatedData);

		if ($request->has('banner')) {
			$this->mediaService->attachMedia($location, 'banner', $request->banner);
			unset($validatedData['banner']);
		}

		if ($request->has('map')) {
			$this->mediaService->attachMedia($location, 'map', $request->map);
			unset($validatedData['map']);
		}

		// $this->handleCustomFields($validatedData['custom_fields'], $location);
		$location->save();
		return Redirect::route("locations.show", [
			'location' => $location->slug
		]);
    }

	public function show(Location $location)
	{
		$location->load([
			'media',
			'parent',
			'children.banner',
			'characters.portrait',
		]);

		return Inertia::render('Locations/Show', [
			'location' => new LocationResource($location),
		]);
    }

    public function edit(Location $location) {}
    public function update(Request $request, Location $location)
    {
		$validatedData = $request->validate($this->validationRules);
		
		//	Handle media
		if ($validatedData['media']) {
			foreach ($validatedData['media'] as $media) {
				$this->mediaService->attachMedia($location, $media['type'], $media['path']);
			}
			unset($validatedData['media']);
		}

		// $this->handleCustomFields($validatedData['custom_fields'], $location);

		$location->fill($validatedData);
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
}
