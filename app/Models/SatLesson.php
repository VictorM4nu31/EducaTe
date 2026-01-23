<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SatLesson extends Model
{
    protected $fillable = [
        'title',
        'content',
        'order',
        'category',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Obtener lecciones activas ordenadas
     */
    public static function active()
    {
        return static::where('is_active', true)->orderBy('order');
    }
}
