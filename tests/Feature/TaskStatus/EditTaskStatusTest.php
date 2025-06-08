<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EditTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $taskStatus;
    private TestResponse $response;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->taskStatus = TaskStatus::factory()->create();
        $this->response = $this->get(route('task_statuses.edit', $this->taskStatus));
    }

    public function test_quest_cannot_access_edit_task_status()
    {
        auth()->logout();

        $this->get(route('task_statuses.edit', $this->taskStatus))
            ->assertForbidden();
    }


    public function test_authorized_user_can_edit_task_status()
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view()
    {
        $this->response->assertViewIs('task_status.edit');
    }

    public function test_edit_view_contains_required_data()
    {
        $this->response->assertViewHas('taskStatus', fn ($status) =>
            $status instanceof TaskStatus && $status->id === $this->taskStatus->id);
    }
}
