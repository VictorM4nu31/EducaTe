<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'description',
        'context',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'context' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Registrar una acción de auditoría.
     */
    public static function record(?User $user, string $action, string $description, array $context = []): static
    {
        return static::create([
            'user_id' => $user?->id,
            'action' => $action,
            'description' => $description,
            'context' => $context,
            'ip_address' => request()->ip(),
            'user_agent' => isset($_SERVER['HTTP_USER_AGENT']) ? substr((string) $_SERVER['HTTP_USER_AGENT'], 0, 255) : null,
        ]);
    }
}
