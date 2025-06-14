<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    private User $user;
    private Label $label;


    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    // INDEX

    public function testIndexReturnsSuccessResponse(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testIndexDisplaysLabels(): void
    {
        $labels = Label::factory()->count(3)->create();

        $response = $this->get(route('labels.index'));

        foreach ($labels as $label) {
            $response->assertSee($label->name);
        }
    }


    // CREATE

    public function testGuestCannotAccessCreateLabel(): void
    {
        $this->get(route('labels.create'))->assertForbidden();
    }

    public function testAuthorizedUserCanCreateLabel(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('labels.create'));
        $response->assertOk();

        $response->assertViewHas('label', fn ($label) => $label instanceof Label && ! $label->exists);
    }

    // STORE

    public function testGuestCannotAccessStore(): void
    {
        $labelData = [
            'name' => 'test',
            'description' => 'test',
        ];

        $this->post(route('labels.store'), $labelData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testAuthorizedUserCanStoreLabel(): void
    {
        $this->actingAs($this->user);

        $labelData = [
            'name' => 'test',
            'description' => 'test',
        ];

        $response = $this->post(route('labels.store'), $labelData);

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', __('flash.The tag created successfully'));

        $this->assertDatabaseHas('labels', $labelData);
    }

    // EDIT

    public function testGuestCannotAccessEditLabel(): void
    {
        $this->get(route('labels.edit', $this->label))
            ->assertForbidden();
    }

    public function testAuthorizedUserCanEditLabel(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('labels.edit', $this->label));
        $response->assertOk();

        $response->assertViewHas(
            'label',
            fn ($label) => $label instanceof Label && $label->id === $this->label->id
        );
    }

    // UPDATE

    public function testGuestCannotUpdateLabel(): void
    {
        $updatedData = [
            'name' => 'New name',
            'description' => 'New description',
        ];

        $this->patch(route('labels.update', $this->label), $updatedData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testAuthenticatedUserCanUpdateLabel(): void
    {
        $this->actingAs($this->user);

        $updatedData = [
            'name' => 'New name',
            'description' => 'New description',
        ];

        $response = $this->patch(route('labels.update', $this->label), $updatedData);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas(
            'success',
            __('flash.The tag has been successfully changed')
        );

        $this->assertDatabaseHas('labels', $updatedData);
    }

    // DESTROY

    public function testGuestCannotAccessDestroy(): void
    {
        $this->delete(route('labels.destroy', $this->label))
            ->assertForbidden();
    }

    public function testDestroyCannotBeDestroyedIfLabelUsed(): void
    {
        $this->actingAs($this->user);

        $task = Task::factory()->create();
        $task->labels()->sync([$this->label->id]);

        $response = $this->delete(route('labels.destroy', $this->label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas(
            'error',
            __("flash.Couldn't delete tag")
        );

        $this->assertDatabaseHas('labels', ['id' => $this->label->id]);
    }

    /**
     * @throws \JsonException
     */
    public function testLabelDeletedFromDatabase(): void
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('labels.destroy', $this->label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas(
            'success',
            __('flash.The tag was successfully deleted')
        );

        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }
}
