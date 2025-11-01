<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\CustomFieldResource;
use App\Http\Resources\LocationResource;
use App\Http\Requests\StoreLocationRequest;
use App\Models\Collection;
use App\Models\CustomField;
use App\Models\Location;
use App\Services\MediaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
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
		'name'					=> ['sometimes', 'string'],
		'description'			=> ['nullable',  'string'],
		'starred'				=> ['sometimes', 'boolean'],

		'media'  				=> ['sometimes', 'array'],
		'media.*.name'			=> ['nullable',	 'string'],
		'media.*.path'			=> ['nullable',	 'string'],
		'media.*.type'			=> ['required',	 'string', 'in:banner,gallery,icon,map'],
		'media.*.url'			=> ['nullable',	 'string'],

		'custom_fields' 	  	=> ['sometimes', 'array'],
		'custom_fields.*.id'    => ['required',  'string', 'uuid', 'distinct', 'exists:custom_fields,id'],
		'custom_fields.*.value' => ['nullable',  'string']
	];

	/**
	 * INDEX
	 * 
	 * Show the list of Characters
	 */

    public function index()
    {
		$locationTypes = Location::where(
			'project_id', Auth::user()->active_project
		)->distinct()->orderBy('type')->pluck('type')->filter()->values()->all();

		$collections = Collection::where([
			'project_id' => Auth::user()->active_project,
			'collection_type' => Location::class
		])->with(['items'])->get();

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'faction'
		])->with('options')->get();

		// $worldTree = Location::where([
		// 	'project_id'   => Auth::user()->active_project,
		// 	'is_world_map' => true
		// ])->with(['image', 'media'])->first();

        return Inertia::render('Locations/Index', [
			'locationTypes' => $locationTypes,
			'collections'	=> CollectionResource::collection($collections),
			'customFields'	=> CustomFieldResource::collection($customFields),
			// 'worldTree'		=> new LocationResource($worldTree)
		]);
    }
	public function collections()
	{
		$collections = Collection::where([
			'project_id' => Auth::user()->active_project,
			'collection_type' => Location::class
		])->with(['items'])->get();

		return Inertia::render('Locations/Collections', [
			'collections'	=> CollectionResource::collection($collections),
		]);
	}

	/**
	 * CREATE / STORE
	 * 
	 * When a LocationCreateRequest is received, it will be handled by the Store
	 * method in the LocationController. The user will likely only be submitting
	 * a name to initially create a Location.
	 */

    public function create() {}
    public function store(Request $request)
    {
        $validatedData = $request->validate($this->validationRules);
		$location = Auth::user()->activeProject()->locations()->create($validatedData);
		$location->save();
		Session::flash('success', "$location->name created successfully.");
		return Redirect::route("locations.show", [
			'location' => $location->slug
		]);
    }


	/**
	 * SHOW
	 * 
	 * Render the Location entity page for the requested Location.
	 */

	public function show(Location $location)
	{
		$location->load([
			'image',
			'media',
			'mapData.location.media',
			// 'parent',
			// 'children.banner',
			'characters.image',
		]);

		return Inertia::render('Locations/Show', [
			'location' => new LocationResource($location),
		]);
    }


	/**
	 * EDIT / UPDATE
	 * 
	 * When a LocationUpdateRequest is received, it will be handled by the Update
	 * method in the LocationController. The user may submit any piece of
	 * Location model to update, and so it must be updated on a per-item basis.
	 */

    public function edit(Location $location) {}
    public function update(Request $request, Location $location)
    {
		
		$validatedData = $request->validate($this->validationRules);

		//	Handle media
		if ($request->has('media')) {
			if ( empty($request['media']) ) {
				// If the media array is empty, remove all media from this location.
			} else {
				foreach ($request['media'] as $media) {
					$this->mediaService->attachMedia($location, $media['type'], $media);
				}
			}
		}

		if ($request->has('custom_fields')) {
			// $this->handleCustomFields($validatedData['custom_fields'], $character);
		}

		unset($validatedData['media']);

		$location->fill($validatedData);
		$location->update();

		Session::flash('success', "$location->name was updated.");
		return Redirect::back();
    }


	/**
	 * DELETE
	 * 
	 * Remove the entity and all associated data from the database.
	 * Locations have soft-deletes, meaning they can be restored.
	 */

    public function destroy(Request $request, Location $location)
    {
		//	TODO:	Make sure logged in user is authorized before proceeding.

		Session::flash('success', "$location->name has been deleted.");
		$location->delete();
		return Redirect::back();
    }

	public function settings(Request $request): Response
    {
    	return Inertia::render('Locations/Settings');
    }
}