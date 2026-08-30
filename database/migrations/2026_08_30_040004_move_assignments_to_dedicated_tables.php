<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Migra las asignaciones antiguas (pivote dual) a las tablas dedicadas
     * y elimina las tablas originales.
     */
    public function up(): void
    {
        // Exámenes asignados a clases
        DB::table('exam_assignments')
            ->whereNotNull('group_id')
            ->orderBy('id')
            ->each(function ($row) {
                DB::table('exam_group_assignments')->insert([
                    'exam_id' => $row->exam_id,
                    'group_id' => $row->group_id,
                    'available_from' => $row->available_from,
                    'available_until' => $row->available_until,
                    'time_limit' => $row->time_limit,
                    'created_at' => $row->created_at ?? now(),
                    'updated_at' => $row->updated_at ?? now(),
                ]);
            });

        // Exámenes asignados a estudiantes concretos
        DB::table('exam_assignments')
            ->whereNotNull('user_id')
            ->orderBy('id')
            ->each(function ($row) {
                DB::table('exam_user_assignments')->insert([
                    'exam_id' => $row->exam_id,
                    'user_id' => $row->user_id,
                    'available_from' => $row->available_from,
                    'available_until' => $row->available_until,
                    'time_limit' => $row->time_limit,
                    'created_at' => $row->created_at ?? now(),
                    'updated_at' => $row->updated_at ?? now(),
                ]);
            });

        // Tareas asignadas a clases
        DB::table('task_assignments')
            ->whereNotNull('group_id')
            ->orderBy('id')
            ->each(function ($row) {
                DB::table('task_group_assignments')->insert([
                    'task_id' => $row->task_id,
                    'group_id' => $row->group_id,
                    'created_at' => $row->created_at ?? now(),
                    'updated_at' => $row->updated_at ?? now(),
                ]);
            });

        // Tareas asignadas a estudiantes concretos
        DB::table('task_assignments')
            ->whereNotNull('user_id')
            ->orderBy('id')
            ->each(function ($row) {
                DB::table('task_user_assignments')->insert([
                    'task_id' => $row->task_id,
                    'user_id' => $row->user_id,
                    'created_at' => $row->created_at ?? now(),
                    'updated_at' => $row->updated_at ?? now(),
                ]);
            });

        Schema::dropIfExists('exam_assignments');
        Schema::dropIfExists('task_assignments');
    }

    /**
     * Reverse the migrations. (No es reversible de forma exacta; se deja no-op.)
     */
    public function down(): void
    {
        //
    }
};
