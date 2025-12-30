<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\CustomFieldValue;
use App\Models\Faction;
use App\Models\Location;
use App\Models\Project;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class BrawllywoodSeeder extends Seeder
{

	/**
     * Seed the application's database.
     */
    public function run($projects): void
    {


		/**
		 * Create Custom Fields
		 */

		$classMap = [
			'character' => Character::class,
			'faction'	=> Faction::class,
			'location'	=> Location::class
		];

		$fields = [];
		$json = File::get(database_path('data/brawllywood/custom_fields.json'));
		$json_fields = json_decode($json, true);
		foreach($json_fields as $slug => $field) {
			$fields[$slug] = CustomField::create([
				'project_id' => $projects['brawllywood']->id,
				'fieldable_type' => $classMap[$field['fieldable_type']],
				'type' => $field['type'],
				'name' => $field['name'],
				'label' => $field['label'],
				'description' => $field['description'] ?? null,
				'placeholder' => $field['placeholder'] ?? null,
				'required' => $field['required'] ?? false
			]);
		}

		/**
		 * Populate Custom Field Options
		 */

		$language_list = [];
		$json = File::get(database_path('data/brawllywood/language.json'));
		$json_language = json_decode($json, true);
		foreach ($json_language as $slug => $language) {
			$language_list[$slug] = CustomFieldOption::create([
				'custom_field_id' => $fields['language']->id,
				'value'           => $slug,
				'label'           => $language['name'],
			]);
		}
		


		/**
		 * LOCATIONS
		 */

		$locations = [];
		$json = File::get(database_path('data/brawllywood/locations.json'));
		$json_locations = json_decode($json, true);
		foreach ($json_locations as $slug => $location) {
			$locations[$slug] = Location::create([
				'project_id'  => $projects['brawllywood']->id,
				// 'parent_location_id' => null,
				'name'        => $location['name'],
				'type'        => $location['type'] ?? null,
				'icon'		  => $location['icon'] ?? null,
				'slug'        => $slug,
				'description' => $location['desc'] ?? null,
				// 'coordinates_x' => $location['coordinates']['x'] ?? null,
				// 'coordinates_y' => $location['coordinates']['y'] ?? null,
				'is_world_map'  => $location['is_world_map'] ?? false,
			]);
		}


		//	CHARACTERS

		$characters = [];
		$json = File::get(database_path('data/brawllywood/characters.json'));
		$json_characters = json_decode($json, true);

		foreach ($json_characters as $slug => $character) {
			$characters[$slug] = Character::factory()->create([
				'project_id'  => $projects['brawllywood']->id,
				'slug'        => $slug,
				'name'        => $character['name'],
				'description' => $character['description'],
			]);
			if ($character['from']) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['from']->id,
					'value'           => $character['from'],
				]);
			}
			if ($character['actor']) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['actor']->id,
					'value'           => $character['actor'],
				]);
			}
			if ($character['language']) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['language']->id,
					'value'           => $character['language'],
				]);
			}
		}
	}
}