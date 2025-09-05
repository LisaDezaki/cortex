<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Http\Resources\CustomFieldResource;
use App\Http\Resources\FactionResource;
use App\Models\Collection;
use App\Models\CustomField;
use App\Models\Faction;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class FactionController extends Controller
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
		'name'                  => ['sometimes', 'string', 'max:255'],
		'description'           => ['sometimes', 'string'],

		'media'					=> ['sometimes', 'array'],
		'media.*.name'			=> ['nullable',	 'string'],
		'media.*.path'			=> ['nullable',	 'string'],
		'media.*.type'			=> ['required',	 'string', 'in:banner,emblem,gallery'],
		'media.*.url'			=> ['nullable',	 'string'],

		'custom_fields' 	  	=> ['sometimes', 'array'],
		'custom_fields.*.id'    => ['required',  'string', 'uuid', 'distinct', 'exists:custom_fields,id'],
		'custom_fields.*.value' => ['nullable',  'string']
	];

	/**
	 * INDEX
	 * 
	 * Show the list of Factions
	 */

    public function index()
    {
		$collections = Collection::where([
			'project_id' => Auth::user()->active_project,
			'collection_type' => Faction::class
		])->with(['items'])->get();

		$customFields = CustomField::where([
			'project_id' => Auth::user()->active_project,
			'fieldable_type' => Faction::class
		])->with('options')->get();

		return Inertia::render('Factions/Index', [
			'collections'	=> CollectionResource::collection($collections),
			'customFields' => CustomFieldResource::collection($customFields)
		]);
    }
	public function collections()
	{
		$collections = Collection::where([
			'project_id' => Auth::user()->active_project,
			'collection_type' => Faction::class
		])->with(['items'])->get();

		return Inertia::render('Factions/Collections', [
			'collections'	=> CollectionResource::collection($collections),
		]);
	}


	/**
	 * CREATE / STORE
	 * 
	 * When a FactionCreateRequest is received, it will be handled by the Store
	 * method in the FactionController. The user will likely only be submitting
	 * a name to initially create a Faction.
	 */

    public function create() {}
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate($this->validationRules);
		$faction = Auth::user()->activeProject()->factions()->create($validatedData);

		// if ($request->has('emblem')) {
		// 	$this->mediaService->attachMedia($faction, 'emblem', $request->emblem);
		// 	unset($validatedData['emblem']);
		// }

		// if ($request->has('banner')) {
		// 	$this->mediaService->attachMedia($faction, 'banner', $request->banner);
		// 	unset($validatedData['banner']);
		// }

		// $this->handleCustomFields($validatedData['custom_fields'], $character);

		$faction->save();

		Session::flash('success', "$faction->name created successfully.");
		return Redirect::route("factions.show", [
			'faction' => $faction->slug
		]);
    }


	/**
	 * SHOW
	 * 
	 * Render the Character entity page for the requested Character.
	 */

    public function show(Faction $faction)
    {
		$faction->load([
			'banner',
			'emblem',
			'media',
			'members.portrait',
			'ranks',
			'headquarters'
		]);
        return Inertia::render('Factions/Show', [
			'faction' => new FactionResource($faction),
		]);
    }


	/**
	 * EDIT / UPDATE
	 * 
	 * When a FactionUpdateRequest is received, it will be handled by the Update
	 * method in the FactionController. The user may submit any piece of
	 * Faction model to update, and so it must be updated on a per-item basis.
	 */

    public function edit(Faction $faction) {}
    public function update(Request $request, Faction $faction)
    {
		$validatedData = $request->validate($this->validationRules);

		if ($request->has('media')) {
			foreach ($request['media'] as $media) {
				$this->mediaService->attachMedia($faction, $media['type'], $media);
			}
			unset($validatedData['media']);
		}

		// if ($request->has('emblem')) {
		// 	$this->mediaService->attachMedia($faction, 'emblem', $request->emblem);
		// 	unset($validatedData['emblem']);
		// }

		// if ($request->has('banner')) {
		// 	$this->mediaService->attachMedia($faction, 'banner', $request->banner);
		// 	unset($validatedData['banner']);
		// }

		if ($request->has('headquarters_id')) {
			$faction->headquarters()->associate($validatedData['headquarters_id']);
		}
		
		$faction->fill($validatedData);
		$faction->update();
		return Redirect::route("factions.show", [
			'faction' => $faction->slug
		]);
    }


	/**
	 * DELETE
	 * 
	 * Remove the entity and all associated data from the database.
	 * Factions have soft-deletes, meaning they can be restored.
	 */

    public function destroy(Faction $faction)
    {
		//	TODO:	Make sure logged in user is authorized before proceeding.
		
		Session::flash('success', "$faction->name has been deleted.");
        $faction->delete();
		return Redirect::route("factions");
    }

	public function settings(Request $request): Response
    {
    	return Inertia::render('Factions/Settings');
    }

	// public function handleBanner(Request $request, Faction $faction)
	// {
	// 	$user = Auth::user();
	// 	$userDir    = "user_"   .substr($user->id, 0, 8);
	// 	$projectDir = "project_".substr($user->active_project, 0, 8);

	// 	$this->mediaService->updateImage(
	// 		$faction,
	// 		$faction->banner(),
	// 		$request->banner,
	// 		"$userDir/$projectDir/factions"
	// 	);
	// }

	// public function handleEmblem(Request $request, Faction $faction)
	// {
	// 	$user = Auth::user();
	// 	$userDir    = "user_"   .substr($user->id, 0, 8);
	// 	$projectDir = "project_".substr($user->active_project, 0, 8);

	// 	$this->mediaService->updateImage(
	// 		$faction,
	// 		$faction->emblem(),
	// 		$request->emblem,
	// 		"$userDir/$projectDir/factions"
	// 	);
	// }
}