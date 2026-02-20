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
        Schema::create('sat_lesson_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sat_lesson_id')->constrained()->cascadeOnDelete();
            $table->integer('score')->default(0);
            $table->decimal('earned_ac', 10, 2)->default(0);
            $table->timestamps();
            
            // Un usuario solo puede completar una lección una vez y recibir recompensa por ella
            $table->unique(['user_id', 'sat_lesson_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sat_lesson_completions');
    }
};
