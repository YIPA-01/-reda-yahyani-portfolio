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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('technologies');
            $table->foreignId('main_image_id')->nullable()->constrained('project_images')->nullOnDelete();
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });

        // Add project_id to project_images table
        Schema::table('project_images', function (Blueprint $table) {
            $table->foreignId('project_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('project_images', function (Blueprint $table) {
            $table->dropForeign(['project_id']);
            $table->dropColumn('project_id');
        });
        
        Schema::dropIfExists('projects');
    }
}; 