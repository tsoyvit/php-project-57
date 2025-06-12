<?php

namespace Tests\Feature\TaskStatus;

use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexTaskStatusTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    private Collection $taskStatuses;

    protected function setUp(): void
    {
        parent::setUp();

        $this->taskStatuses = TaskStatus::factory()->count(3)->create();
        $this->response = $this->get(route('task_statuses.index'));
    }

    public function testIndexReturnsSuccessResponse(): void
    {
        $this->response->assertOk();
    }

    public function testIndexRenderCorrectView(): void
    {
        $this->response->assertViewIs('task_status.index');
    }

    public function testIndexDisplaysTaskStatuses(): void
    {
        foreach ($this->taskStatuses as $status) {
            $this->response->assertSee($status->name);
        }
    }
}
