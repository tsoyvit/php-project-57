<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
           ['name' => 'новый'],
           ['name' => 'в работе'],
           ['name' => 'на тестировании'],
           ['name' => 'завершен'],
        ];

        foreach ($statuses as $status) {
            TaskStatus::updateOrCreate(['name' => $status['name']], $status);
        }
    }
}
