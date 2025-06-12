<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EditTaskTest extends TestCase
{
    use RefreshDatabase;

    private Task $task;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->task = Task::factory()->create();

        $this->actingAs($user);
        $this->response = $this->get(route('tasks.edit', $this->task));
    }

    public function testQuestCannotAccessEditTask(): void
    {
        auth()->logout();

        $this->get(route('tasks.edit', $this->task))
            ->assertForbidden();
    }

    public function testAuthorizedUserCanEditTask(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('task.edit');
    }

    public function testEditViewContainsRequiredData(): void
    {
        $this->response->assertViewHas(['assignees', 'taskStatuses']);
        $this->response->assertViewHas(
            'task',
            fn ($task) => $task instanceof Task && $task->id === $this->task->id
        );
    }
}
