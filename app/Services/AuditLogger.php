<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditLogger
{
    /**
     * Log a generic action.
     *
     * @param string $action
     * @param Model|null $model
     * @param array|null $oldValues
     * @param array|null $newValues
     * @return void
     */
    public function log(string $action, ?Model $model = null, ?array $oldValues = null, ?array $newValues = null): void
    {
        // Use the existing static method on the model
        AuditLog::log($action, $model, $oldValues, $newValues);
    }

    /**
     * Log a login event.
     */
    public function logLogin(): void
    {
        $this->log('login');
    }

    /**
     * Log a logout event.
     */
    public function logLogout(): void
    {
        $this->log('logout');
    }
}
