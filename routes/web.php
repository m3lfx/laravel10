<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;

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
Route::get('add-to-cart/{id}', [ItemController::class, 'addToCart'])->name('addToCart');
Route::get('shopping-cart', [ItemController::class, 'getCart'])->name('getCart');
Route::get('reduce/{id}', [ItemController::class, 'getReduceByOne'])->name('reduceByOne');


Route::get('remove/{id}', [
    ItemController::class, 'getRemoveItem'
])->name('removeItem');
Route::group(['prefix' => 'user'], function () {

    Route::get('register', [UserController::class, 'register'])->name('user.register');
    Route::post('signup', [UserController::class, 'postSignup'])->name('user.signup');
    Route::get('login', [UserController::class, 'login'])->name('user.login');
    Route::post('signin', [UserController::class,'postSignin'])->name('user.sign-in');
    Route::get('profile', [UserController::class, 'getProfile'])->name('user.profile');
});
Route::get('/admin/customers',[DashboardController::class, 'getCustomers'])->name('admin.customers');
Route::get('/admin/users',[DashboardController::class,'getUsers'])->name('admin.users');
Route::get('/admin/orders',[DashboardController::class,'getOrders'])->name('admin.orders');

Route::prefix('admin')->group(function () {
    
    Route::get('/orders/{id}',[OrderController::class,'processOrder'])->name('admin.orderDetails');
    Route::post('/order/{id}', [OrderController::class, 'orderUpdate'])->name('admin.orderUpdate');
   
    
});
Route::get('/', function () {
    return view('welcome');
});
