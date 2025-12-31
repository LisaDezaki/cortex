<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\FactionController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {

	if (Auth::check()) {
		// if (Auth::user()->active_project) {
		// 	return Inertia::render('Dashboard');
		// }
		return Inertia::render('Dashboard');
	}

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});


/*	Main App Routes  */

Route::middleware(['auth', 'verified'])->group(function () {


	/*	Dashboard  */

	Route::get('/',    			     			[ProjectController::class, 'dashboard' 		])->name('dashboard');
	Route::get('/tests',             			fn () => Inertia::render('Tests')  			 )->name('tests');
	Route::get('/todo',             			fn () => Inertia::render('Todo')  			 )->name('todo');


	/*  File uploads  */

	Route::post(  '/upload-temp',    			[UploadController::class, 'uploadTemp' 		])->name('upload.temp');
	Route::post(  '/upload',         			[UploadController::class, 'moveToPermanent' ])->name('upload');
 

	/*	User  */

	Route::get(   '/profile', 					[UserController::class,    'edit'     		])->name('user.edit');
    Route::patch( '/updateProfile', 			[UserController::class,    'update'   		])->name('user.update');
    Route::delete('/profile', 					[UserController::class,    'destroy'  		])->name('user.destroy');
	Route::get(   '/settings',					[UserController::class,    'settings' 		])->name('user.settings');


	/*	Projects */
	
	Route::get(   '/projects/create',     		[ProjectController::class, 'create'    		])->name('projects.create');
    Route::post(  '/projects',            		[ProjectController::class, 'store'     		])->name('projects.store');
    Route::patch( '/projects/{project}',  		[ProjectController::class, 'update'    		])->name('projects.update');
	Route::delete('/projects/{project}',  		[ProjectController::class, 'destroy'   		])->name('projects.destroy');
    Route::get(   '/project/settings',    		[ProjectController::class, 'settings'  		])->name('projects.settings');
	Route::get(   '/projects/{project}',     	[ProjectController::class, 'show'      		])->name('projects.show');
	Route::post(  '/activate/{project}', 		[ProjectController::class, 'activate'  		])->name('projects.activate');
	Route::post(  '/deactivate', 				[ProjectController::class, 'deactivate'		])->name('projects.deactivate');


	/*	Characters  */

	Route::get(   '/characters',				[CharacterController::class, 'index'   		])->name('characters');
	Route::get(   '/characters/settings',		[CharacterController::class, 'settings'		])->name('characters.settings');
	Route::get(   '/characters/{character}',	[CharacterController::class, 'show'    		])->name('characters.show');
	Route::post(  '/characters',				[CharacterController::class, 'store'   		])->name('characters.store');
	Route::patch( '/characters/{character}',	[CharacterController::class, 'update'  		])->name('characters.update');
	Route::delete('/characters/{character}',	[CharacterController::class, 'destroy' 		])->name('characters.destroy');


	/*	Factions  */

	Route::get(   '/factions',					[FactionController::class, 'index'   		])->name('factions');
	Route::get(   '/factions/settings',			[FactionController::class, 'settings'		])->name('factions.settings');
	Route::get(   '/factions/{faction}',		[FactionController::class, 'show'    		])->name('factions.show');
	Route::post(  '/factions',					[FactionController::class, 'store'   		])->name('factions.store');
	Route::patch( '/factions/{faction}',		[FactionController::class, 'update'  		])->name('factions.update');
	Route::delete('/factions/{faction}',		[FactionController::class, 'destroy' 		])->name('factions.destroy');


	/*	Items  */

	Route::get(   '/items',						[ItemController::class, 'index'   			])->name('items');
	Route::get(   '/items/settings',			[ItemController::class, 'settings'			])->name('items.settings');
	Route::get(   '/items/{item}',				[ItemController::class, 'show'    			])->name('items.show');
	Route::post(  '/items',						[ItemController::class, 'store'   			])->name('items.store');
	Route::patch( '/items/{item}',				[ItemController::class, 'update'  			])->name('items.update');
	Route::delete('/items/{item}',				[ItemController::class, 'destroy' 			])->name('items.destroy');
	

	/*	Locations  */
	
	Route::get(   '/locations',					[LocationController::class, 'index'   		])->name('locations');
	Route::get(   '/locations/settings',		[LocationController::class, 'settings'		])->name('locations.settings');
	Route::get(   '/locations/{location}', 		[LocationController::class, 'show'    		])->name('locations.show');
	Route::post(  '/locations',					[LocationController::class, 'store'   		])->name('locations.store');
	Route::patch( '/locations/{location}', 		[LocationController::class, 'update'  		])->name('locations.update');
	Route::delete('/locations/{location}', 		[LocationController::class, 'destroy' 		])->name('locations.destroy');


	/*	Custom Fields  */

	Route::post(	'/customFields',			[CustomFieldController::class, 'store'		])->name('customFields.store');
	Route::patch(	'/customFields',			[CustomFieldController::class, 'update'		])->name('customFields.update');

});

require __DIR__.'/auth.php';