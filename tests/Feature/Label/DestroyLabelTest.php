<?php

namespace Tests\Feature\Label;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DestroyLabelTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private Label $label;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->label = Label::factory()->create();
    }

    public function test_quest_cannot_access_destroy()
    {
        $this->delete(route('labels.destroy', $this->label))
            ->assertForbidden();
    }

    public function test_destroy_cannot_be_destroyed_if_label_used()
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

    public function test_label_deleted_from_database()
    {
        $this->actingAs($this->user);

        $response = $this->delete(route('labels.destroy', $this->label));

        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHas(
            'success',
            __('flash.The tag was successfully deleted')
        );

        $this->assertDatabaseMissing('labels', ['id' => $this->label->id]);
    }
}
