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
        // First, drop foreign key constraints
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['main_image_id']);
        });

        // Then drop the tables
        Schema::dropIfExists('project_images');
        Schema::dropIfExists('projects');

        // Create projects table
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->json('technologies');
            $table->boolean('is_visible')->default(true);
            $table->unsignedBigInteger('main_image_id')->nullable();
            $table->timestamps();
        });

        // Create project_images table
        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('image_path');
            $table->timestamps();
        });

        // Add foreign key for main_image_id after project_images table exists
        Schema::table('projects', function (Blueprint $table) {
            $table->foreign('main_image_id')->references('id')->on('project_images')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop foreign key constraints first
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['main_image_id']);
        });

        Schema::dropIfExists('project_images');
        Schema::dropIfExists('projects');
    }
};
