<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShowTaskTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $status;

    private Task $currentTask;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->status = TaskStatus::factory()->create();
        $this->currentTask = Task::factory()->withStatus($this->status)->create();

        $this->response = $this->get(route('tasks.show', $this->currentTask->id));
    }

    public function testReturnSuccessResponse(): void
    {
        $this->response->assertStatus(200);
    }

    public function testReturn404ForNonExistentTask(): void
    {
        $this->get(route('tasks.show', 9999))
            ->assertStatus(404);
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('task.show');
    }

    public function testPassesCorrectTaskToView(): void
    {
        $this->response->assertViewHas(
            'task',
            fn ($task) => $task->id === $this->currentTask->id && $this->status->id === $task->status_id
        );
    }
}
