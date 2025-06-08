<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexTaskTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private Collection $tasks;

    public function setUp(): void
    {
        parent::setUp();

        $this->tasks = Task::factory()->count(3)->create();
        $this->response = $this->get(route('tasks.index'));
    }

    public function test_index_return_success_response()
    {
        $this->response->assertOk();
    }

    public function test_index_render_correct_view()
    {
        $this->response->assertViewIs('task.index');
    }

    public function test_index_displays_tasks()
    {
        foreach ($this->tasks as $task) {
            $this->response->assertSee($task->id);
        }
    }
}
