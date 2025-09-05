<?php

namespace App\Http\Controllers;

use App\Http\Resources\CollectionResource;
use App\Models\Character;
use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Faction;
use App\Models\Location;
use App\Services\MediaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class CollectionController extends Controller
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
		'name'				=> ['sometimes', 'string', 'max:255'],
		'description'		=> ['nullable',  'string'],
		'collection_type'	=> ['nullable',  'string', 'in:'.Character::class.','.Faction::class.','.Location::class],

		'items'				=> ['sometimes', 'array'],
		'items.*.id'		=> ['required',  'string'],
		'items.*.type'		=> ['required',  'string']
	];

	/**
	 * INDEX
	 * 
	 * Show the list of Characters
	 */

	public function index()
	{
		//
	}
	

	/**
	 * Display the character creation view.
	 */
	public function create() { }
	public function store(Request $request)
	{
		$type = $request['collection_type'];
		$typeMap = [
			'characters'	=> Character::class,
			'factions'		=> Faction::class,
			'locations'		=> Location::class
		];
		
		$validatedData = $request->validate($this->validationRules);
		$collection = Auth::user()->activeProject()->collections()->create($validatedData);
		$collection->collection_type = $typeMap[$type];
		$collection->save();
		Session::flash('success', "$collection->name collection created successfully.");
		return Redirect::back();
		// return back()->with([
		// 	'success' => 'Collection was saved successfully!',
		// 	'collection' => $collection,
		// ]);
	}


	/**
	 * SHOW
	 * 
	 * Render the Collection page for the requested Collection.
	 */
	public function show(Collection $collection)
	{
		$collection->load([
			'items.collectionable'
		]);

		return Inertia::render('Collections/Show', [
			'collection'  => new CollectionResource($collection),
		]);
	}


	/**
	 * Handle an incoming collection update request.
	 */
	public function edit() { }
	public function update(Collection $collection, Request $request)
	{
		$validatedData = $request->validate($this->validationRules);

		if ($request->has('items')) {
			foreach ($request['items'] as $item) {

				$collectionableType = match ($item['type']) {
					'characters'	=> Character::class,
					'factions'		=> Faction::class,
					'locations'		=> Location::class
				};
		
				CollectionItem::create([
					'collection_id' 	  => $collection->id,
					'collectionable_id'   => $item['id'],
					'collectionable_type' => $collectionableType,
					'order'				  => $item['order'] ?? 0,
					'notes'				  => $item['notes'] ?? ''
				]);
			}
		}

		$collection->fill($validatedData);
		$collection->update();
		Session::flash('success', "$collection->name collection updated successfully");
		return Redirect::back();

	}


	/**
	 * Handle an incoming delete character request.
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	 public function destroy(Request $request, Collection $collection): RedirectResponse
	 {		
		$collection->delete();
		Session::flash('success', "$collection->name collection has been deleted.");
		return Redirect::back();
	 }


}