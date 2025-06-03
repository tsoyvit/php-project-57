<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_index(): void
    {
        // Подготовка: создаём несколько статусов
        $statuses = TaskStatus::factory()->count(3)->create();

        // Действие: обращаемся к маршруту
        $response = $this->get(route('task_statuses.index'));

        // Проверка: статус ответа 200
        $response->assertStatus(200);

        // Проверка: используется нужное представление
        $response->assertViewIs('task_status.index');

        // Проверяем, что статусы отображаются на странице
        foreach ($statuses as $status) {
            $response->assertSee($status->name);
        }
    }

    public function test_create(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(403);
        $this->actingAs($this->user);
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(200);
        $response->assertViewIs('task_status.create');
        $response->assertViewHas('taskStatus', function ($taskStatus) {
            return $taskStatus instanceof TaskStatus && !$taskStatus->exists;
        });
    }

    public function test_store(): void
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertStatus(403);

        $this->actingAs($this->user);

        // 2. Данные, которые отправим на endpoint
        $data = ['name' => 'Новый статус'];

        // 3. Действие: отправка POST-запроса
        $response = $this->post(route('task_statuses.store'), $data);

        // 4. Проверка: статус создан в базе данных
        $this->assertDatabaseHas('task_statuses', $data);

        // 5. Проверка: редирект на страницу списка
        $response->assertRedirect(route('task_statuses.index'));

        // 6. Проверка: флэш-сообщение присутствует в сессии
        $response->assertSessionHas('success', __('flash.The status was created successfully'));
    }

    public function test_edit_and_update(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', $taskStatus));
        $response->assertStatus(403);

        $response = $this->patch(route('task_statuses.update', $taskStatus),
            ['name' => 'New name']);
        $response->assertStatus(403);

        $this->actingAs($this->user);
        $updatedData = ['name' => 'New name'];
        $response = $this->put(route('task_statuses.update', $taskStatus),
            $updatedData);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success', __('flash.Status changed successfully'));
        $this->assertDatabaseHas('task_statuses', $updatedData);
    }

    public function test_destroy(): void
    {
        $taskStatus = TaskStatus::factory()->create();
        $response = $this->delete(route('task_statuses.destroy', $taskStatus));
        $response->assertStatus(403);

        $this->actingAs($this->user);
        $response = $this->delete(route('task_statuses.destroy', $taskStatus));
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHas('success', __('flash.Status successfully deleted'));
        $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);

    }

}
