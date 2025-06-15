<?php

namespace Database\Seeders;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        Task::factory()
//            ->count(50)
//            ->create()
//            ->each(function (Task $task) {
//                $labelIds = \App\Models\Label::inRandomOrder()->limit(rand(0, 3))->pluck('id');
//                $task->labels()->sync($labelIds);
//            });

        $taskNamesData = [
            'Исправить ошибку в какой-нибудь строке',
            'Допилить дизайн главной страницы',
            'Отрефакторить авторизацию',
            'Доработать команду подготовки БД',
            'Пофиксить вон ту кнопку',
            'Исправить поиск',
            'Добавить интеграцию с облаками',
            'Выпилить лишние зависимости',
            'Запилить сертификаты',
            'Выпилить игру престолов',
            'Пофиксить спеку во всех репозиториях',
            'Вернуть крошки',
            'Установить Linux',
            'Потребовать прибавки к зарплате',
            'Добавить поиск по фото',
            'Съесть еще этих прекрасных французских булочек',
        ];

        foreach ($taskNamesData as $name) {
            $task = Task::updateOrCreate([
                'name' => $name,
                'description' => fake()->realText(100),
                'status_id' => TaskStatus::inRandomOrder()->first()?->id ?? TaskStatus::factory(),
                'created_by_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
                'assigned_to_id' => User::inRandomOrder()->first()?->id,
            ]);

            $labelIds = Label::inRandomOrder()->limit(rand(0, 3))->pluck('id')->toArray();
            $task->labels()->sync($labelIds);
        }
    }
}
