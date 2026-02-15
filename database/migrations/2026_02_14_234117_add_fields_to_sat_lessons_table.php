<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('sat_lessons', function (Blueprint $table) {
            // Add slug as nullable first to handle existing records
            $table->string('slug')->nullable()->after('title');
            $table->string('difficulty')->default('basic')->after('category'); // basic, intermediate, advanced
            $table->integer('estimated_minutes')->nullable()->after('difficulty');
            $table->integer('category_order')->default(0)->after('order');
            $table->integer('lesson_order')->default(0)->after('category_order');
        });

        // Populate slugs for existing records
        $lessons = DB::table('sat_lessons')->whereNull('slug')->get();
        foreach ($lessons as $lesson) {
            DB::table('sat_lessons')
                ->where('id', $lesson->id)
                ->update(['slug' => Str::slug($lesson->title)]);
        }

        // Remove duplicate records (keep only the oldest one for each slug)
        $duplicates = DB::select("
            SELECT slug, MIN(id) as keep_id
            FROM sat_lessons
            WHERE slug IS NOT NULL
            GROUP BY slug
            HAVING COUNT(*) > 1
        ");

        foreach ($duplicates as $duplicate) {
            DB::table('sat_lessons')
                ->where('slug', $duplicate->slug)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        // Now make slug non-nullable and unique
        Schema::table('sat_lessons', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sat_lessons', function (Blueprint $table) {
            $table->dropColumn(['slug', 'difficulty', 'estimated_minutes', 'category_order', 'lesson_order']);
        });
    }
};
