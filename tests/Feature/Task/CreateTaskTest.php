<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateTaskTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->response = $this->get(route('tasks.create'));
    }

    public function testGuestCannotAccessCreateTask(): void
    {
        auth()->logout();

        $this->get(route('tasks.create'))->assertForbidden();
    }

    public function testAuthorizedUserCanCreateTask(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('task.create');
    }

    public function testViewContainsRequiredData(): void
    {
        $this->response->assertViewHas(['taskStatuses', 'assignees']);

        $this->response->assertViewHas('task', fn ($task) => $task instanceof Task && ! $task->exists);
    }
}
