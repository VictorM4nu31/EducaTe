<?php

namespace App\Concerns;

use App\Models\ActivityLog;

/**
 * Proporciona un método conciso para registrar acciones en el log de auditoría.
 */
trait LogsActivity
{
    protected function logActivity(string $action, string $description, array $context = []): void
    {
        ActivityLog::record(auth()->user(), $action, $description, $context);
    }
}
