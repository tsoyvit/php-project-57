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

    public function test_quest_cannot_access_edit_label()
    {
        auth()->logout();

        $this->get(route('labels.edit', $this->label))
            ->assertForbidden();
    }

    public function test_authorized_user_can_edit_label()
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view()
    {
        $this->response->assertViewIs('label.edit');
    }

    public function test_edit_view_contains_required_data()
    {
        $this->response->assertViewHas(
            'label',
            fn ($label) => $label instanceof Label && $label->id === $this->label->id
        );
    }
}
