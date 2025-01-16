<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\firstController;
use App\Http\Controllers\User;
use App\Http\Controllers\UserController;
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

// to open guest home page
Route::get('/', [firstController::class, 'home'])->name("home");



// Logged user controller

Route::middleware(['checkUser'])->group(function () {

    Route::get('/user-home', [UserController::class, 'userHome'])->name('userHome');
    Route::get('add-to-cart-{id}', [UserController::class, 'addToCart']);
    Route::get('user-profile', [UserController::class, 'userProfile'])->name('user-profile');
    Route::get('cart', [UserController::class, 'cart'])->name('cart');
    Route::get('/book{id}', [UserController::class, 'book']);
    Route::get('change-quantity-{id}-{q}', [UserController::class, 'changeQuantity']);
    Route::get('delete-cart-item-{id}', [UserController::class, 'deleteCartItem']);
    Route::get('checkout', [UserController::class, 'checkout']);
    Route::post('checkout', [UserController::class, 'checkoutKaro']);
});


// to open login page
Route::post("login", [User::class, "login"]);




// this is for admin related routes

Route::middleware(['checkUser'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        // Route for the admin home page
        Route::get('/admin-home', 'adminHome')->name('admin-home')->middleware("checkUser");

        // Route to show the 'add book' view
        Route::get('add-book', 'addBookView')->middleware('checkPermission:add_books');
        Route::post('add-book', 'addBookMethod')->middleware("checkPermission:add_books");
        Route::get('view-books', 'viewBooks');

        // Route to view customers (using the viewCustomers method of AdminController)
        Route::get('/view-customers', [AdminController::class, 'viewCustomers'])->name('view_customers');

        // Route to view suppliers (using the viewSuppliers method of AdminController)
        Route::get('/view-suppliers', [AdminController::class, 'viewSuppliers'])->name('view_suppliers');

        // Route to view admins (using the viewAdmins method of AdminController)
        Route::get('/view-admins', [AdminController::class, 'viewAdmins'])->name('view_admins');

        // Route to view genre (using the viewGenre method of AdminController)
        Route::get('/view-genre', 'viewGenre')->name('view_genre')->middleware('checkPermission:add_genre');

        // Route to handle adding a new genre (using the newGenre method of AdminController)
        Route::post('/addgenre', 'newGenre');

        // Route to export genre

        Route::get('export-genre', 'exportGenre');

        // Route to assing permissions to rols

        Route::get('assign-permissions-{role}', 'assignPermissionsView');
        Route::post('assign-permission', 'assignPermissionsMethod');
    });

    // this is for user related routes

    Route::controller(User::class)->group(function () {

        Route::post("new-user", [User::class, "addNewUser"])->name("new-user");
        Route::get("profile", [User::class, "profile"])->name("profile");
        Route::get("logout", [User::class, "logout"])->name("logout");
    });
});