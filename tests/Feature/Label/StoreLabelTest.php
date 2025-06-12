<?php

namespace Tests\Feature\Label;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class StoreLabelTest extends TestCase
{
    use RefreshDatabase;

    private TestResponse $response;

    /** @var array<string, mixed> $labelData */
    private array $labelData;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);

        $this->labelData = [
            'name' => 'test',
            'description' => 'test',
        ];

        $this->response = $this->post(route('labels.store'), $this->labelData);
    }

    public function testQuestCannotAccessStore(): void
    {
        auth()->logout();

        $this->post(route('labels.store'), $this->labelData)
            ->assertForbidden();
    }

    public function testAuthorizedUserCanStoreLabel(): void
    {
        $this->response->assertRedirect(route('labels.index'));
    }

    public function testReturnFlashSuccessMessage(): void
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.The tag created successfully')
        );
    }

    public function testDatabaseHasNewLabel(): void
    {
        $this->assertDatabaseHas('labels', $this->labelData);
    }
}
