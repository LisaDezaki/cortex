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
        Schema::create('factions', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('slug')->nullable();
			$table->string('name');
			$table->string('type')->nullable();
			$table->text('description')->nullable();
			$table->foreignUuid('headquarters_id')->nullable()->constrained('locations')->cascadeOnUpdate()->nullOnDelete();
			$table->timestamps();
			$table->softDeletes();
        });

		Schema::create('faction_ranks', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('faction_id')->constrained('factions')->cascadeOnUpdate()->cascadeOnDelete();
			$table->integer('order')->default(0);
			$table->string('name')->nullable();
			$table->text('description')->nullable();
			$table->index('faction_id');
			$table->index(['faction_id', 'order']);
		});

		Schema::create('faction_members', function (Blueprint $table) {
			$table->foreignUuid('faction_id')->constrained('factions')->cascadeOnUpdate()->cascadeOnDelete();
			$table->foreignUuid('character_id')->constrained('characters')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('rank_id')->nullable();
			$table->primary(['faction_id', 'character_id']);
			$table->index('rank_id');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factions');
		Schema::dropIfExists('faction_ranks');
        Schema::dropIfExists('faction_members');
    }
};