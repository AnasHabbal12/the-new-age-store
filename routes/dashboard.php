<?php
use App\Http\Controllers\Dashboard\CategriesController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductsController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\RolesController;

use Illuminate\Support\Facades\Route;
// ['auth' , 'auth.type:admin,super-admin' ]   same table middleware
// ['auth:admin' ] multi guard middleware on guard admin
Route::group( ['middleware'=> ['auth:admin,web' ], 'as' => 'dashboard.', 'prefix' => 'admin/dashboard'], function() {

    Route::get('prifile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('prifile', [ProfileController::class, 'update'])->name('profile.update');


    Route::get('', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('categories/trash', [CategriesController::class, 'trash'] )->name('categories.trash');
    Route::put('categories/{category}/restore', [CategriesController::class, 'restore'] )->name('categories.restore');
    Route::delete('categories/{category}/force-delete', [CategriesController::class, 'forceDelete'] )->name('categories.force-delete');
    // Route::resource('/categories', CategriesController::class);
    // Route::resource('/products', ProductsController::class);
    // Route::resource('/rules', ProductsController::class);
    Route::resources([
        '/categories'=> CategriesController::class,
        '/products'=> ProductsController::class,
        '/roles'=> RolesController::class,
    ]);
    //dashboard.roles.index
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

