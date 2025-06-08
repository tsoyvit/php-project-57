<?php

namespace Tests\Feature\TaskStatus;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DestroyTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private TaskStatus $taskStatus;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function test_quest_cannot_access_destroy()
    {
        $this->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertForbidden();
    }

    public function test_destroy_cannot_be_destroyed_if_status_used()
    {
        $this->actingAs($this->user);

        $status = TaskStatus::factory()->create();
        Task::factory()->withStatus($status)->create();

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('error',
            __("flash.Couldn't delete status"));

        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    public function test_task_status_deleted_from_database()
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success',
            __('flash.Status successfully deleted'));

        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
