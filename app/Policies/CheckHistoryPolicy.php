<?php

namespace App\Policies;

use App\Models\CheckHistory;
use App\Models\User;

class CheckHistoryPolicy
{
    /**
     * Determine whether the user can view the check history entry.
     */
    public function view(User $user, CheckHistory $history): bool
    {
        return $user->id === $history->user_id;
    }

    /**
     * Determine whether the user can delete the check history entry.
     */
    public function delete(User $user, CheckHistory $history): bool
    {
        return $user->id === $history->user_id;
    }
}
