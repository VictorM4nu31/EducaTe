<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SavingsGoal extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'target_amount',
        'current_amount',
        'target_date',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener el porcentaje de progreso
     */
    public function getProgressPercentageAttribute(): float
    {
        if ($this->target_amount <= 0) {
            return 0;
        }
        return min(($this->current_amount / $this->target_amount) * 100, 100);
    }

    /**
     * Verificar si está cerca de la meta (80% o más)
     */
    public function isNearGoal(): bool
    {
        return $this->progress_percentage >= 80 && !$this->is_completed;
    }

    /**
     * Obtener días restantes hasta la fecha objetivo
     */
    public function getDaysRemainingAttribute(): ?int
    {
        if (!$this->target_date) {
            return null;
        }
        return max(0, now()->diffInDays($this->target_date, false));
    }
}
