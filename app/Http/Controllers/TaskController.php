<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Task::with(['status', 'creator', 'assignee'])
            ->orderBy('created_at')
            ->paginate(15);
        return view('task.index', compact('tasks'));
    }

    public function create(): View
    {
        $task = new Task();
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $assignees = User::pluck('name', 'id');

        return view('task.create', compact('task', 'taskStatuses', 'assignees'));
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['created_by_id'] = auth()->id();
        Task::create($data);

        return redirect(route('tasks.index'))
            ->with('success', __('flash.The task was created successfully'));
    }

    public function show(Task $task): View
    {
        $task->load('status');
        return view('task.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $assignees = User::pluck('name', 'id');

        return view('task.edit', compact('task', 'taskStatuses', 'assignees'));
    }

    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $task->update($request->validated());
        return redirect(route('tasks.index'))
            ->with('success', __('flash.The task has been successfully changed'));
    }

    public function destroy(Task $task): RedirectResponse
    {
        Gate::authorize('delete', $task);
        $task->delete();

        return redirect(route('tasks.index'))
            ->with('success', __('flash.The task was successfully deleted'));
    }
}
