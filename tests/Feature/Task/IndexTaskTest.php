<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexTaskTest extends TestCase
{
    use RefreshDatabase;

    private User $creator;
    private User $assignee;
    private TaskStatus $status;

    protected function setUp(): void
    {
        parent::setUp();

        $this->creator = User::factory()->create();
        $this->assignee = User::factory()->create();
        $this->status = TaskStatus::factory()->create();

        Task::factory(3)
            ->withAuthor($this->creator)
            ->withStatus($this->status)
            ->forUser($this->assignee)
            ->create();

        Task::factory(2)->create([
            'status_id' => TaskStatus::factory()->create()->id,
        ]);
    }

    public function it_can_filter_tasks_by_status(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['status_id' => $this->status->id]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->status_id === $this->status->id;
            });
        });
    }

    public function it_can_filter_tasks_by_creator(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['created_by_id' => $this->creator->id]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->created_by_id === $this->creator->id;
            });
        });
    }

    public function it_can_filter_tasks_by_assignee(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['assigned_to_id' => $this->assignee->id]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->assigned_to_id === $this->assignee->id;
            });
        });
    }

    public function it_can_combine_multiple_filters(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => [
                'status_id' => $this->status->id,
                'created_by_id' => $this->creator->id,
                'assigned_to_id' => $this->assignee->id,
            ]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->status_id === $this->status->id
                    && $task->created_by_id === $this->creator->id
                    && $task->assigned_to_id === $this->assignee->id;
            });
        });
    }

    public function test_index_render_correct_view()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertViewIs('task.index');
    }
}
