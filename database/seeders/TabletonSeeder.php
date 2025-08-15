<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\CustomFieldValue;
use App\Models\Faction;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TabletonSeeder extends Seeder
{
    public function run($projects): void
    {


		/**
		 * Create Custom Fields
		 */

		$fields = [];
		$json = File::get(database_path('data/tableton/custom_fields.json'));
		$json_fields = json_decode($json, true);
		foreach($json_fields as $slug => $field) {
			$fields[$slug] = CustomField::create([
				'project_id' => $projects['tableton']->id,
				'fieldable_type' => $field['fieldable_type'],
				'type' => $field['type'],
				'name' => $field['name'],
				'label' => $field['label'],
				'description' => $field['description'] ?? null,
				'placeholder' => $field['placeholder'] ?? null,
				'required' => $field['required'] ?? false
			]);
		}

		// $species_field = CustomField::create([
		// 	'project_id' => $projects['tableton']->id,
		// 	'fieldable_type' => 'character',
		// 	'type' => 'select',
		// 	'name' => 'species',
		// 	'label' => 'Species',
		// 	'description' => 'What species does this character belong to?',
		// 	'placeholder' => 'Select a species...',
		// 	'required' => false
		// ]);

		/**
		 * Populate Custom Field Options
		 */

		$species_list = [];
		$json = File::get(database_path('data/tableton/species.json'));
		$json_species = json_decode($json, true);
		foreach ($json_species as $slug => $species) {
			$species_list[$slug] = CustomFieldOption::create([
				'custom_field_id' => $fields['species']->id,
				'value'           => $slug,
				'label'           => $species['name'],
			]);
		}



		/**
		 * LOCATIONS
		 */

		$locations = [];
		$json = File::get(database_path('data/tableton/locations.json'));
		$json_locations = json_decode($json, true);
		foreach ($json_locations as $slug => $location) {
			$locations[$slug] = Location::create([
				'project_id'  => $projects['tableton']->id,
				'parent_location_id' => null,
				'name'        => $location['name'],
				'type'        => $location['type'] ?? null,
				'icon'		  => $location['icon'] ?? null,
				'slug'        => $slug,
				'description' => $location['desc'] ?? null,
				'coordinates_x' => $location['coordinates']['x'] ?? null,
				'coordinates_y' => $location['coordinates']['y'] ?? null,
				'is_world_map'  => $location['is_world_map'] ?? false,
			]);
		}

		foreach ($json_locations as $slug => $location) {

			if (isset($location['parent'])) {

				$id = $locations[$slug]->id;
				$parentSlug = $location['parent'];
				$parentId = $locations[$parentSlug]->id;
	
				DB::table('locations')->where([
					'id' => $id,
				])->update([
					'parent_location_id' => $parentId
				]);
			}
		}



		



		/**
		 * CHARACTERS
		 */

		$characters = [];
		$json = File::get(database_path('data/tableton/characters.json'));
		$json_characters = json_decode($json, true);

		foreach ($json_characters as $slug => $character) {
			$characters[$slug] = Character::factory()->create([
				'project_id'  => $projects['tableton']->id,
				'name'        => $character['name'],
				'alias'        => $character['alias'],
				'slug'        => $slug,
				'description' => $character['desc'],
				'location_id' => isset($character['location']) ? $locations[$character['location']]->id : null,
			]);
			if ($character['species']) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['species']->id,
					'value'           => $character['species'],
				]);
			}
		}



		/**
		 * FACTIONS
		 */

		$factions = [];
		$ranks = [];
		$json = File::get(database_path('data/tableton/factions.json'));
		$json_factions = json_decode($json, true);
		foreach ($json_factions as $slug => $faction) {
			$factions[$slug] = Faction::factory()->create([
				'project_id'      => $projects['tableton']->id,
				'name'            => $faction['name'],
				'type'            => $faction['type'],
				'slug'            => $slug,
				'description'     => $faction['desc'],
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



		/**
		 * RELATIONSHIPS
		 */

		$relationships = [];
		$json = File::get(database_path('data/tableton/relationships.json'));
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