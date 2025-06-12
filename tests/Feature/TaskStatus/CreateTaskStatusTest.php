<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->response = $this->get(route('task_statuses.create'));
    }

    public function testGuestCannotAccessCreateTask(): void
    {
        auth()->logout();
        $this->get(route('task_statuses.create'))->assertForbidden();
    }

    public function testAuthorizedUserCanCreateTask(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('task_status.create');
    }

    public function testViewContainsRequiredData(): void
    {
        $this->response->assertViewHas(
            'taskStatus',
            fn ($taskStatus) => $taskStatus instanceof TaskStatus && ! $taskStatus->exists
        );
    }
}
