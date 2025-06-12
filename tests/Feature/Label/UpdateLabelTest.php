<?php

namespace Tests\Feature\Label;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UpdateLabelTest extends TestCase
{
    use RefreshDatabase;

    private Label $label;
    private TestResponse $response;

    /** @var array<string, mixed> $updatedLabelData */
    private array $updatedLabelData;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->label = Label::factory()->create();

        $this->updatedLabelData = [
            'name' => 'New name',
            'description' => 'New description',
        ];

        $this->response = $this->patch(
            route('labels.update', $this->label),
            $this->updatedLabelData
        );
    }

    public function testQuestCannotUpdateLabel(): void
    {
        auth()->logout();

        $this->patch(route('labels.update', $this->label), $this->updatedLabelData)
            ->assertForbidden();
    }

    public function testAuthenticatedUserCanUpdateLabel(): void
    {
        $this->response->assertRedirect(route('labels.index'));
    }

    public function testReturnSuccessMessageWhenUpdatedLabel(): void
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.The tag has been successfully changed')
        );
    }

    public function testDatabaseHasUpdatedLabel(): void
    {
        $this->assertDatabaseHas('labels', $this->updatedLabelData);
    }
}
