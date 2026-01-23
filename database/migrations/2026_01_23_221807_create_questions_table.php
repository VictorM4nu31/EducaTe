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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['multiple_choice', 'true_false', 'short_answer'])->default('multiple_choice');
            $table->decimal('points', 5, 2)->default(1.00);
            $table->integer('order')->default(0);
            $table->json('options')->nullable(); // Para opciones de respuesta (JSON)
            $table->string('correct_answer')->nullable(); // Respuesta correcta
            $table->text('explanation')->nullable(); // Explicación de la respuesta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
