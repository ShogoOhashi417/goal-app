<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Income\IncomeController;
use App\Domain\Model\Category\Income\IncomeCategory;
use App\Http\Controllers\ExpenditureCategoryController;
use App\Http\Controllers\Expenditure\ExpenditureController;
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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/income', function () {
    return Inertia::render('Income/Index');
})->middleware(['auth', 'verified'])->name('income');

Route::get('/expenditure', function () {
    return Inertia::render('Expenditure/Index');
})->middleware(['auth', 'verified'])->name('expenditure');

Route::get('/category', function () {
    return Inertia::render('Category/Index');
})->middleware(['auth', 'verified'])->name('category');

Route::get('/report', function () {
    return Inertia::render('Report/Index');
})->middleware(['auth', 'verified'])->name('report');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/income/get', [IncomeController::class, 'get']);
Route::post('/income/add', [IncomeController::class, 'create']);
Route::post('/income/update', [IncomeController::class, 'update']);
Route::post('/income/delete', [IncomeController::class, 'delete']);

Route::get('/expenditure/get', [ExpenditureController::class, 'get']);
Route::post('/expenditure/add', [ExpenditureController::class, 'create']);
Route::post('/expenditure/update', [ExpenditureController::class, 'update']);
Route::post('/expenditure/delete', [ExpenditureController::class, 'delete']);

Route::get('/income_category/get', [IncomeCategoryController::class, 'get']);
Route::post('/income_category/add', [IncomeCategoryController::class, 'store']);

Route::get('/expenditure_category/get', [ExpenditureCategoryController::class, 'get']);
Route::post('/expenditure_category/add', [ExpenditureCategoryController::class, 'store']);

require __DIR__.'/auth.php';
