<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;

class TaskPolicy
{
    public function create(User $user): bool
    {
        return Auth::check();
    }

    public function update(User $user, Task $task): bool
    {
        return Auth::check();
    }

    public function delete(User $user, Task $task): bool
    {
        return $task->creator()->is($user);
    }
}
