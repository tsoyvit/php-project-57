<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('task_statuses', TaskStatusController::class)
    ->except('index', 'show')
    ->middleware('auth.forbid');

Route::get('task_statuses', [TaskStatusController::class, 'index'])
    ->name('task_statuses.index');

Route::get('task_statuses/{task_status}', fn () => abort(404));


Route::resource('tasks', TaskController::class)
    ->except('index', 'show')
    ->middleware('auth.forbid');

Route::resource('tasks', TaskController::class)
    ->only('index', 'show');



require __DIR__ . '/auth.php';
