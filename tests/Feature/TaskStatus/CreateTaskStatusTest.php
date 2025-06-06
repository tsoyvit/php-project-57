<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateTaskStatusTest extends TestCase
{
    use RefreshDatabase;
    private TestResponse $response;

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->response = $this->get(route('task_statuses.create'));
    }

    public function test_guest_cannot_access_create_task()
    {
        auth()->logout();

        $response = $this->get(route('task_statuses.create'));
        $response->assertForbidden();
    }

    public function test_authorized_user_can_create_task()
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view()
    {
        $this->response->assertViewIs('task_status.create');
    }

    public function test_view_contains_required_data()
    {
        $this->response->assertViewHas('taskStatus', fn ($taskStatus) =>
            $taskStatus instanceof TaskStatus && !$taskStatus->exists);
    }
}
