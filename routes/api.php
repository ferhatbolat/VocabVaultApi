<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\WordController;
use App\Http\Controllers\API\StoryController;
use App\Http\Controllers\API\ExerciseController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

 

// Word Routes
Route::prefix('words')->group(function () {
    Route::get('/', [WordController::class, 'index'])->name('words.index');
    Route::post('/', [WordController::class, 'store'])->name('words.store');
    Route::get('/{id}', [WordController::class, 'show'])->name('words.show');
    Route::put('/{id}', [WordController::class, 'update'])->name('words.update');
    Route::delete('/{id}', [WordController::class, 'destroy'])->name('words.destroy');
});

// Story Routes
Route::prefix('stories')->group(function () {
    Route::get('/', [StoryController::class, 'index'])->name('stories.index');
    Route::post('/', [StoryController::class, 'store'])->name('stories.store');
    Route::get('/{id}', [StoryController::class, 'show'])->name('stories.show');
    Route::put('/{id}', [StoryController::class, 'update'])->name('stories.update');
    Route::delete('/{id}', [StoryController::class, 'destroy'])->name('stories.destroy');
});
// Exercise Routes
Route::prefix('exercises')->group(function () {
    Route::get('/', [ExerciseController::class, 'getExercises'])->name('exercise.get');
});
