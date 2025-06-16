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

    public function testIndex(): void
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

    public function testCreateAsGuest(): void
    {
        $this->get(route('labels.create'))->assertForbidden();
    }

    public function testCreate(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('labels.create'));
        $response->assertOk();

        $response->assertViewHas('label', fn ($label) => $label instanceof Label && ! $label->exists);
    }

    public function testStoreAsGuest(): void
    {
        $labelData = Label::factory()->make()->toArray();

        $this->post(route('labels.store'), $labelData)
            ->assertForbidden();
    }

    /**
     * @throws \JsonException
     */
    public function testStore(): void
    {
        $this->actingAs($this->user);

        $labelData = Label::factory()->make()->toArray();
        $response = $this->post(route('labels.store'), $labelData);

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();
        $response->assertSessionHas('success', __('flash.The tag created successfully'));

        $this->assertDatabaseHas('labels', $labelData);
    }

    public function testEditAsGuest(): void
    {
        $this->get(route('labels.edit', $this->label))
            ->assertForbidden();
    }

    public function testEdit(): void
    {
        $this->actingAs($this->user);

        $response = $this->get(route('labels.edit', $this->label));
        $response->assertOk();

        $response->assertViewHas(
            'label',
            fn ($label) => $label instanceof Label && $label->id === $this->label->id
        );
    }

    public function testUpdateAsGuest(): void
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
    public function testUpdate(): void
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

    public function testDestroyAsGuest(): void
    {
        $this->delete(route('labels.destroy', $this->label))
            ->assertForbidden();
    }

    public function testDestroyUsedLabel(): void
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
    public function testDestroy(): void
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
