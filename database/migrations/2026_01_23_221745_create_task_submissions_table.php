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
        Schema::create('task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('file_path')->nullable(); // Ruta del archivo subido
            $table->string('file_name')->nullable(); // Nombre original del archivo
            $table->text('notes')->nullable(); // Notas del estudiante
            $table->enum('status', ['pending', 'submitted', 'graded', 'rejected', 'resubmitted', 'returned'])->default('submitted');
            $table->decimal('grade', 5, 2)->nullable(); // Calificación (0-10)
            $table->text('feedback')->nullable(); // Comentarios del profesor
            $table->boolean('is_early')->default(false); // Entrega anticipada
            $table->boolean('is_late')->default(false); // Entrega tardía
            $table->decimal('ac_earned', 10, 2)->nullable(); // AC ganados
            $table->boolean('is_excellent')->default(false); // Calidad excepcional
            $table->timestamp('submitted_at')->useCurrent();
            $table->timestamp('graded_at')->nullable();
            $table->timestamps();
            
            // Un estudiante solo puede tener una entrega activa por tarea
            $table->unique(['task_id', 'user_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_submissions');
    }
};
