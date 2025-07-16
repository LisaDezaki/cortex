<?php

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
        Schema::create('custom_fields', function (Blueprint $table) {
            $table->uuid('id')->primary()->index();
			$table->foreignUuid('project_id')->constrained('projects')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('entity_type');
			$table->string('type');
			$table->string('name');
			$table->string('label');
			$table->string('description')->nullable();
			$table->string('placeholder')->nullable();
			$table->boolean('required');
			$table->unique(['project_id','entity_type','name']);
        });

		Schema::create('custom_field_options', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->foreignUuid('custom_field_id')->constrained('custom_fields')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('value');
			$table->string('label');
			$table->unique(['custom_field_id', 'value']);
		});

		Schema::create('custom_field_values', function (Blueprint $table) {
			$table->uuid('id')->primary()->index();
			$table->uuid('entity_id');
			$table->foreignUuid('custom_field_id')->constrained('custom_fields')->cascadeOnUpdate()->cascadeOnDelete();
			$table->string('value');
			$table->unique(['custom_field_id', 'entity_id']);
			$table->index(['entity_id', 'custom_field_id']);
		});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('custom_field_options');
        Schema::dropIfExists('custom_field_values');
    }
};
