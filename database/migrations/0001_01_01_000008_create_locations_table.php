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
		Schema::create('locations', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('slug')->nullable();
			$table->string('name');
			$table->string('icon')->nullable();
			$table->string('type')->nullable();
			$table->boolean('starred')->default(false);
			$table->text('description')->nullable();
			$table->text('climate')->nullable();
			$table->boolean('is_world_map')->default(false);
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('map_items', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('location_id')->constrained('locations')->cascadeOnUpdate()->cascadeOnDelete();
			$table->uuidMorphs('mappable'); // Polymorphic relationship adds "mappable_id" and "mappable_type" columns
			$table->string('x')->nullable();
			$table->string('y')->nullable();
			$table->index(['location_id', 'mappable_id']);
			$table->unique('mappable_id');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
		Schema::dropIfExists('locations');
        Schema::dropIfExists('map_items');
    }

};