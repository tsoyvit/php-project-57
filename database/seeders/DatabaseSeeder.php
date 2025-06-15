<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            User::factory()->count(10)->create();
        }

        $this->call(TaskStatusSeeder::class);
        $this->call(LabelSeeder::class);
        $this->call(TaskSeeder::class,);
    }
}
