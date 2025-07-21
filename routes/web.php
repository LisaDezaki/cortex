<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\FactionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {

	if (Auth::check()) {

		if (Auth::user()->active_project) {
			return Inertia::render('Dashboard');
		}
		return Inertia::render('Projects/Index');
	}

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/tests', function () {
    return Inertia::render('Tests');
})->middleware(['auth', 'verified'])->name('tests');

//	PROJECTS

// Route::get('/user/projects', function () {
// 	return Inertia::render('Projects/Index');
// })->middleware(['auth', 'verified'])->name('projects');

// Route::get('/user/projects/create', function () {
// 	return Inertia::render('Projects/Create');
// })->middleware(['auth', 'verified'])->name('projects.create');

//	CHARACTERS

// Route::get('/characters', function () {
// 	return Inertia::render('Characters/Index');
// })->middleware(['auth', 'verified'])->name('characters');

//	USER

Route::get('/user/settings', function () {
	return Inertia::render('User/Settings');
})->middleware(['auth', 'verified'])->name('settings');

Route::middleware(['auth', 'verified'])->group(function () {

	// Route::get(   '/',                                      [ProjectController::class, 'show' ])->name('dashboard');

	Route::post(  '/upload',                   		[ImageController::class, 'upload'   ])->name('image.upload');

	//	Project routes
    Route::get(   '/user/projects',            		[ProjectController::class, 'index'  ])->name('projects');
	Route::get(   '/user/projects/create',     		[ProjectController::class, 'create' ])->name('projects.create');
	Route::get(   '/user/projects/{project}',  		[ProjectController::class, 'show'   ])->name('projects.show');
    Route::post(  '/user/projects',            		[ProjectController::class, 'store'  ])->name('projects.store');
    Route::patch( '/user/projects/{project}',  		[ProjectController::class, 'update' ])->name('projects.update');
	Route::delete('/user/projects/{project}',  		[ProjectController::class, 'destroy'])->name('projects.destroy');
	Route::patch( '/user/projects/{project}/activate', [ProjectController::class, 'activate'])->name('projects.activate');
	Route::post(  '/user/projects/deactivate', 		[ProjectController::class, 'deactivate'])->name('projects.deactivate');

	//	Characters
	Route::get(   '/characters',					[CharacterController::class, 'index'   ])->name('characters');
	Route::get(   '/characters/create',			[CharacterController::class, 'create'  ])->name('characters.create');
	Route::get(   '/characters/settings',			[CharacterController::class, 'settings'])->name('characters.settings');
	Route::get(   '/characters/{character}',		[CharacterController::class, 'show'    ])->name('characters.show');
	Route::get(   '/characters/{character}/edit',	[CharacterController::class, 'edit'    ])->name('characters.edit');
	Route::post(  '/characters',					[CharacterController::class, 'store'   ])->name('characters.store');
	Route::patch( '/characters/{character}',		[CharacterController::class, 'update'  ])->name('characters.update');
	Route::delete('/characters/{character}',		[CharacterController::class, 'destroy' ])->name('characters.destroy');
	Route::get(   '/characters/custom-fields',		[CharacterController::class, 'customfields' ])->name('characters.customfields');

	//	Factions
	Route::get(   '/factions',             		[FactionController::class, 'index'  ])->name('factions');
	Route::get(   '/factions/create',      		[FactionController::class, 'create' ])->name('factions.create');
	Route::get(   '/factions/settings',            [FactionController::class, 'settings'])->name('factions.settings');
	Route::get(   '/factions/{faction}', 			[FactionController::class, 'show'   ])->name('factions.show');
	Route::get(   '/factions/{faction}/edit',		[FactionController::class, 'edit'   ])->name('factions.edit');
	Route::post(  '/factions',             		[FactionController::class, 'store'  ])->name('factions.store');
	Route::patch( '/factions/{faction}', 			[FactionController::class, 'update' ])->name('factions.update');
	Route::delete('/factions/{faction}', 			[FactionController::class, 'destroy'])->name('factions.destroy');
	

	//	Locations
	Route::get(   '/locations',					[LocationController::class, 'index'  ])->name('locations');
	Route::get(   '/locations/create',				[LocationController::class, 'create' ])->name('locations.create');
	Route::get(   '/locations/settings',			[LocationController::class, 'settings'])->name('locations.settings');
	Route::get(   '/locations/{location}', 		[LocationController::class, 'show'   ])->name('locations.show');
	Route::get(   '/locations/{location}/edit',	[LocationController::class, 'edit'   ])->name('locations.edit');
	Route::post(  '/locations',					[LocationController::class, 'store'  ])->name('locations.store');
	Route::patch( '/locations/{location}', 		[LocationController::class, 'update' ])->name('locations.update');
	Route::delete('/locations/{location}', 		[LocationController::class, 'destroy'])->name('locations.destroy');

	//	User Profile
    Route::get(   '/user/profile', [ProfileController::class, 'edit'   ])->name('profile.edit');
    Route::patch( '/user/profile', [ProfileController::class, 'update' ])->name('profile.update');
    Route::delete('/user/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

	//	Custom Fields
	// Route::get(  '/user/custom-fields', 		 [CustomFieldController::class, 'index'  ])->name('customfields');
	// Route::get(  '/user/custom-fields/create',  [CustomFieldController::class, 'create' ])->name('customfields.create');
	// Route::post( '/user/custom-fields', 		 [CustomFieldController::class, 'store'  ])->name('customfields.store');
	// Route::post( '/user/custom-fields/{field}', [CustomFieldController::class, 'update' ])->name('customfields.update');

});

require __DIR__.'/auth.php';