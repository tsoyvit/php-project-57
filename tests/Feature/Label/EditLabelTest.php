<?php

namespace Tests\Feature\Label;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class EditLabelTest extends TestCase
{
    use RefreshDatabase;

    private Label $label;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->label = Label::factory()->create();
        $this->response = $this->get(route('labels.edit', $this->label));
    }

    public function testQuestCannotAccessEditLabel(): void
    {
        auth()->logout();

        $this->get(route('labels.edit', $this->label))
            ->assertForbidden();
    }

    public function testAuthorizedUserCanEditLabel(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('label.edit');
    }

    public function testEditViewContainsRequiredData(): void
    {
        $this->response->assertViewHas(
            'label',
            fn ($label) => $label instanceof Label && $label->id === $this->label->id
        );
    }
}
