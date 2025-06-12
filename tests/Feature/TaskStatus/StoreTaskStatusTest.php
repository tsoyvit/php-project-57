<?php

namespace Tests\Feature\TaskStatus;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    /** @var array<string, mixed> $taskStatusData */
    private array $taskStatusData;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->taskStatusData = [
            'name' => 'taskStatus name',
        ];

        $this->response = $this->post(
            route('task_statuses.store'),
            $this->taskStatusData
        );
    }

    public function testQuestCannotAccessStore(): void
    {
        auth()->logout();

        $this->post(route('task_statuses.store'), $this->taskStatusData)
            ->assertForbidden();
    }

    public function testAuthorizedUserCanStoreTaskStatus(): void
    {
        $this->response->assertRedirect(route('task_statuses.index'));
    }

    public function testReturnFlashSuccessMessage(): void
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.The status was created successfully')
        );
    }

    public function testDatabaseHasNewTaskStatus(): void
    {
        $this->assertDatabaseHas('task_statuses', $this->taskStatusData);
    }
}
