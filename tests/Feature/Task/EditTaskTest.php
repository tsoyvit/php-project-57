<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EditTaskTest extends TestCase
{
    use RefreshDatabase;

    private Task $task;
    private TestResponse $response;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->task = Task::factory()->create();

        $this->actingAs($user);
        $this->response = $this->get(route('tasks.edit', $this->task));
    }

    public function test_quest_cannot_access_edit_task()
    {
        auth()->logout();

        $this->get(route('tasks.edit', $this->task))
            ->assertForbidden();
    }

    public function test_authorized_user_can_edit_task()
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view()
    {
        $this->response->assertViewIs('task.edit');
    }

    public function test_edit_view_contains_required_data()
    {
        $this->response->assertViewHas(['assignees', 'taskStatuses']);

        $this->response->assertViewHas('task', fn ($task) =>
            $task instanceOf Task && $task->id === $this->task->id);
    }

}
