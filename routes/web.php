<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', AdminMiddleware::class])
    ->prefix('admin')
    ->group(function () {

        // Dashboard
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Forms CRUD (index, create, store, edit, update, destroy)
        Route::resource('forms', FormController::class);

        // Form fields (Dynamic fields)
        Route::get('forms/{form}/fields', [FormController::class, 'fields'])->name('admin.forms.fields');
        Route::post('forms/{form}/fields', [FormController::class, 'fieldsStore'])->name('admin.forms.fields.store');

        // Submissions
        Route::resource('submissions', SubmissionController::class)->only(['index', 'destroy', 'show']);

        // Users
        Route::get('users', [UserController::class, 'index'])->name('admin.users.index');

        // Import
        Route::get('import', [ImportController::class, 'index'])->name('admin.import.index');
        Route::post('import/upload', [ImportController::class, 'upload'])->name('admin.import.upload');
        Route::post('import/confirm', [ImportController::class, 'confirm'])->name('admin.import.confirm');

        // Export
        Route::get('export', [ExportController::class, 'index'])->name('admin.export.index');
        Route::get('export/users', [ExportController::class, 'users'])->name('admin.export.users'); // Download users CSV
        Route::get('export/submissions', [ExportController::class, 'submissions'])->name('admin.export.submissions');
        Route::get('export/download', [ExportController::class, 'download'])->name('admin.export.download');
    });

/*
|--------------------------------------------------------------------------
| Frontend Form Routes (Public, no login required)
|--------------------------------------------------------------------------
|
| These routes allow WordPress or any frontend to fetch forms via API
| and submit dynamic form data.
|
*/

Route::get('/forms', [FormController::class, 'list'])->name('forms.list');
Route::get('/forms/{form}', [FormController::class, 'showPublic'])->name('forms.show.public');
Route::post('/forms/{form}', [FormController::class, 'submit'])->name('forms.submit');