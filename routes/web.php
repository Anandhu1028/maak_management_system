<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\ProjectStageTaskController;
use App\Http\Controllers\Admin\TaskLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::resource('projects', ProjectController::class);
        Route::post('stages', [ProjectController::class, 'storeStage'])->name('stages.store');
        Route::patch('stages/{stage}/status', [ProjectController::class, 'updateStageStatus'])->name('stages.update-status');
        
        // Project Stage Tasks
        Route::get('stages/{stage}/tasks', [ProjectStageTaskController::class, 'index'])->name('stage-tasks.index');
        Route::post('stages/{stage}/tasks', [ProjectStageTaskController::class, 'store'])->name('stage-tasks.store');
        Route::patch('stage-tasks/{task}/progress', [ProjectStageTaskController::class, 'updateProgress'])->name('stage-tasks.update-progress');
        Route::delete('stage-tasks/{task}', [ProjectStageTaskController::class, 'destroy'])->name('stage-tasks.destroy');
        Route::post('stage-tasks/{task}/logs', [TaskLogController::class, 'store'])->name('task-logs.store');

        Route::resource('users', UserController::class);
        Route::resource('expenses', ExpenseController::class);
        Route::post('expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::post('expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');
        
        Route::resource('payments', PaymentController::class);
        
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        
        // Filtered user views for convenience
        Route::get('supervisors', [UserController::class, 'supervisors'])->name('supervisors.index');
        Route::get('clients', [UserController::class, 'clients'])->name('clients.index');
    });
});

require __DIR__.'/auth.php';
