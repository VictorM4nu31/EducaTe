<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SatLesson extends Model
{
    // Category constants
    public const CATEGORY_GENERAL = 'general';
    public const CATEGORY_RFC = 'rfc';
    public const CATEGORY_TAXES = 'taxes';
    public const CATEGORY_INVOICES = 'invoices';
    public const CATEGORY_REGIMES = 'regimes';
    public const CATEGORY_DECLARATIONS = 'declarations';
    public const CATEGORY_EFIRMA = 'efirma';

    // Difficulty constants
    public const DIFFICULTY_BASIC = 'basic';
    public const DIFFICULTY_INTERMEDIATE = 'intermediate';
    public const DIFFICULTY_ADVANCED = 'advanced';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'quiz_data',
        'order',
        'category',
        'difficulty',
        'estimated_minutes',
        'category_order',
        'lesson_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'estimated_minutes' => 'integer',
        'category_order' => 'integer',
        'lesson_order' => 'integer',
        'quiz_data' => 'array',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            if (empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });

        static::updating(function ($lesson) {
            if ($lesson->isDirty('title') && empty($lesson->slug)) {
                $lesson->slug = Str::slug($lesson->title);
            }
        });
    }

    /**
     * Obtener lecciones activas ordenadas
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('order');
    }

    /**
     * Obtener lecciones por categoría
     */
    public static function byCategory(string $category)
    {
        return static::where('category', $category)
            ->where('is_active', true)
            ->orderBy('category_order');
    }

    /**
     * Obtener lecciones por dificultad
     */
    public static function byDifficulty(string $difficulty)
    {
        return static::where('difficulty', $difficulty)
            ->where('is_active', true)
            ->orderBy('lesson_order');
    }
}
