<?php

namespace Tests\Feature\Label;

use App\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class IndexLabelTest extends TestCase
{
    use RefreshDatabase;

    private Collection $labels;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $this->labels = Label::factory()->count(3)->create();
        $this->response = $this->get(route('labels.index'));
    }

    public function testIndexReturnsSuccessResponse(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('label.index');
    }

    public function testIndexDisplaysLabels(): void
    {
        foreach ($this->labels as $label) {
            $this->response->assertSee($label->name);
        }
    }
}
