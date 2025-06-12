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

    public function test_quest_cannot_access_store(): void
    {
        auth()->logout();

        $this->post(route('labels.store'), $this->labelData)
            ->assertForbidden();
    }

    public function test_authorized_user_can_store_label(): void
    {
        $this->response->assertRedirect(route('labels.index'));
    }

    public function test_return_flash_success_message(): void
    {
        $this->response->assertSessionHas(
            'success',
            __('flash.The tag created successfully')
        );
    }

    public function test_database_has_new_label(): void
    {
        $this->assertDatabaseHas('labels', $this->labelData);
    }
}
