<?php

use App\Console\Commands\SendNotification;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\firstController;
use App\Http\Controllers\Notification;
use App\Http\Controllers\SupplierController;
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

    Route::get('/invoice-{id}', [UserController::class, 'downloadInvoie']);

    Route::post("order-rating{id}", [UserController::class, 'orderRating']);
});


// to open login page
Route::post("login", [User::class, "login"]);
Route::post("new-user", [User::class, "addNewUser"])->name("new-user");




// this is for admin related routes

Route::middleware(['checkUser'])->group(function () {


    Route::middleware(['checkRole:admin'])->group(function () {

        Route::controller(AdminController::class)->group(function () {
            // Route for the admin home page
            Route::get('/admin-home', 'adminHome')->name('admin-home')->middleware("checkUser");

            // Route to show the 'add book' view

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


            // Route to edit order status

            Route::post('confirm-order', [AdminController::class, 'confirmOrder']);
            Route::post('cancel-order', [AdminController::class, 'cancelOrder']);


            // To show a book

            Route::get('/get-book-details/{id}', [AdminController::class, 'getBookDetails']);
        });
    });

    Route::middleware(['checkRole:supplier'])->group(function () {

        // to show supplier home
        Route::get('/supplier-home', [SupplierController::class, 'supplierHome'])->name('supplier-home');

        // to show profile

        Route::get('supplier-profile', [User::class, 'supplierProfile'])->name('supplier-profile');

        // to add new book
        Route::get('supplier-add-book', [SupplierController::class, 'addBookView'])->middleware('checkPermission:add_books');
        Route::post('supplier-add-book', [SupplierController::class, 'addBookMethod'])->middleware("checkPermission:add_books");

        // // to show book on supplier
        Route::get('supplier-view-books', [SupplierController::class, 'viewBooks'])->middleware("checkPermission:view_products");




        // Route to edit order status

        Route::post('supplier-confirm-order', [SupplierController::class, 'supplierConfirmOrder']);
        Route::post('supplier-cancel-order', [SupplierController::class, 'supplierCancelOrder']);

        // // Route to view genre (using the viewGenre method of AdminController)
        // Route::get('/view-genre', 'viewGenre')->name('view_genre')->middleware('checkPermission:add_genre');

        // // Route to handle adding a new genre (using the newGenre method of AdminController)
        // Route::post('/addgenre', 'newGenre');

        // // Route to export genre

        // Route::get('export-genre', 'exportGenre');
    });




    // this is for user related routes

    Route::controller(User::class)->group(function () {

        Route::get("profile", [User::class, "profile"])->name("profile")->middleware("checkRole:admin");
        Route::get("logout", [User::class, "logout"])->name("logout");
    });
});


Route::get('/temperature', [firstController::class, 'temperature']);
Route::post('/temperature', [firstController::class, 'getTemperature']);


// to send notification using queue

Route::get('/queue-notification', [Notification::class, 'sendNotification']);
