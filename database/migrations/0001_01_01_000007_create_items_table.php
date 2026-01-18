<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('slug')->nullable();
			$table->string('name');
			$table->string('type')->nullable();
			$table->text('description')->nullable();
			$table->string('rarity')->nullable();
			$table->unsignedInteger('cost')->nullable();			//	0—4.2B
			$table->unsignedTinyInteger('weight')->nullable();		//	0—255
			$table->boolean('unique')->default(false);
			$table->boolean('starred')->default(false);
			$table->jsonb('consumable')->nullable();	// e.g. { "uses": 3, "effect": "healing", "magnitude": 10 }
			$table->jsonb('craftable')->nullable();		// e.g. { "wood": 5, "metal": 3, "mechanisms": 2 }
			$table->jsonb('containerable')->nullable();	// e.g. { "capacity": 50 }
			$table->jsonb('equippable')->nullable();	// e.g. { "slot": "head", "defense": 5 }
			$table->jsonb('scrappable')->nullable();	// e.g. { "wood": 3, "metal": 2, "mechanisms": 1 }
			$table->jsonb('throwable')->nullable();		// e.g. { "damage": 10, "range": 5 }
			$table->jsonb('weaponable')->nullable();	// e.g. { "damage": 15, "range": 10, "ammo_type": "bullet" }
			$table->timestamps();
			$table->softDeletes();
        });

		Schema::create('item_recipes', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('item_id')->constrained('items')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('type')->nullable(); // e.g. "crafting", "scrapping"
			$table->jsonb('components')->nullable(); // e.g. { "wood": 3, "metal": 2, "mechanisms": 1 }
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
        Schema::dropIfExists('item_recipes');
    }
};