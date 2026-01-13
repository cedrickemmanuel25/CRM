<?php

namespace App\Observers;

use App\Models\User;
use App\Models\AuditLog;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        AuditLog::log('user_created', $user, null, $user->toArray());
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        if ($user->wasChanged('password')) {
            AuditLog::log('user_password_reset', $user);
        }
        
        $changes = $user->getChanges();
        $original = $user->getOriginal();
        
        // Filter out password and remember_token
        unset($changes['password'], $changes['remember_token'], $changes['updated_at']);
        
        if (!empty($changes)) {
            $oldValues = array_intersect_key($original, $changes);
            AuditLog::log('user_updated', $user, $oldValues, $changes);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        AuditLog::log('user_deleted', $user, $user->toArray(), null);
    }
}
