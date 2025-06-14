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

    // INDEX

    public function testIndexRenderCorrectView(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertViewIs('task.index');
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

    public function testCanFilterTasksByStatus(): void
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

    public function testCanFilterTasksByCreator(): void
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

    public function testCanFilterTasksByAssignee(): void
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

    public function testCanCombineMultipleFilters(): void
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

    // CREATE

    public function testGuestCannotAccessCreateTask(): void
    {
        $this->get(route('tasks.create'))->assertForbidden();
    }

    public function testAuthorizedUserCanCreateTask(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('tasks.create'));
        $response->assertOk();

        $response->assertViewHas(['taskStatuses', 'assignees']);
        $response->assertViewHas('task', fn ($task) => $task instanceof Task && ! $task->exists);
    }

    // STORE

    public function testGuestCannotAccessStore(): void
    {
        $taskData = [
            'name' => 'task name',
            'description' => 'task description',
            'status_id' => TaskStatus::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id,
        ];

        $this->post(route('tasks.store'), $taskData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testAuthorizedUserCanStoreTask(): void
    {
        $this->actingAs($this->user);

        $taskData = [
            'name' => 'task name',
            'description' => 'task description',
            'status_id' => TaskStatus::factory()->create()->id,
            'assigned_to_id' => User::factory()->create()->id,
        ];

        $response = $this->post(route('tasks.store'), $taskData);

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', __('flash.The task was created successfully'));

        $this->assertDatabaseHas('tasks', $taskData);
    }

    // SHOW

    public function testShowTaskReturnsSuccess(): void
    {
        $response = $this->get(route('tasks.show', $this->task->id));

        $response->assertOk();
        $response->assertViewHas('task', fn ($task) =>
            $task->id === $this->task->id && $task->status_id === $this->status->id);
    }

    public function testReturn404ForNonExistentTask(): void
    {
        $this->get(route('tasks.show', 9999))
            ->assertStatus(404);
    }

    // EDIT

    public function testGuestCannotAccessEditTask(): void
    {
        $this->get(route('tasks.edit', $this->task))
            ->assertForbidden();
    }

    public function testAuthorizedUserCanEditTask(): void
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

    // UPDATE

    public function testGuestCannotUpdateTask(): void
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
    public function testAuthorizedUserCanUpdateTask(): void
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

    // DESTROY

    public function testGuestCannotAccessDestroy(): void
    {
        $this->delete(route('tasks.destroy', $this->task))
            ->assertForbidden();
    }

    public function testNonAuthorCannotDestroyTask(): void
    {
        $nonAuthor = User::factory()->create();
        $this->actingAs($nonAuthor);

        $this->delete(route('tasks.destroy', $this->task))->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testTaskDeletedFromDatabase(): void
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
