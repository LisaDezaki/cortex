<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
		$user = User::factory()->create([
			'name' => 'Administrator',
			'email' => 'admin@example.com',
		]);

		/*	PROJECTS  */

		$projects = [];
		$json = File::get(database_path('data/projects.json'));
		$json_projects = json_decode($json, true);
		foreach ($json_projects as $slug => $project) {
			$projects[$slug] = Project::create([
				'user_id' => $user->id,
				'name'    => $project['name'],
				'type'    => $project['type'],
				'description' => $project['description']
			]);
		}

		$this->callWith( TabletonSeeder::class,    ['projects' => $projects] );
		$this->callWith( BrawllywoodSeeder::class, ['projects' => $projects] );
		$this->callWith( MarvelSeeder::class,      ['projects' => $projects] );
    }
}