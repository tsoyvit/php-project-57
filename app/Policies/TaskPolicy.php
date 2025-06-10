<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function delete(User $user, Task $task): bool
    {
        return $user->id === $task->created_by_id;
    }
}
