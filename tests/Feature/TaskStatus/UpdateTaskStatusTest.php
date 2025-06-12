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

    /** @var array<string, mixed> $updatedTaskStatusData */
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

    public function testQuestCannotUpdateTaskStatus(): void
    {
        auth()->logout();

        $this->patch(
            route('task_statuses.update', $this->taskStatus),
            $this->updatedTaskStatusData
        )
            ->assertForbidden();
    }

    public function testAuthenticatedUserCanUpdateTaskStatus(): void
    {
        $this->response->assertRedirect(route('task_statuses.index'));
    }

    public function testReturnSuccessMessageWhenUpdatedTaskStatus(): void
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.Status changed successfully')
        );
    }

    public function testDatabaseHasUpdatedTask(): void
    {
        $this->assertDatabaseHas('task_statuses', $this->updatedTaskStatusData);
    }
}
