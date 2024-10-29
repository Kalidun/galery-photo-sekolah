<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::controller(LoginController::class)->group(function () {
  Route::get('/login', 'index')->name('login');
  Route::post('/login', 'login')->name('login');
  Route::post('/logout', 'destroy')->name('logout');
});
Route::controller(RegisterController::class)->group(function () {
  Route::get('/register', 'index')->name('register');
  Route::post('/register', 'register')->name('register');
});