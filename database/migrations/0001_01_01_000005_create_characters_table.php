<?php

use App\Models\Location;
use App\Models\Project;
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

		//	Create the characters table
		Schema::create('characters', function (Blueprint $table) {
			//  Unique identifier for the character
			$table->uuid('id')->primary()->index();
			//  Foreign key to the project this character belongs to
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			//  Character attributes
			$table->string('slug'     )->nullable();
			$table->string('name'     );
			$table->string('subtitle' )->nullable();
			$table->string('image'    )->nullable();
			$table->text('description')->nullable();
			$table->text('appearance' )->nullable();
			$table->text('personality')->nullable();
			$table->text('motivations')->nullable();
			$table->text('flaws'      )->nullable();
			//  Character's primary location in the project
			$table->foreignUuid('location_id')->nullable()->constrained('locations')->cascadeOnUpdate()->cascadeOnDelete();
			//  Administrative attributes
			$table->timestamps();
			$table->softDeletes();
		});

		//	Create the character relationships table
		Schema::create('character_relationships', function (Blueprint $table) {
			//  Unique identifier for the relationship
			$table->uuid('id')->primary()->index();
			//  Foreign keys to the characters involved in the relationship
			$table->foreignUuid('character_id')->constrained('characters')->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignUuid('related_character_id')->constrained('characters')->cascadeOnUpdate()->cascadeOnDelete();
			//  Relationship attributes
			$table->text('character_role')->nullable();
			$table->text('related_character_role')->nullable();
			//	Constraints to ensure uniqueness of relationships
			$table->unique(['character_id','related_character_id']);
			$table->unique(['related_character_id','character_id']);
			//  Index to speed up queries involving character relationships
			$table->index(['character_id','related_character_id']);
			//  Administrative attributes
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