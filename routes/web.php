<?php

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Income\IncomeController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\Expenditure\ExpenditureController;
use App\Http\Controllers\FixedIncome\FixedIncomeController;
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
});

Route::get('/wasshoi', function (Request $request) {
    return response([
        'id' => 1,
        'name' => 'テストユーザー',
        'email' => 'test@example.com'
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

    Route::get('/report/saving', [ReportController::class, 'saving'])->name('report.saving');
    Route::get('/report/expense', [ReportController::class, 'expense'])->name('report.expense');
    Route::get('/report/saving/get', [ReportController::class, 'getCategoryToAmountList'])->name('report.saving.get');
    Route::get('/report/expense/get', [ReportController::class, 'fetchExpenseInfoList'])->name('report.expense.get');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/fixed-income', [FixedIncomeController::class, 'index'])->name('fixed-income.index');
    Route::get('/fixed-income/get', [FixedIncomeController::class, 'get'])->name('fixed-income.get');
    Route::post('/fixed-income/create', [FixedIncomeController::class, 'create'])->name('fixed-income.create');
    Route::put('/fixed-income/update/{id}', [FixedIncomeController::class, 'update'])->name('fixed-income.update');
    Route::delete('/fixed-income/{id}', [FixedIncomeController::class, 'delete'])->name('fixed-income.delete');
});

Route::get('/income/get', [IncomeController::class, 'get']);
Route::post('/income/add', [IncomeController::class, 'create']);
Route::put('/income/update/{id}', [IncomeController::class, 'update']);
Route::post('/income/delete', [IncomeController::class, 'delete']);

Route::get('/expenditure/get', [ExpenditureController::class, 'get']);
Route::get('/expenditure/get_by_category', [ExpenditureController::class, 'fetchByCategory']);
Route::get('/expenditure/report', [ExpenditureController::class, 'fetchByPeriod']);
Route::post('/expenditure/add', [ExpenditureController::class, 'create']);
Route::put('/expenditure/update/{id}', [ExpenditureController::class, 'update']);
Route::post('/expenditure/delete', [ExpenditureController::class, 'delete']);

Route::get('/expenditure/fixed/get', [FixedExpenditureController::class, 'get']);
Route::post('/expenditure/fixed/add', [FixedExpenditureController::class, 'create']);
Route::put('/expenditure/fixed/update/{id}', [FixedExpenditureController::class, 'update']);
Route::delete('/expenditure/fixed/{id}', [FixedExpenditureController::class, 'delete']);

Route::get('/income_category/get', [IncomeCategoryController::class, 'get']);
Route::post('/income_category/add', [IncomeCategoryController::class, 'store']);
Route::put('/income_category/update/{id}', [IncomeCategoryController::class, 'update']);
Route::post('/income_category/delete', [IncomeCategoryController::class, 'delete']);

Route::get('/expenditure_category/get', [ExpenditureCategoryController::class, 'get']);
Route::post('/expenditure_category/add', [ExpenditureCategoryController::class, 'store']);
Route::put('/expenditure_category/update/{id}', [ExpenditureCategoryController::class, 'update']);
Route::post('/expenditure_category/delete', [ExpenditureCategoryController::class, 'delete']);

Route::get('/expenditure/export', [ExpenditureController::class, 'export']);
Route::get('/expenditure/export_data', [ExpenditureController::class, 'exportData']);
Route::post('/expenditure/import_csv', [ExpenditureController::class, 'import_csv']);

Route::post('/expenditure/bulk_create', [ExpenditureController::class, 'bulkCreate']);

Route::post('/preset_expenditure_item/confirm', function () {
    return Inertia::render('BulkOperation/Confirm');
});

require __DIR__.'/auth.php';
