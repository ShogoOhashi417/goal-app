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

Route::get('/life_insurance', function () {
    return view('life_insurance');
})->name('life_insurance');

require __DIR__.'/auth.php';
