<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->realText(40),
            'description' => fake()->realText(100),
            'status_id' => TaskStatus::inRandomOrder()->first()?->id ?? TaskStatus::factory(),
            'created_by_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'assigned_to_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }

    public function withAuthor(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'created_by_id' => $user->id,
        ]);
    }

    public function forUser(User $user): static
    {
        return $this->state(fn (array $attributes) => [
            'assigned_to_id' => $user->id,
        ]);
    }

    public function withStatus(TaskStatus $status): static
    {
        return $this->state(fn (array $attributes) => [
            'status_id' => $status->id,
        ]);
    }
}
