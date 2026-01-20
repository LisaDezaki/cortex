<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\CustomFieldValue;
use App\Models\Faction;
use App\Models\Item;
use App\Models\ItemRecipe;
use App\Models\Location;
use App\Models\MapItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class TabletopiaSeeder extends Seeder
{
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
		$mapdata = [];
		$json = File::get(database_path('data/tabletopia/custom_fields.json'));
		$json_fields = json_decode($json, true);
		foreach($json_fields as $slug => $field) {
			$fields[$slug] = CustomField::create([
				'project_id' => $projects['tabletopia']->id,
				'fieldable_type' => $classMap[$field['fieldable_type']],	//	Needs to be class
				'type' => $field['type'],
				'name' => $field['name'],
				'label' => $field['label'],
				'default' => $field['default'] ?? null,
				'description' => $field['description'] ?? null,
				'placeholder' => $field['placeholder'] ?? null,
				'required' => $field['required'] ?? false
			]);
		}


		/**
		 * Populate Custom Field Options
		 */

		$background_list = [];
		$json = File::get(database_path('data/tabletopia/background.json'));
		$json_backgrounds = json_decode($json, true);
		foreach ($json_backgrounds as $slug => $background) {
			$background_list[$slug] = CustomFieldOption::create([
				'custom_field_id' => $fields['background']->id,
				'value'           => $slug,
				'label'           => $background['name'],
			]);
		}

		$species_list = [];
		$json = File::get(database_path('data/tabletopia/species.json'));
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
		$json = File::get(database_path('data/tabletopia/locations.json'));
		$json_locations = json_decode($json, true);
		foreach ($json_locations as $slug => $location) {
			$locations[$slug] = Location::create([
				'project_id'  => $projects['tabletopia']->id,
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

		foreach ($json_locations as $slug => $location) {

			if (isset($location['mapdata'])) {
				$mapdata[$slug] = MapItem::create([
					'location_id' => $locations[$location['mapdata']['location']]['id'] ?? null,
					'mappable_type'	=> Location::class,
					'mappable_id'	=> $locations[$slug]['id'],
					'x'			  => $location['mapdata']['x'] ?? null,
					'y'			  => $location['mapdata']['y'] ?? null
				]);
			}

			if (isset($location['safehouse'])) {
				CustomFieldValue::create([
					'fieldable_id' => $locations[$slug]->id,
					'custom_field_id' => $fields['safehouse']->id,
					'value'           => $location['safehouse'],
				]);
			}

			// if (isset($location['parent'])) {

			// 	$id = $locations[$slug]->id;
			// 	$parentSlug = $location['parent'];
			// 	$parentId = $locations[$parentSlug]->id;
	
			// 	DB::table('locations')->where([
			// 		'id' => $id,
			// 	])->update([
			// 		'parent_location_id' => $parentId
			// 	]);
			// }
		}


		/**
		 * ITEMS
		 */

		$items = [];
		$json = File::get(database_path('data/tabletopia/items.json'));
		$json_items = json_decode($json, true);

		foreach ($json_items as $slug => $item) {
			$items[$slug] = Item::create([
				'project_id'	=> $projects['tabletopia']->id,
				'name'			=> $item['name'],
				'type'			=> $item['type'],
				'description'	=> $item['desc'] ?? null,
				'rarity'		=> $item['rarity'] ?? null,
				'starred'		=> $item['starred'] ?? false,
				'unique'		=> $item['unique'] ?? false,
				'cost'			=> $item['cost'] ?? null,
				'weight'		=> $item['weight'] ?? null,
				'consumable'	=> isset($item['consumable'])	? json_encode($item['consumable'])	: null,
				'craftable'		=> isset($item['craftable'])	? json_encode($item['craftable'])	: null,
				'containerable'	=> isset($item['containerable'])? json_encode($item['containerable']): null,
				'equippable'	=> isset($item['equippable'])	? json_encode($item['equippable'])	: null,
				'scrappable'	=> isset($item['scrappable'])	? json_encode($item['scrappable'])	: null,
				'throwable'		=> isset($item['throwable'])	? json_encode($item['throwable'])	: null,
				'weaponable'	=> isset($item['weaponable'])	? json_encode($item['weaponable'])	: null,
			]);
		}

		// foreach ($json_items as $slug => $item) {
		// 	if (isset($item['craftable'])) {
		// 		$recipe[$slug] = ItemRecipe::create([
		// 			'item_id' => $items[$slug]->id,
		// 			'type'    => "crafting",
		// 			'components' => json_encode($item['craftable'])
		// 		]);
		// 	}
		// 	if (isset($item['scrappable'])) {
		// 		$recipe[$slug] = ItemRecipe::create([
		// 			'item_id' => $items[$slug]->id,
		// 			'type'    => "scrapping",
		// 			'components' => json_encode($item['scrappable'])
		// 		]);
		// 	}
		// }
		



		/**
		 * CHARACTERS
		 */

		$characters = [];
		$json = File::get(database_path('data/tabletopia/characters.json'));
		$json_characters = json_decode($json, true);

		foreach ($json_characters as $slug => $character) {
			$characters[$slug] = Character::factory()->create([
				'project_id'  => $projects['tabletopia']->id,
				'name'        => $character['name'],
				'alias'        => $character['alias'],
				'slug'        => $slug,
				'description' => $character['desc'],
				'appearance'  => isset($character['appearance'])	? join(",", $character['appearance'])		: null,
				'personality' => isset($character['personality'])	? join(",", $character['personality'])		: null,
			]);
			if (isset($character['class'])) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['class']->id,
					'value'           => $character['class'],
				]);
			}
			if (isset($character['level'])) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['level']->id,
					'value'           => $character['level'],
				]);
			}
			if (isset($character['species'])) {
				CustomFieldValue::create([
					'fieldable_id' => $characters[$slug]->id,
					'custom_field_id' => $fields['species']->id,
					'value'           => $character['species'],
				]);
			}
			if (isset($character['inventory'])) {
				foreach ($character['inventory'] as $item) {
					DB::table('character_inventories')->insert([
						'character_id' => $characters[$slug]->id,
						'item_id' => $items[$item['item']]->id,
						'quantity' => $item['quantity']
					]);
				}
			}
			if (isset($character['mapdata'])) {
				$mapdata[$slug] = MapItem::create([
					'location_id'	=> $locations[$character['mapdata']['location']]['id'] ?? null,
					'mappable_type'	=> Character::class,
					'mappable_id'	=> $characters[$slug]['id'],
					'x'				=> $character['mapdata']['x'] ?? null,
					'y'				=> $character['mapdata']['y'] ?? null
				]);
			}
		}



		/**
		 * FACTIONS
		 */

		$factions = [];
		$ranks = [];
		$json = File::get(database_path('data/tabletopia/factions.json'));
		$json_factions = json_decode($json, true);
		foreach ($json_factions as $slug => $faction) {
			$factions[$slug] = Faction::factory()->create([
				'project_id'      => $projects['tabletopia']->id,
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
		$json = File::get(database_path('data/tabletopia/relationships.json'));
		$json_relationships = json_decode($json, true);
		foreach ($json_relationships as $relationship) {
			DB::table('character_relationships')->insert([
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