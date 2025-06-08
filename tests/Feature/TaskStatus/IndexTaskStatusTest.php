<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;
    private Collection $taskStatuses;

    public function setUp(): void
    {
        parent::setUp();

        $this->taskStatuses = TaskStatus::factory()->count(3)->create();
        $this->response = $this->get(route('task_statuses.index'));
    }

    public function test_index_returns_success_response()
    {
        $this->response->assertOk();
    }

    public function test_index_render_correct_view()
    {
        $this->response->assertViewIs('task_status.index');
    }

    public function test_index_displays_task_statuses()
    {
        foreach ($this->taskStatuses as $status) {
            $this->response->assertSee($status->name);
        }
    }
}
