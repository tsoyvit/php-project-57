<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EditTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $taskStatus;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->taskStatus = TaskStatus::factory()->create();
        $this->response = $this->get(route('task_statuses.edit', $this->taskStatus));
    }

    public function testQuestCannotAccessEditTaskStatus(): void
    {
        auth()->logout();

        $this->get(route('task_statuses.edit', $this->taskStatus))
            ->assertForbidden();
    }

    public function testAuthorizedUserCanEditTaskStatus(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('task_status.edit');
    }

    public function testEditViewContainsRequiredData(): void
    {
        $this->response->assertViewHas(
            'taskStatus',
            fn ($status) => $status instanceof TaskStatus && $status->id === $this->taskStatus->id
        );
    }
}
