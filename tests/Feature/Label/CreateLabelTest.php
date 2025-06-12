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

    public function testGuestCannotAccessCreateLabel(): void
    {
        auth()->logout();
        $this->get(route('labels.create'))->assertForbidden();
    }

    public function testAuthorizedUserCanCreateTask(): void
    {
        $this->response->assertOk();
    }

    public function testRenderCorrectView(): void
    {
        $this->response->assertViewIs('label.create');
    }

    public function testViewContainsRequiredData(): void
    {
        $this->response->assertViewHas('label', fn ($label) => $label instanceof Label && ! $label->exists);
    }
}
