<?php

namespace Tests\Feature\Task;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTaskTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    /** @var array<string, mixed> $taskData */
    private array $taskData;

    protected function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();

        $this->taskData = [
            'name' => 'task name',
            'description' => 'task description',
            'status_id' => TaskStatus::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id,
        ];

        $this->actingAs($user);
        $this->response = $this->post(route('tasks.store'), $this->taskData);
    }

    public function test_quest_cannot_access_store(): void
    {
        auth()->logout();

        $this->post(route('tasks.store'), $this->taskData)
            ->assertForbidden();
    }

    public function test_authorized_user_can_store_task(): void
    {
        $this->response->assertRedirect(route('tasks.index'));
    }

    public function test_return_flash_success_message(): void
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.The task was created successfully')
        );
    }

    public function test_database_has_new_task(): void
    {
        $this->assertDatabaseHas('tasks', $this->taskData);
    }
}
