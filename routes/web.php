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

Route::namespace ('Auth')->group(function () {
    Route::get('/login', 'LoginController@login_page')->name('login-form');
    Route::post('/login', 'LoginController@process_login')->name('login');

    Route::post('/logout', 'LogoutController@logout')->name('logout')->middleware('auth');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/dashboard', 'DashboardController@index');

        Route::resource('product-category', 'ProductCategoryController');
        Route::post('product-category/{id}/restore', 'ProductCategoryController@restore')->name('product-category.restore');
        Route::post('product-category/{id}/force-delete', 'ProductCategoryController@force_delete')->name('product-category.force_delete');
        Route::post('product-category/bulk-delete', 'ProductCategoryController@bulk_delete')->name('product-category.bulk_delete');
        Route::post('product-category/bulk-force-delete', 'ProductCategoryController@bulk_force_delete')->name('product-category.bulk_force_delete');
    });
});