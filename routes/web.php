<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Teacher Routes
Route::middleware(['auth', 'verified'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::view('tasks', 'teacher.tasks.index')->name('tasks');
    Route::view('tasks/create', 'teacher.tasks.create')->name('tasks.create');
});

// Student Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('tasks', 'student.tasks.index')->name('tasks');
    Route::view('exams', 'student.exams.index')->name('exams');
    Route::view('marketplace', 'student.marketplace.index')->name('marketplace');
});

require __DIR__.'/settings.php';
