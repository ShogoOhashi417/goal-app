<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/task', 'App\Http\Controllers\TaskController@index')->name('task');

Route::get('/task/get', 'App\Http\Controllers\TaskController@get');

Route::post('/task/create', 'App\Http\Controllers\TaskController@create');

Route::post('/task/update', 'App\Http\Controllers\TaskController@update');

Route::post('/task/delete', 'App\Http\Controllers\TaskController@remove');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/income', 'App\Http\Controllers\Income\IncomeController@index')->name('income');

Route::get('/income/get', 'App\Http\Controllers\Income\IncomeController@get');

Route::post('income/add', 'App\Http\Controllers\Income\IncomeController@create');

Route::post('income/update', 'App\Http\Controllers\Income\IncomeController@update');

Route::post('income/delete', 'App\Http\Controllers\Income\IncomeController@delete');

Route::get('/expenditure', 'App\Http\Controllers\Expenditure\ExpenditureController@index')->name('expenditure');

Route::get('/expenditure/get', 'App\Http\Controllers\Expenditure\ExpenditureController@get');

Route::post('expenditure/add', 'App\Http\Controllers\Expenditure\ExpenditureController@create');

Route::get('/life_insurance', 'App\Http\Controllers\LifeInsuranceController@index')->name('life_insurance');
Route::get('/life_insurance', 'App\Http\Controllers\LifeInsuranceController@index')->name('life_insurance');

Route::get('/life_insurance/get', 'App\Http\Controllers\LifeInsuranceController@get');

Route::post('/life_insurance/create', 'App\Http\Controllers\LifeInsuranceController@create');

Route::post('/life_insurance/delete', 'App\Http\Controllers\LifeInsuranceController@remove');
// Route::get('/life_insurance/delete', 'App\Http\Controllers\LifeInsuranceController@remove');

require __DIR__.'/auth.php';
