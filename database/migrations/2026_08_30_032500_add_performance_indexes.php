<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Índices para las consultas más frecuentes del dominio.
     */
    public function up(): void
    {
        // Listados de exámenes/tareas por creador.
        Schema::table('exams', function (Blueprint $table) {
            $table->index('created_by', 'exams_created_by_index');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->index('created_by', 'tasks_created_by_index');
        });

        // Agregaciones del dashboard financiero (por tipo y fecha).
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['type', 'created_at'], 'transactions_type_created_at_index');
        });

        // Exámenes activos por creador.
        Schema::table('exams', function (Blueprint $table) {
            $table->index(['created_by', 'is_active'], 'exams_created_by_active_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('exams', function (Blueprint $table) {
            $table->dropIndex('exams_created_by_index');
            $table->dropIndex('exams_created_by_active_index');
        });

        Schema::table('tasks', function (Blueprint $table) {
            $table->dropIndex('tasks_created_by_index');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('transactions_type_created_at_index');
        });
    }
};
