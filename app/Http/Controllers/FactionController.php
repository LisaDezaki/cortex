<?php

namespace App\Http\Controllers;

use App\Http\Resources\FactionResource;
use App\Http\Resources\CustomFieldResource;
use App\Http\Requests\StoreFactionRequest;
use App\Http\Requests\UpdateFactionRequest;
use App\Models\CustomField;
use App\Models\Faction;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class FactionController extends Controller
{

	protected $mediaService;

	public function __construct(MediaService $mediaService)
	{
		$this->mediaService = $mediaService;
	}

	protected $validationRules = [
		'name' => ['string', 'required'],
		'description' => ['string', 'nullable'],
		'emblem' => ['string', 'nullable'],
		'custom_fields' => 'sometimes|array',
        'custom_fields.*' => 'present',
		'custom_fields.*.id' => 'required|distinct|exists:custom_fields,id',
		'custom_fields.*.value' => 'nullable|string'
	];

    public function index()
    {
		$active_project = Auth::user()->active_project;
		if (!$active_project) {
			return Redirect::route('projects');
		}

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => 'faction'
		])->with('options')->get();

		return Inertia::render('Factions/Index', [
			'customFields' => CustomFieldResource::collection($customFields)
		]);
    }

    public function create()
    {
        return Inertia::render('Factions/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate($this->validationRules);
		$faction = Auth::user()->activeProject()->factions()->create($validatedData);
		$this->handleEmblem($request, $faction);
		// $this->handleCustomFields($validatedData['custom_fields'], $character);
		$faction->save();
		return Redirect::route("factions.show", [
			'faction' => $faction->slug
		]);
    }

    public function show(Faction $faction)
    {
		$faction->load([
			'emblem',
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
			'emblem',
			'members',
			'ranks'
		]);
        return Inertia::render('Factions/Edit', [
			'faction' => new FactionResource($faction),
		]);
    }

    public function update(Request $request, Faction $faction)
    {
		$validatedData = $request->validate($this->validationRules);
		$faction->fill($validatedData);
		$this->handleEmblem($request, $faction);
		// $this->handleCustomFields($validatedData['custom_fields'], $faction);
		$faction->update();
		return Redirect::route("factions.show", [
			'faction' => $faction->slug
		]);
    }

    public function destroy(Faction $faction)
    {
        //
    }

	public function settings(Request $request): Response
    {
    	return Inertia::render('Factions/Settings');
    }

	public function handleEmblem(Request $request, Faction $faction)
	{
		$request->validate([
			'emblem' => 'string|nullable',
		]);

		$user = Auth::user();
		$userDir    = "user_"   .substr($user->id, 0, 8);
		$projectDir = "project_".substr($user->active_project, 0, 8);

		$this->mediaService->updateImage(
			$faction,
			$faction->emblem(),
			$request->emblem,
			"$userDir/$projectDir/factions"
		);
	}
}