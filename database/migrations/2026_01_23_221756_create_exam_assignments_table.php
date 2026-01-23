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
        Schema::create('exam_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('group_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->dateTime('available_from')->nullable(); // Disponible desde
            $table->dateTime('available_until')->nullable(); // Disponible hasta
            $table->integer('time_limit')->nullable(); // Tiempo límite en minutos
            $table->timestamps();
            
            $table->index(['exam_id', 'group_id']);
            $table->index(['exam_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_assignments');
    }
};
