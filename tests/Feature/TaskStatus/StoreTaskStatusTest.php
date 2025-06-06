<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private array $taskStatusData;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();

        $this->taskStatusData = [
            'name' => 'taskStatus name',
        ];

        $this->actingAs($user);
        $this->response = $this->post(route('task_statuses.store'),
            $this->taskStatusData);
    }

    public function test_quest_cannot_access_store()
    {
        auth()->logout();

        $response = $this->post(route('task_statuses.store'), $this->taskStatusData);
        $response->assertForbidden();
    }

    public function test_authorized_user_can_store_task_status()
    {
        $this->response->assertRedirect(route('task_statuses.index'));
    }

    public function test_return_flash_success_message()
    {
        $this->response->assertSessionHas('success',
            __('flash.The status was created successfully'));
    }

    public function test_database_has_new_task_status()
    {
        $this->assertDatabaseHas('task_statuses', $this->taskStatusData);
    }
}
