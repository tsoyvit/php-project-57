<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UpdateTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $taskStatus;

    private array $updatedTaskStatusData;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->taskStatus = TaskStatus::factory()->create();
        $this->updatedTaskStatusData = ['name' => 'New name status'];

        $this->response = $this->patch(
            route('task_statuses.update', $this->taskStatus),
            $this->updatedTaskStatusData
        );
    }

    public function test_quest_cannot_update_task_status()
    {
        auth()->logout();

        $this->patch(
            route('task_statuses.update', $this->taskStatus),
            $this->updatedTaskStatusData
        )
            ->assertForbidden();
    }

    public function test_authenticated_user_can_update_task_status()
    {
        $this->response->assertRedirect(route('task_statuses.index'));
    }

    public function test_return_success_message_when_updated_task_status()
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.Status changed successfully')
        );
    }

    public function test_database_has_updated_task()
    {
        $this->assertDatabaseHas('task_statuses', $this->updatedTaskStatusData);
    }
}
