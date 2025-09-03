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

		Schema::create('media', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->string('disk')->default('public');
			$table->string('path');
			// $table->string('original_name');
			// $table->string('mime_type');
			// $table->unsignedInteger('size');
			$table->string('type')->nullable(); // 'avatar', 'character_portrait', etc.
			$table->uuidMorphs('mediable'); // Polymorphic relationship
			$table->json('metadata')->nullable(); // Dimensions, colors, etc.
			$table->timestamps();
			$table->index('type');
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
