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

		$fields = [];
		$json = File::get(database_path('data/brawllywood/custom_fields.json'));
		$json_fields = json_decode($json, true);
		foreach($json_fields as $slug => $field) {
			$fields[$slug] = CustomField::create([
				'project_id' => $projects['brawllywood']->id,
				'fieldable_type' => $field['fieldable_type'],
				'type' => $field['type'],
				'name' => $field['name'],
				'label' => $field['label'],
				'description' => $field['description'] ?? null,
				'placeholder' => $field['placeholder'] ?? null,
				'required' => $field['required'] ?? false
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