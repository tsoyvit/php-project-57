<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class ShowTaskTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $status;
    private Task $currentTask;
    private TestResponse $response;

    public function setUp(): void
    {
        parent::setUp();

        $this->status = TaskStatus::factory()->create();
        $this->currentTask = Task::factory()->withStatus($this->status)->create();

        $this->response = $this->get(route('tasks.show', $this->currentTask->id));
    }

    public function test_return_success_response()
    {
        $this->response->assertStatus(200);
    }

    public function test_return_404_for_non_existent_task()
    {
        $this->get(route('tasks.show', 9999))
            ->assertStatus(404);
    }

    public function test_render_correct_view()
    {
        $this->response->assertViewIs('task.show');
    }

    public function test_passes_correct_task_to_view()
    {
        $this->response->assertViewHas('task', fn ($task) =>
            $task->id === $this->currentTask->id && $this->status->id === $task->status_id
        );
    }
}
