<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    private User $user;
    private TaskStatus $taskStatus;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->taskStatus = TaskStatus::factory()->create();
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testIndexDisplaysTaskStatuses(): void
    {
        $taskStatuses = TaskStatus::factory()->count(3)->create();

        $response = $this->get(route('task_statuses.index'));

        foreach ($taskStatuses as $status) {
            $response->assertSee($status->name);
        }
    }

    public function testCreateAsGuest(): void
    {
        $this->get(route('task_statuses.create'))->assertForbidden();
    }

    public function testCreate(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();

        $response->assertViewHas(
            'taskStatus',
            fn ($taskStatus) => $taskStatus instanceof TaskStatus && ! $taskStatus->exists
        );
    }

    public function testStoreAsGuest(): void
    {
        $this->post(route('task_statuses.store'), ['name' => 'Task Status'])
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testStore(): void
    {
        $this->actingAs($this->user);

        $response = $this->post(route('task_statuses.store'), ['name' => 'Task Status']);

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas(
            'success',
            __('flash.The status was created successfully')
        );

        $this->assertDatabaseHas('task_statuses', ['name' => 'Task Status']);
    }

    public function testEditAsGuest(): void
    {
        $this->get(route('task_statuses.edit', $this->taskStatus))
            ->assertForbidden();
    }

    public function testEdi(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('task_statuses.edit', $this->taskStatus));
        $response->assertOk();

        $response->assertViewHas(
            'taskStatus',
            fn ($status) => $status instanceof TaskStatus && $status->id === $this->taskStatus->id
        );
    }

    public function testUpdateAsGuest(): void
    {
        $updatedData = ['name' => 'New name Task Status'];
        $this->patch(route('task_statuses.update', $this->taskStatus), $updatedData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testUpdate(): void
    {
        $this->actingAs($this->user);

        $updatedData = ['name' => 'New name Task Status'];

        $response = $this->patch(
            route('task_statuses.update', $this->taskStatus),
            $updatedData
        );

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas(
            'success',
            __('flash.Status changed successfully')
        );

        $this->assertDatabaseHas('task_statuses', $updatedData);
    }

    public function testDestroyAsGuest(): void
    {
        $this->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertForbidden();
    }

    public function testDestroyUsedTaskStatus(): void
    {
        $this->actingAs($this->user);

        $status = TaskStatus::factory()->create();
        Task::factory()->withStatus($status)->create();

        $response = $this->delete(route('task_statuses.destroy', $status));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas(
            'error',
            __("flash.Couldn't delete status")
        );

        $this->assertDatabaseHas('task_statuses', ['id' => $status->id]);
    }

    /**
     * @throws \JsonException
     */
    public function testDestroy(): void
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('task_statuses.destroy', $this->taskStatus));

        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas(
            'success',
            __('flash.Status successfully deleted')
        );

        $this->assertDatabaseMissing('task_statuses', ['id' => $this->taskStatus->id]);
    }
}
