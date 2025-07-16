<?php

namespace App\Http\Controllers;

use App\Http\Resources\FactionResource;
use App\Http\Requests\StoreFactionRequest;
use App\Http\Requests\UpdateFactionRequest;
use App\Models\Faction;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class FactionController extends Controller
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

    public function index()
    {
		return Inertia::render('Factions/Index');
    }

    public function create()
    {
        return Inertia::render('Factions/Create');
    }

	public function settings(StoreFactionRequest $request)
    {
    	return Inertia::render('Factions/Settings');
    }

    public function store(StoreFactionRequest $request)
    {
        //
    }

    public function show(Faction $faction)
    {
		$faction->load([
			'members',
			'ranks'
		]);
        return Inertia::render('Factions/Show', [
			'faction' => new FactionResource($faction),
		]);
    }

    public function edit(Faction $faction)
    {
        $faction->load([
			'members',
			'ranks'
		]);
        return Inertia::render('Factions/Edit', [
			'faction' => new FactionResource($faction),
		]);
    }

    public function update(Request $request, Faction $faction)
    {
        // Validate user request
		$validatedData = $request->validate($this->validationRules);
		$faction->fill($validatedData);

		//	Move temporary image to permanent location.
		$faction->image = $this->uploadService->moveToPermanent(
			$request->image,
			Auth::user()->email."/factions",
			$faction->slug ?: strtolower(str_replace(' ', '-', $request->name))
		);

		// Redirect user to new character page.
		
		$faction->update();

		return Redirect::route("factions.show", [
			'faction' => $faction->slug
		]);
    }

    public function destroy(Faction $faction)
    {
        //
    }
}