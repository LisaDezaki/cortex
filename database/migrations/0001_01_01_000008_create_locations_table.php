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
			$table->boolean('starred')->default(false);
			$table->foreignUuid('parent_location_id')->nullable()->constrained('locations')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('name');
			$table->string('icon')->nullable();
			$table->string('type')->nullable();
			$table->string('slug')->nullable();
			$table->boolean('is_world_map')->default(false);
			$table->text('description')->nullable();
			$table->string('coordinates_x')->nullable();
			$table->string('coordinates_y')->nullable();
			$table->timestamps();
			$table->softDeletes();
			$table->index('parent_location_id');
		});

		Schema::create('map_items', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('location_id')->constrained('locations')->cascadeOnUpdate()->cascadeOnDelete();
			$table->uuidMorphs('mappable'); // Polymorphic relationship
			$table->string('coordinates_x')->nullable();
			$table->string('coordinates_y')->nullable();
			$table->index('location_id');
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