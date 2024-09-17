<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::prefix('admin')
->middleware(['admin_auth', 'auth'])
    ->as('admin.')
    ->group(function () {

        Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('index');

        Route::prefix('users')
        ->as('users.')
        ->group(function () {
            Route::get('edit', [UserController::class, 'edit'])->name('edit');
            Route::put('update', [UserController::class, 'update'])->name('update');
        });

        Route::prefix('books')
            ->as('books.')
            ->group(function () {
                Route::get('/', [BookController::class, 'index'])->name('index');
                Route::get('create', [BookController::class, 'create'])->name('create');
                Route::post('store', [BookController::class, 'store'])->name('store');
                Route::get('edit/{id}', [BookController::class, 'edit'])->name('edit');
                Route::put('update/{id}', [BookController::class, 'update'])->name('update');
                Route::delete('destroy/{id}', [BookController::class, 'destroy'])->name('destroy');

                Route::post('/', [BookController::class, 'search'])->name('search');
            });
    });

