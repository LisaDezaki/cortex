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

		$regions = [];
		$json = File::get(database_path('data/tableton/locations.json'));
		$json_locations = json_decode($json, true);
		foreach ($json_locations as $slug => $region) {
			$regionModel = Region::create([
				'project_id'  => $projects['tableton']->id,
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
					'coordinates_x' => $location['coordinates']['x'],
					'coordinates_y' => $location['coordinates']['y']
				]);
				$locations[$locationslug] = $locationModel;
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
				'slug'        => $slug,
				'description' => $character['desc'],
				'location_id' => isset($character['location']) ? $locations[$character['location']]->id : null,
			]);
			if ($character['alias']) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['alias']->id,
					'value'           => $character['alias'],
				]);
			}
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