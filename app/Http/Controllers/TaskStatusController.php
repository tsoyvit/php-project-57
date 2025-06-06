<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\TaskStatus;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class TaskStatusController extends Controller
{
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
            ->with('success', __("flash.Status successfully deleted"));
    }
}
