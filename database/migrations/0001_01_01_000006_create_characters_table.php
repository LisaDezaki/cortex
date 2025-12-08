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
		Schema::create('characters', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('slug')->nullable();
			$table->string('name');
			$table->string('alias')->nullable();
			$table->boolean('starred')->default(false);
			$table->text('description')->nullable();
			$table->text('motivations')->nullable();
			$table->text('appearance')->nullable();
			$table->text('personality')->nullable();
			// $table->foreignUuid('location_id')->nullable()->constrained('locations')->cascadeOnUpdate()->cascadeOnDelete();
			$table->timestamps();
			$table->softDeletes();
		});

		Schema::create('character_relationships', function (Blueprint $table) {
			// $table->uuid('id')->primary()->index();
			$table->foreignUuid('character_id')->constrained('characters')->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignUuid('related_character_id')->constrained('characters')->cascadeOnUpdate()->cascadeOnDelete();
			$table->text('character_role')->nullable();
			$table->text('related_character_role')->nullable();
			$table->unique(['character_id','related_character_id']);
			$table->unique(['related_character_id','character_id']);
			$table->index(['character_id','related_character_id']);
			$table->timestamps();
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
        Schema::dropIfExists('character_relationships');
    }
};