<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Customer\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('customer.showIndex');
});
Route::prefix('auth')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');

    Route::post('/login', [AuthController::class, 'postLogin'])->name('postLogin');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});
Route::prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/index', [ShopController::class, 'showIndex'])->name('showIndex');
        Route::get('/contact', [ShopController::class, 'showContact'])->name('showContact');
    });

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('employee')
            ->name('employee.')
            ->group(function () {
                Route::get('/', [EmployeeController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [EmployeeController::class, 'showCreate'])->name('showCreate');
                Route::get('/edit/{id}', [EmployeeController::class, 'showEdit'])->name('showEdit');
            });

        Route::prefix('customer')
            ->name('customer.')
            ->group(function () {
                Route::get('/', [CustomerController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [CustomerController::class, 'showCreate'])->name('showCreate');
                Route::get('/edit/{id}', [CustomerController::class, 'showEdit'])->name('showEdit');
            });

        Route::prefix('category')
            ->name('category.')
            ->group(function () {
                Route::get('/', [CategoryController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [CategoryController::class, 'showCreate'])->name('showCreate');
                Route::get('/edit/{id}', [CategoryController::class, 'showEdit'])->name('showEdit');
            });

        Route::prefix('product')
            ->name('product.')
            ->group(function () {
                Route::get('/', [ProductController::class, 'showIndex'])->name('showIndex');
                Route::get('/create', [ProductController::class, 'showCreate'])->name('showCreate');
                Route::get('/edit/{id}', [ProductController::class, 'showEdit'])->name('showEdit');
                Route::get('/detail/{id}', [ProductController::class, 'showDetail'])->name('showDetail');
            });
    });
