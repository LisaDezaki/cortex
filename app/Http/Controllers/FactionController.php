<?php

namespace App\Http\Controllers;

use App\Http\Resources\FactionResource;
use App\Http\Requests\StoreFactionRequest;
use App\Http\Requests\UpdateFactionRequest;
use App\Models\CustomField;
use App\Models\Faction;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

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
		$custom_fields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'customfieldable_type' => 'faction'
		])->with('options')->get();

		return Inertia::render('Factions/Index', [
			'custom_fields' => $custom_fields
		]);
    }

    public function create()
    {
        return Inertia::render('Factions/Create');
    }

	public function settings(Request $request): Response
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
			'ranks',
			'headquarters'
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