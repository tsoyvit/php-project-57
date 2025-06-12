<?php

namespace Tests\Feature\Label;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class CreateLabelTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->response = $this->get(route('labels.create'));
    }

    public function test_guest_cannot_access_create_label(): void
    {
        auth()->logout();
        $this->get(route('labels.create'))->assertForbidden();
    }

    public function test_authorized_user_can_create_task(): void
    {
        $this->response->assertOk();
    }

    public function test_render_correct_view(): void
    {
        $this->response->assertViewIs('label.create');
    }

    public function test_view_contains_required_data(): void
    {
        $this->response->assertViewHas('label', fn ($label) => $label instanceof Label && ! $label->exists);
    }
}
