<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\Expenditure\ExpenditureController;
use App\Http\Controllers\Expenditure\FixedExpenditureController;
use App\Http\Controllers\IncomeCategory\IncomeCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/income', [IncomeController::class, 'index'])->middleware(['auth', 'verified'])->name('income');
Route::get('/income/fixed', [IncomeController::class, 'fixed'])->middleware(['auth', 'verified'])->name('income.fixed');

Route::get('/expenditure', [ExpenditureController::class, 'index'])->middleware(['auth', 'verified'])->name('expenditure');
Route::get('/expenditure/fixed', [FixedExpenditureController::class, 'index'])->middleware(['auth', 'verified'])->name('expenditure.fixed');
Route::get('/category', [IncomeCategoryController::class, 'index'])->middleware(['auth', 'verified'])->name('category');

Route::get('/top', function () {
    return Inertia::render('Report/Index');
})->middleware(['auth', 'verified'])->name('top');

Route::get('/bulk_operation', function () {
    return Inertia::render('BulkOperation/Index');
})->middleware(['auth', 'verified'])->name('bulk_operation');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/income/get', [IncomeController::class, 'get']);
Route::post('/income/add', [IncomeController::class, 'create']);
Route::put('/income/update/{id}', [IncomeController::class, 'update']);
Route::post('/income/delete', [IncomeController::class, 'delete']);

Route::get('/expenditure/get', [ExpenditureController::class, 'get']);
Route::get('/expenditure/get_by_category', [ExpenditureController::class, 'fetchByCategory']);
Route::post('/expenditure/add', [ExpenditureController::class, 'create']);
Route::put('/expenditure/update/{id}', [ExpenditureController::class, 'update']);
Route::post('/expenditure/delete', [ExpenditureController::class, 'delete']);

Route::get('/expenditure/fixed/get', [FixedExpenditureController::class, 'get']);
Route::post('/expenditure/fixed/add', [FixedExpenditureController::class, 'create']);
Route::put('/expenditure/fixed/update/{id}', [FixedExpenditureController::class, 'update']);
Route::post('/expenditure/fixed/delete', [FixedExpenditureController::class, 'delete']);

Route::get('/income_category/get', [IncomeCategoryController::class, 'get']);
Route::post('/income_category/add', [IncomeCategoryController::class, 'store']);
Route::put('/income_category/update/{id}', [IncomeCategoryController::class, 'update']);
Route::post('/income_category/delete', [IncomeCategoryController::class, 'delete']);

Route::get('/expenditure_category/get', [ExpenditureCategoryController::class, 'get']);
Route::post('/expenditure_category/add', [ExpenditureCategoryController::class, 'store']);
Route::put('/expenditure_category/update/{id}', [ExpenditureCategoryController::class, 'update']);
Route::post('/expenditure_category/delete', [ExpenditureCategoryController::class, 'delete']);

Route::get('/expenditure/export', [ExpenditureController::class, 'export']);
Route::post('/expenditure/import_csv', [ExpenditureController::class, 'import_csv']);

Route::post('/expenditure/bulk_create', [ExpenditureController::class, 'bulkCreate']);

Route::post('/preset_expenditure_item/confirm', function () {
    return Inertia::render('BulkOperation/Confirm');
});

require __DIR__.'/auth.php';
