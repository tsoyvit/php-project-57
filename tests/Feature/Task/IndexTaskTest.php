<?php

namespace Tests\Feature\Task;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IndexTaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_return_success_response()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function test_index_render_correct_view()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertViewIs('task.index');
    }

    public function test_index_displays_tasks()
    {
        $tasks = Task::factory()->count(3)->create();

        $response = $this->get(route('tasks.index'));

        foreach ($tasks as $task) {
            $response->assertSee($task->id);
        }
    }
}
