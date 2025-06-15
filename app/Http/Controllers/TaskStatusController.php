<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class TaskStatusController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('auth.forbid', except: ['index']),
        ];
    }

    public function index(): View
    {
        $taskStatuses = TaskStatus::all();

        return view('task_status.index', compact('taskStatuses'));
    }

    public function create(): View
    {
        $taskStatus = new TaskStatus();

        return view('task_status.create', compact('taskStatus'));
    }

    public function store(TaskStatusRequest $request): RedirectResponse
    {
        TaskStatus::create($request->validated());

        return redirect(route('task_statuses.index'))
            ->with('success', __('flash.The status was created successfully'));
    }

    public function show(TaskStatus $taskStatus): void
    {
        abort(403, 'This action is unauthorized.');
    }


    public function edit(TaskStatus $taskStatus): View
    {
        return view('task_status.edit', compact('taskStatus'));
    }

    public function update(TaskStatusRequest $request, TaskStatus $taskStatus): RedirectResponse
    {
        $taskStatus->update($request->validated());

        return redirect(route('task_statuses.index'))
            ->with('success', __('flash.Status changed successfully'));
    }

    public function destroy(TaskStatus $taskStatus): RedirectResponse
    {
        if ($taskStatus->tasks()->exists()) {
            return redirect(route('task_statuses.index'))
                ->with('error', __("flash.Couldn't delete status"));
        }

        $taskStatus->delete();

        return redirect(route('task_statuses.index'))
            ->with('success', __('flash.Status successfully deleted'));
    }
}
