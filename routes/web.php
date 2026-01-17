<?php

use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.user.showIndex');
});
Route::prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/index', [ShopController::class, 'showIndex'])->name('showIndex');
    });

Route::prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::prefix('user')
            ->name('user.')
            ->group(function () {
                Route::get('/', [UserController::class, 'showIndex'])->name('showIndex');
            });
    });
