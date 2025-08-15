<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\CustomFieldValue;
use App\Models\Faction;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class MarvelSeeder extends Seeder
{
    public function run($projects): void
    {

		/**
		 * CHARACTERS
		 */

		$characters = [];
		$json = File::get(database_path('data/marvel/characters.json'));
		$json_characters = json_decode($json, true);

		foreach ($json_characters as $slug => $character) {
			$characters[$slug] = Character::factory()->create([
				'project_id'  => $projects['marvel']->id,
				'name'        => $character['name'],
				'alias'        => $character['alias'],
				'slug'        => $slug,
				'description' => $character['desc'] ?? null,
			]);
		}
	}
}