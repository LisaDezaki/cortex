<?php

namespace App\Providers;

use App\Models\Character;
use App\Models\Faction;
use App\Models\Location;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Define morph map for your entities
		// Relation::enforceMorphMap([
		// 	'user' => User::class,
		// 	'project' => Project::class,
		// 	'character' => Character::class,
		// 	'faction' => Faction::class,
		// 	'location' => Location::class,
		// ]);
    }
}
