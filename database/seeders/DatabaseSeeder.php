<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\CustomFieldValue;
use App\Models\Faction;
use App\Models\Location;
use App\Models\Project;
use App\Models\Region;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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



		//	PROJECTS

		$tableton = Project::factory()->create([
			'user_id' => $user->id,
			'name' => 'Tableton',
			'description' => 'A sprawling coastal diorama town with a rich history and a vibrant community.
							The town has recently been revitalized, attracting new residents and businesses.
							The tavern is a common gathering place, where locals and travelers share stories and laughter.'
		]);
		$deadworld = Project::factory()->create([
			'user_id' => $user->id,
			'name' => 'Deadworld',
			'description' => 'A post-apocalyptic world where survivors struggle to survive.
							The remnants of civilization are scattered across the land, with small pockets of humanity clinging to life.
							The world is filled with danger, from mutated creatures to hostile factions.'
		]);



		//	CUSTOM FIELD: SPECIES

		$species_field = CustomField::create([
			'project_id' => $tableton->id,
			'entity_type' => 'character',
			'type' => 'select',
			'name' => 'species',
			'label' => 'Species',
			'description' => 'What species does this character belong to?',
			'placeholder' => 'Select a species...',
			'required' => false
		]);

		$species_list = [];
		$json = File::get(database_path('data/species.json'));
		$json_species = json_decode($json, true);
		foreach ($json_species as $slug => $species) {
			$species_list[$slug] = CustomFieldOption::create([
				'custom_field_id' => $species_field->id,
				'value'           => $slug,
				'label'           => $species['name'],
			]);
		}


		


		//	LOCATIONS

		$regions = [];
		$json = File::get(database_path('data/locations.json'));
		$json_locations = json_decode($json, true);
		foreach ($json_locations as $slug => $region) {
			$regionModel = Region::create([
				'project_id'  => $tableton->id,
				'name'        => $region['name'],
				'slug'        => $slug,
				'description' => $region['desc']
			]);
			$regions[$slug] = $regionModel;
			foreach($region['locations'] as $locationslug => $location) {
				$locationModel = $regionModel->locations()->create([
					'name'        => $location['name'],
					'slug'        => $locationslug,
					'description' => $location['desc'],
					'image'       => "admin@example.com/Tableton/locations/".$locationslug.".png",
					'coordinates_x' => $location['coordinates']['x'],
					'coordinates_y' => $location['coordinates']['y']
				]);
				$locations[$locationslug] = $locationModel;
			}
		}

		// foreach ($json_locations as $slug => $location) {
		// 	$locations[$slug] = Location::factory()->create([
		// 		'project_id'  => $tableton->id,
		// 		'name'        => $location['name'],
		// 		'slug'        => $slug,
		// 		'description' => $location['desc'],
		// 	]);
		// }


		//	CHARACTERS

		$characters = [];
		$json = File::get(database_path('data/characters.json'));
		$json_characters = json_decode($json, true);
		
		foreach ($json_characters as $slug => $character) {
			$characters[$slug] = Character::factory()->create([
				'project_id'  => $tableton->id,
				'name'        => $character['name'],
				'subtitle'    => $character['subtitle'],
				'slug'        => $slug,
				'description' => $character['desc'],
				'image'       => "admin@example.com/Tableton/characters/".$slug.".png",
				'location_id' => isset($character['location']) ? $locations[$character['location']]->id : null,
			]);
			CustomFieldValue::create([
				'entity_id'       => $characters[$slug]->id,
				'custom_field_id' => $species_field->id,
				'value'           => $character['species'],
			]);
		}



		//	FACTIONS

		$factions = [];
		$ranks = [];
		$json = File::get(database_path('data/factions.json'));
		$json_factions = json_decode($json, true);
		foreach ($json_factions as $slug => $faction) {
			$factions[$slug] = Faction::factory()->create([
				'project_id'      => $tableton->id,
				'name'            => $faction['name'],
				'slug'            => $slug,
				'description'     => $faction['desc'],
				'image'           => "admin@example.com/Tableton/factions/".$slug.".png",
				'headquarters_id' => $faction['hq'] ? $locations[$faction['hq']]->id : null,
			]);
			$factions['ranks'] = [];
			foreach ($faction['ranks'] as $i => $rank) {
				$factions[$slug]['ranks'][$rank] = $factions[$slug]->ranks()->create([
					'order' => $i,
					'name' => $rank
				]);
			}
			foreach ($faction['members'] as $member => $rank) {
				$factions[$slug]->members()->attach($characters[$member]->id, [
					'rank_id' => $factions[$slug]['ranks'][$rank]->id
				]);
			}
		}



		//	RELATIONSHIPS

		$relationships = [];
		$json = File::get(database_path('data/relationships.json'));
		$json_relationships = json_decode($json, true);
		foreach ($json_relationships as $relationship) {
			DB::table('character_relationships')->insert([
				'id' => Str::uuid(),
				'character_id' => $characters[$relationship['character']]->id,
				'related_character_id' => $characters[$relationship['related_character']]->id,
				'character_role' => $relationship['character_role'] ?? null,
				'related_character_role' => $relationship['related_character_role'] ?? null,
				'created_at' => now(),
				'updated_at' => now(),
			]);
		}
    }
}