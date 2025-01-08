<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\firstController;
use App\Http\Controllers\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// This is 
Route::controller(firstController::class)->group(function () {
    Route::get('/', 'home')->name("home");
});


// this is for admin related routes
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin-home', 'adminHome')->name('admin-home');
    Route::get('add-book', 'addBookView');
});

// this is for user related routes

Route::controller(User::class)->group(function () {
    Route::post("new-user", "addNewUser");
});
