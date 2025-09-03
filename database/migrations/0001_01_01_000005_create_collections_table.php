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
        Schema::create('collections', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('slug')->nullable();
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('collection_type');
		});

		Schema::create('collection_items', function (Blueprint $table) {
			$table->foreignUuid('collection_id')->constrained()->onDelete('cascade');
			$table->nullableUuidMorphs('collectionable');
			$table->integer('order')->nullable();
			$table->text('notes')->nullable();

			$table->index(['collection_id', 'collectionable_id']);
			// A collection can't have the same item twice
			$table->unique(['collection_id', 'collectionable_id', 'collectionable_type']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('collection_items');
    }
};
