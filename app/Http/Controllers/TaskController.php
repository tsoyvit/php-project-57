<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskFilterRequest;
use App\Http\Requests\TaskRequest;
use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class TaskController extends Controller
{
    private const PER_PAGE = 15;

    public function index(TaskFilterRequest $request): View
    {
        $query = Task::with(['status', 'creator', 'assignee']);
        $tasks = QueryBuilder::for($query)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->allowedSorts(['id'])
            ->paginate(self::PER_PAGE)
            ->withQueryString();

        return view('task.index', [
            'tasks' => $tasks,
            'statuses' => TaskStatus::pluck('name', 'id'),
            'users' => User::pluck('name', 'id'),
            'inputFilter' => $request->input('filter', []),
        ]);
    }

    public function create(): View
    {
        return view('task.create', [
            'task' => new Task(),
            'taskStatuses' => TaskStatus::pluck('name', 'id'),
            'assignees' => User::pluck('name', 'id'),
            'labels' => Label::pluck('name', 'id'),
        ]);
    }

    public function store(TaskRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        /** @var User $user */
        $user = auth()->user();

        /** @var Task $task */
        $task = $user->tasks()->create($validatedData);

        $task->labels()->sync($validatedData['labels'] ?? []);

        return redirect(route('tasks.index'))
            ->with('success', __('flash.The task was created successfully'));
    }

    public function show(Task $task): View
    {
        $task->load(['status', 'labels']);

        return view('task.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $task->load('labels');

        return view('task.edit', [
            'task' => $task,
            'taskStatuses' => TaskStatus::pluck('name', 'id'),
            'assignees' => User::pluck('name', 'id'),
            'labels' => Label::pluck('name', 'id'),
        ]);
    }

    public function update(TaskRequest $request, Task $task): RedirectResponse
    {
        $validatedData = $request->validated();

        $task->update($validatedData);
        $task->labels()->sync($validatedData['labels'] ?? []);

        return redirect(route('tasks.index'))
            ->with('success', __('flash.The task has been successfully changed'));
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect(route('tasks.index'))
            ->with('success', __('flash.The task was successfully deleted'));
    }
}
