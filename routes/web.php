<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectKeywordController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::any('/upload', [UploadController::class, 'index'])->name('upload');

    // projects
    Route::get('/', [ProjectController::class, 'index'])->name('home');
    Route::resource('/projects', ProjectController::class)->except('index');
    Route::get('/projects/{project}/keywords', [ProjectKeywordController::class, 'index'])->name('projects.keywords');
    Route::get('/projects/{project}/import', [ProjectKeywordController::class, 'import']);
    Route::post('/projects/{project}/import-store', [ProjectKeywordController::class, 'import_store']);
    Route::get('/projects/{project}/delete', [ProjectController::class, 'destroy']); // tmp

    Route::get('/projects/{project}/tasks', [ProjectTaskController::class, 'index'])->name('projects.tasks');
    Route::post('/projects/{project}/tasks/{task}/destroy', [ProjectTaskController::class, 'destroy']);
    Route::post('/projects/{project}/tasks/parse-yandex', [ProjectTaskController::class, 'parseYandex']);

    // admin only
    Route::resource('/users', UserController::class)->except('show');

    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // crop images
    Route::get('/img/{path}', [ImageController::class, 'show'])->where('path', '.*')->name('image');

    // api
    Route::get('/api/v1/project/{project}/categories', [\App\Http\Controllers\Api\ProjectCategoryController::class, 'index']);
    Route::get('/api/v1/project/{project}/metrics', [\App\Http\Controllers\Api\MetricCategoryController::class, 'index']);
    Route::get('/api/v1/project/{project}/keywords', [\App\Http\Controllers\Api\MetricCategoryController::class, 'keywords']);

    Route::get('/api/v1/project-keywords/{project}', [\App\Http\Controllers\Api\ProjectKeywordController::class, 'index']);
    Route::delete('/api/v1/project-keywords/{keyword}/destroy', [\App\Http\Controllers\Api\ProjectKeywordController::class, 'destroy']);
    Route::post('/api/v1/project-keywords/{project}/create-keywords', [\App\Http\Controllers\Api\ProjectKeywordController::class, 'createKeywords']);
    Route::post('/api/v1/project-keywords/{project}/create-category', [\App\Http\Controllers\Api\ProjectKeywordController::class, 'createCategory']);

    Route::get('/api/v1/notification', [NotificationController::class, 'index']);
});
