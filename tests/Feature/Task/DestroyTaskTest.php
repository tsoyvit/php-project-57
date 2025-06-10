<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyTaskTest extends TestCase
{
    use RefreshDatabase;

    private User $author;

    private User $nonAuthor;

    private Task $task;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nonAuthor = User::factory()->create();
        $this->author = User::factory()->create();

        $this->task = Task::factory()->withAuthor($this->author)->create();
    }

    public function test_quest_cannot_access_destroy()
    {
        $this->delete(route('tasks.destroy', $this->task))
            ->assertForbidden();
    }

    public function test_non_author_cannot_destroy_task()
    {
        $this->actingAs($this->nonAuthor);
        $this->delete(route('tasks.destroy', $this->task))->assertForbidden();
    }

    public function test_task_deleted_from_database()
    {
        $this->actingAs($this->author);

        $response = $this->delete(route('tasks.destroy', $this->task));

        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHas(
            'success',
            __('flash.The task was successfully deleted')
        );

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
