<?php

namespace App\Http\Controllers;

use App\Http\Resources\LocationResource;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class LocationController extends Controller
{
	protected $uploadService;

	public function __construct(FileUploadService $uploadService)
	{
		$this->uploadService = $uploadService;
	}

	protected $validationRules = [
		// Standard fields
		'name' => ['string', 'required'],
		'description' => ['string', 'nullable'],
		'image' => ['string', 'nullable'],
		// Dynamic custom fields
		'custom_fields' => 'sometimes|array',
        // 'custom_fields.*.name' => 'required|string',  // Field name
        'custom_fields.*' => 'present',        // Field value (can be null)
	];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Locations/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
		return Inertia::render('Locations/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLocationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
	public function show(Location $location)
	{
		$location->load([
			'characters',
			'region'
		]);

		return Inertia::render('Locations/Show', [
			'location' => new LocationResource($location),
		]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        $location->load([
			'characters',
			'region'
		]);

		return Inertia::render('Locations/Edit', [
			'location' => new LocationResource($location),
		]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        // Validate user request
		$validatedData = $request->validate($this->validationRules);
		$location->fill($validatedData);

		//	Move temporary image to permanent location.
		$location->image = $this->uploadService->moveToPermanent(
			$request->image,
			"locations",
			$location->slug ?: strtolower(str_replace(' ', '-', $request->name))
		);

		// Redirect user to new character page.
		
		$location->update();

		return Redirect::route("locations.show", [
			'location' => $location->slug
		]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        //
    }
}
