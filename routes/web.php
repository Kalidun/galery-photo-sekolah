<?php

use App\Http\Controllers\Album\AlbumController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Comment\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\Photo\PhotoController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfileEditController;
use App\Http\Controllers\Profile\ProfileSettingController;
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
        Route::get('/get-data/{id}', 'getData')->name('home.get-data');
    });
    Route::controller(CommentController::class)->group(function () {
       Route::post('/comment', 'store')->name('comment.store'); 
    });
    Route::prefix('like')->group(function () {
        Route::controller(LikeController::class)->group(function () { 
            Route::post('/store', 'store')->name('like.store');
            Route::post('/destroy', 'destroy')->name('like.destroy');
        });
    });
    Route::prefix('photos')->group(function () {
        Route::controller(PhotoController::class)->group(function () {
            Route::get('/', 'index')->name('photos.index');
            Route::post('/', 'store')->name('photos.store');
            Route::get('/{id}', 'edit')->name('photos.edit');
            Route::post('/update/{id}', 'update')->name('photos.update');
            Route::post('/{id}', 'destroy')->name('photos.destroy');
        });
    });
    Route::prefix('album')->group(function () {
        Route::controller(AlbumController::class)->group(function () {
            Route::get('/', 'index')->name('album.index');
            Route::post('/', 'store')->name('album.store');
            Route::get('/all-photos', 'allPhotos')->name('album.read-all');
            Route::get('/{id}', 'read')->name('album.read');
        });
    });
    Route::prefix('profile')->group(function () {
       Route::controller(ProfileController::class)->group(function () {
           Route::get('/', 'index')->name('profile.index');
           Route::post('/delete-profile', 'deleteProfile')->name('profile.delete-profile');
       });
       Route::controller(ProfileEditController::class)->group(function () {
          Route::get('/edit', 'index')->name('profile.edit'); 
          Route::post('/edit', 'update')->name('profile.update');
       });
       Route::controller(ProfileSettingController::class)->group(function () {
           Route::get('/settings', 'index')->name('profile.settings');
           Route::post('/settings/update-name', 'updateName')->name('profile.settings.update-name');    
           Route::post('/settings/update-password', 'updatePassword')->name('profile.settings.update-password');
           Route::post('/settings/destroy', 'destroy')->name('profile.settings.destroy');
       });
    });
});


require __DIR__ . '/auth.php';
