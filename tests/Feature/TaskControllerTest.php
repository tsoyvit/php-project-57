<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private User $author;
    private User $assignee;
    private User $user;
    private TaskStatus $status;
    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->author = User::factory()->create();
        $this->assignee = User::factory()->create();
        $this->user = User::factory()->create();
        $this->status = TaskStatus::factory()->create();

        $this->task = Task::factory()->withStatus($this->status)->create();

        Task::factory(3)
            ->withAuthor($this->author)
            ->withStatus($this->status)
            ->forUser($this->assignee)
            ->create();

        Task::factory(2)->create([
            'status_id' => TaskStatus::factory()->create()->id,
        ]);
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testIndexFilterAndPagination(): void
    {
        $status1 = TaskStatus::factory()->create();
        $status2 = TaskStatus::factory()->create();

        Task::factory()->count(5)->withStatus($status1)->create();
        Task::factory()->count(20)->withStatus($status2)->create();

        $response = $this->get(route('tasks.index', [
            'filter' => ['status_id' => $status1->id],
            'page' => 1
        ]));

        $response->assertViewHas('tasks', function ($tasks) use ($status1) {
            return $tasks->every(fn($task) =>
                    $task->status_id === $status1->id) && $tasks->count() === 5;
        });
    }

    public function testIndexFilterByStatus(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['status_id' => $this->status->id]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->status_id === $this->status->id;
            });
        });
    }

    public function testIndexFilterByCreator(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['created_by_id' => $this->author->id]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->created_by_id === $this->author->id;
            });
        });
    }

    public function testIndexFilterByAssignee(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => ['assigned_to_id' => $this->assignee->id]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->assigned_to_id === $this->assignee->id;
            });
        });
    }

    public function testIndexCombineMultipleFilters(): void
    {
        $response = $this->get(route('tasks.index', [
            'filter' => [
                'status_id' => $this->status->id,
                'created_by_id' => $this->author->id,
                'assigned_to_id' => $this->assignee->id,
            ]
        ]));

        $response->assertOk();
        $response->assertViewHas('tasks', function ($tasks) {
            return $tasks->every(function ($task) {
                return $task->status_id === $this->status->id
                    && $task->created_by_id === $this->author->id
                    && $task->assigned_to_id === $this->assignee->id;
            });
        });
    }

    public function testCreateAsGuest(): void
    {
        $this->get(route('tasks.create'))->assertForbidden();
    }

    public function testCreate(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tasks.create'));
        $response->assertOk();

        $response->assertViewHas(['taskStatuses', 'assignees']);
        $response->assertViewHas('task', fn ($task) => $task instanceof Task && ! $task->exists);
    }

    public function testStoreAsGuest(): void
    {
        $taskData = Task::factory()->make()->toArray();

        $this->post(route('tasks.store'), $taskData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testStore(): void
    {
        $this->actingAs($this->user);

        $taskData = Task::factory()->withAuthor($this->user)->make()->toArray();
        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', __('flash.The task was created successfully'));

        $this->assertDatabaseHas('tasks', $taskData);
    }

    public function testShow(): void
    {
        $response = $this->get(route('tasks.show', $this->task->id));

        $response->assertOk();
        $response->assertViewHas('task', fn ($task) =>
            $task->id === $this->task->id && $task->status_id === $this->status->id);
    }

    public function testShowReturn404ForNonExistentTask(): void
    {
        $this->get(route('tasks.show', 9999))
            ->assertStatus(404);
    }

    public function testEditAsGuest(): void
    {
        $this->get(route('tasks.edit', $this->task))
            ->assertForbidden();
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertOk();

        $response->assertViewHas(['assignees', 'taskStatuses']);
        $response->assertViewHas(
            'task',
            fn ($task) => $task instanceof Task && $task->id === $this->task->id
        );
    }

    public function testUpdateAsGuest(): void
    {
        $updatedData = [
            'name' => 'New Task name',
            'status_id' => TaskStatus::factory()->create()->id,
        ];

        $this->patch(route('tasks.update', $this->task), $updatedData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testUpdate(): void
    {
        $this->actingAs($this->user);

        $updatedData = [
            'name' => 'New Task name',
            'status_id' => TaskStatus::factory()->create()->id,
        ];

        $response = $this->patch(route('tasks.update', $this->task), $updatedData);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', __('flash.The task has been successfully changed'));
        $this->assertDatabaseHas('tasks', $updatedData);
    }

    public function testDestroyAsGuest(): void
    {
        $this->delete(route('tasks.destroy', $this->task))
            ->assertForbidden();
    }

    public function testDestroyNonAuthor(): void
    {
        $nonAuthor = User::factory()->create();
        $this->actingAs($nonAuthor);

        $this->delete(route('tasks.destroy', $this->task))->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testDestroy(): void
    {
        $this->actingAs($this->author);

        $task = Task::factory()->withAuthor($this->author)->create();

        $response = $this->delete(route('tasks.destroy', $task));

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas(
            'success',
            __('flash.The task was successfully deleted')
        );

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
