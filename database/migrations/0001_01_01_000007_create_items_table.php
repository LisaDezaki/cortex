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
			$table->boolean('starred')->default(false);
			$table->boolean('unique')->default(false);
			$table->unsignedInteger('cost')->nullable();			//	0—4.2B
			$table->unsignedTinyInteger('weight')->nullable();		//	0—255
			$table->text('description')->nullable();
			$table->timestamps();
			$table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};