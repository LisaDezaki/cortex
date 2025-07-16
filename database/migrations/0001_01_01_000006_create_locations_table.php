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
		Schema::create('regions', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->string('image')->nullable();
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('locations', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('region_id')->constrained('regions')->nullable()->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('name');
			$table->string('slug')->nullable();
			$table->string('image')->nullable();
			$table->text('description')->nullable();
			$table->string('coordinates_x')->nullable();
			$table->string('coordinates_y')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locations');
    }

};
