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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('hints_used')->default(0);
            $table->decimal('grade', 5, 2)->nullable(); // Calificación antes de penalización
            $table->decimal('final_grade', 5, 2)->nullable(); // Calificación final (con penalización)
            $table->json('answers')->nullable(); // Respuestas del estudiante (JSON)
            $table->json('metadata')->nullable(); // Metadata adicional (pistas usadas por pregunta, etc.)
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_annulled')->default(false);
            $table->decimal('ac_earned', 10, 2)->nullable(); // AC ganados
            $table->timestamps();
            
            // Un estudiante puede tener múltiples intentos
            $table->index(['exam_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
