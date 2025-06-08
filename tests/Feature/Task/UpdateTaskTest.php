<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UpdateTaskTest extends TestCase
{
    use RefreshDatabase;

    private Task $task;
    private array $updatedTaskData;
    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $oldStatus = TaskStatus::factory()->create();
        $newStatus = TaskStatus::factory()->create();

        $this->task = Task::factory()->withStatus($oldStatus)->create();

        $this->updatedTaskData = [
            'name' => 'New Task name',
            'status_id' => $newStatus->id
        ];

        $this->response = $this->patch(route('tasks.update', $this->task),
            $this->updatedTaskData);
    }

    public function test_quest_cannot_update_task()
    {
        auth()->logout();

        $this->patch(route('tasks.update', $this->task), $this->updatedTaskData)
            ->assertForbidden();
    }

    public function test_authenticated_user_can_update_task()
    {
        $this->response->assertRedirect(route('tasks.index'));
    }

    public function test_return_success_message_when_updated_task()
    {
        $this->response->assertSessionHas(['success' =>
            __('flash.The task has been successfully changed')]);
    }

    public function test_database_has_updated_task()
    {
        $this->assertDatabaseHas('tasks', $this->updatedTaskData);
    }
}
