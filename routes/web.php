<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/dashboard', function () {
//     return view('layouts.backend');
// });

Route::get('403', function () {
    abort(403);
})->name('403');

Route::middleware('auth')->controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard');
});

Route::middleware('auth')->controller(UserController::class)->group(function () {
    Route::get('user', 'index')->name('user');
    Route::post('user', 'store')->name('user.store');
    Route::get('fetchUser', 'fetchUser')->name('user.fetch');
    Route::get('user/edit', 'edit')->name('user.edit');
    Route::post('user/edit', 'update')->name('user.update');
    Route::post('user/destroy', 'destroy')->name('user.destroy');
    Route::post('user/destroy/selected', 'destroySelected')->name('user.destroySelected');
});


Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'index')->name('login.index');
    Route::post('login', 'store')->name('login.store');
    Route::get('logout', 'logout')->name('logout');
});
