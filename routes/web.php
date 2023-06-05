<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ClientController;

// ->middleware('checkUserRole:seller')
Route::get('/', function () {
    return redirect()->route('home');
});

//User
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware(['guest']);

Route::post('/authenticate', [UserController::class, 'authenticate'])->name('authenticate');

Route::get('/logout', [UserController::class, 'logout'])->name('logout');

//Products
Route::get('/home', [ProductsController::class, 'productsAll'])->name('home');

Route::get('/product/{category}', [ProductsController::class, 'product'])->name('product');

Route::get('/product-show/{id}', [ProductsController::class, 'productShow'])->name('product.show');

Route::get('/product-create', [ProductsController::class, 'create'])->name('product.create')->middleware('seller.approved');

Route::post('/product-store', [ProductsController::class, 'store'])->name('product.store')->middleware('seller.approved');

Route::get('/product-edit/{id}', [ProductsController::class, 'edit'])->name('product.edit')->middleware('seller.approved');

Route::post('/product-update/{id}', [ProductsController::class, 'update'])->name('product.update')->middleware('seller.approved');

Route::delete('/image/{id}', [ProductsController::class, 'destroy'])->name('image.delete');

Route::get('/filter', [ProductsController::class, 'filter'])->name('product.filter');


//Admin
Route::get('/products', [AdminController::class, 'products'])->name('admin.products')->middleware('checkUserRole:admin');

Route::get('/sellers', [AdminController::class, 'sellers'])->name('admin.sellers')->middleware('checkUserRole:admin');

Route::post('/seller-status', [AdminController::class, 'sellerStatus'])->name('seller.status')->middleware('checkUserRole:admin');

Route::get('/clients', [AdminController::class, 'clients'])->name('admin.clients')->middleware('checkUserRole:admin');


//Client
Route::get('/client-create', [ClientController::class, 'create'])->name('client.create');

Route::post('/client-store', [ClientController::class, 'store'])->name('client.store');

Route::get('/client-edit', [ClientController::class, 'edit'])->name('client.edit')->middleware('checkUserRole:client');

Route::post('/client-update', [ClientController::class, 'update'])->name('client.update')->middleware('checkUserRole:client');

Route::post('/purchase/{product}', [ClientController::class, 'comprar'])->name('purchase')->middleware('checkUserRole:client');

Route::get('/my-purchases', [ClientController::class, 'purchases'])->name('client.purchases')->middleware('checkUserRole:client');

Route::get('/email/verify/{token}', [ClientController::class, 'verify'])->name('email.verify');

Route::get('forget-password', [ClientController::class, 'showForgetPasswordForm'])->name('forget.password.get')->middleware(['guest']);

Route::post('forget-password', [ClientController::class, 'submitForgetPasswordForm'])->name('forget.password.post')->middleware(['guest']); 

Route::get('reset-password/{token}', [ClientController::class, 'showResetPasswordForm'])->name('reset.password.get')->middleware(['guest']);

Route::post('reset-password', [ClientController::class, 'submitResetPasswordForm'])->name('reset.password.post')->middleware(['guest']);


//Seller
Route::get('/seller-create', [SellerController::class, 'create'])->name('seller.create');

Route::post('/seller-store', [SellerController::class, 'store'])->name('seller.store');

Route::get('/seller-edit', [SellerController::class, 'edit'])->name('seller.edit')->middleware('seller.approved');

Route::post('/seller-update', [SellerController::class, 'update'])->name('seller.update')->middleware('seller.approved');

Route::get('/sold', [SellerController::class, 'sold'])->name('seller.sold')->middleware('seller.approved');