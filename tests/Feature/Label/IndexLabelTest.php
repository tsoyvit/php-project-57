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

    public function test_index_returns_success_response(): void
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view(): void
    {
        $this->response->assertViewIs('label.index');
    }

    public function test_index_displays_labels(): void
    {
        foreach ($this->labels as $label) {
            $this->response->assertSee($label->name);
        }
    }
}
