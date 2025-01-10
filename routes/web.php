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
    // Route for the admin home page
    Route::get('/admin-home', 'adminHome')->name('admin-home');

    // Route to show the 'add book' view
    Route::get('add-book', 'addBookView');

    // Route to view customers (using the viewCustomers method of AdminController)
    Route::get('/view-customers', [AdminController::class, 'viewCustomers'])->name('view_customers');

    // Route to view suppliers (using the viewSuppliers method of AdminController)
    Route::get('/view-suppliers', [AdminController::class, 'viewSuppliers'])->name('view_suppliers');

    // Route to view admins (using the viewAdmins method of AdminController)
    Route::get('/view-admins', [AdminController::class, 'viewAdmins'])->name('view_admins');

    // Route to view genre (using the viewGenre method of AdminController)
    Route::get('/view-genre', 'viewGenre')->name('view_genre');

    // Route to handle adding a new genre (using the newGenre method of AdminController)
    Route::post('/addgenre', 'newGenre');

    // Route to export genre

    Route::get('export-genre', 'exportGenre');
});


// this is for user related routes

Route::controller(User::class)->group(function () {
    Route::post("new-user", "addNewUser");
    Route::post("login", "login");
    Route::get("profile", "profile")->name("profile");
    Route::get("logout", 'logout');
});
