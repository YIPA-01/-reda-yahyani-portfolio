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
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('theme_mode', ['light', 'dark'])->default('light');
            $table->enum('theme_color', [
                'zinc', 'slate', 'stone', 'gray', 'neutral',
                'red', 'rose', 'orange', 'green', 'blue',
                'yellow', 'violet'
            ])->default('zinc');
            $table->enum('border_radius', ['0', '0.25', '0.5', '0.75', '1'])->default('0.5');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
}; 