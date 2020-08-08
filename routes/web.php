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

        Route::get('product-category/export-to-excel', 'ProductCategoryController@export_to_excel')->name('product-category.export_to_excel');
        Route::get('product-category/export-to-csv', 'ProductCategoryController@export_to_csv')->name('product-category.export_to_csv');
        Route::get('product-category/export-to-pdf', 'ProductCategoryController@export_to_pdf')->name('product-category.export_to_pdf');
        Route::post('product-category/{id}/restore', 'ProductCategoryController@restore')->name('product-category.restore');
        Route::post('product-category/{id}/force-delete', 'ProductCategoryController@force_delete')->name('product-category.force_delete');
        Route::post('product-category/bulk-delete', 'ProductCategoryController@bulk_delete')->name('product-category.bulk_delete');
        Route::post('product-category/bulk-force-delete', 'ProductCategoryController@bulk_force_delete')->name('product-category.bulk_force_delete');
        Route::post('product-category/bulk-restore', 'ProductCategoryController@bulk_restore')->name('product-category.bulk_restore');

        Route::post('product-category/bulk-active', 'ProductCategoryController@bulk_active')->name('product-category.bulk_active');
        Route::post('product-category/bulk-inactive', 'ProductCategoryController@bulk_inactive')->name('product-category.bulk_inactive');
        Route::resource('product-category', 'ProductCategoryController');

        Route::get('brand/export-to-excel', 'BrandController@export_to_excel')->name('brand.export_to_excel');
        Route::get('brand/export-to-csv', 'BrandController@export_to_csv')->name('brand.export_to_csv');
        Route::get('brand/export-to-pdf', 'BrandController@export_to_pdf')->name('brand.export_to_pdf');
        Route::post('brand/{id}/restore', 'BrandController@restore')->name('brand.restore');
        Route::post('pbrand/{id}/force-delete', 'BrandController@force_delete')->name('brand.force_delete');
        Route::post('brand/bulk-delete', 'BrandController@bulk_delete')->name('brand.bulk_delete');
        Route::post('brand/bulk-force-delete', 'BrandController@bulk_force_delete')->name('brand.bulk_force_delete');
        Route::post('brand/bulk-restore', 'BrandController@bulk_restore')->name('brand.bulk_restore');
        Route::post('brand/bulk-active', 'BrandController@bulk_active')->name('brand.bulk_active');
        Route::post('brand/bulk-inactive', 'BrandController@bulk_inactive')->name('brand.bulk_inactive');
        Route::resource('brand', 'BrandController');

    });
});