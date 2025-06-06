<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;
    private TestResponse $response;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->response = $this->get(route('tasks.create'));
    }

    public function test_guest_cannot_access_create_task()
    {
        auth()->logout();
        $response = $this->get(route('tasks.create'));
        $response->assertForbidden();
    }

    public function test_authorized_user_can_create_task()
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view()
    {
        $this->response->assertViewIs('task.create');
    }

    public function test_view_contains_required_data()
    {
        $this->response->assertViewHas(['taskStatuses', 'assignees']);

        $this->response->assertViewHas('task', fn ($task) =>
            $task instanceof Task && !$task->exists);
    }
}
