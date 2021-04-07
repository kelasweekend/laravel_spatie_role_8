<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::group(['middleware' => ['auth', 'dontback']], function() {
    Route::get('/home', [App\Http\Controllers\Home\HomeController::class, 'index'])->name('home');
    Route::resource('dashboard/roles', App\Http\Controllers\Role\RoleController::class);
    Route::resource('dashboard/permissions', App\Http\Controllers\Role\PermissionsController::class);
    Route::resource('dashboard/users', App\Http\Controllers\User\UserController::class);
    Route::resource('dashboard/products', App\Http\Controllers\ProductController::class);
});