<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Create\CreatePhotoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for   your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('/logout', 'destroy')->name('logout');
    });
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
    });
    Route::prefix('create')->group(function () {
        Route::controller(CreatePhotoController::class)->group(function () {
            Route::get('/', 'index')->name('create.index');
            Route::post('/', 'store')->name('create.store');
        });
    });
    Route::prefix('profile')->group(function () {
       Route::controller(ProfileController::class)->group(function () {
           Route::get('/', 'index')->name('profile.index');
       });
    });
});


require __DIR__ . '/auth.php';
