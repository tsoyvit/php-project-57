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

    public function testQuestCannotAccessDestroy(): void
    {
        $this->delete(route('tasks.destroy', $this->task))
            ->assertForbidden();
    }

    public function testNonAuthorCannotDestroyTask(): void
    {
        $this->actingAs($this->nonAuthor);
        $this->delete(route('tasks.destroy', $this->task))->assertForbidden();
    }

    public function testTaskDeletedFromDatabase(): void
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
