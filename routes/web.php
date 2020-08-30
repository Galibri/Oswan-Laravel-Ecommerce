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

Route::namespace ('Auth')->group(function () {
    Route::get('/login', 'LoginController@login_page')->name('login-form');
    Route::post('/login', 'LoginController@process_login')->name('login');

    Route::post('/logout', 'LogoutController@logout')->name('logout')->middleware('auth');
});

Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

    Route::middleware('auth')->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/dashboard', 'DashboardController@index');

        // Product Category Routes
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

        // Product Brand Routes
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

        // Product Routes
        Route::get('product/export-to-excel', 'ProductController@export_to_excel')->name('product.export_to_excel');
        Route::get('product/export-to-csv', 'ProductController@export_to_csv')->name('product.export_to_csv');
        Route::get('product/export-to-pdf', 'ProductController@export_to_pdf')->name('product.export_to_pdf');
        Route::post('product/{id}/restore', 'ProductController@restore')->name('product.restore');
        Route::post('pproduct/{id}/force-delete', 'ProductController@force_delete')->name('product.force_delete');
        Route::post('product/bulk-delete', 'ProductController@bulk_delete')->name('product.bulk_delete');
        Route::post('product/bulk-force-delete', 'ProductController@bulk_force_delete')->name('product.bulk_force_delete');
        Route::post('product/bulk-restore', 'ProductController@bulk_restore')->name('product.bulk_restore');
        Route::post('product/bulk-active', 'ProductController@bulk_active')->name('product.bulk_active');
        Route::post('product/bulk-inactive', 'ProductController@bulk_inactive')->name('product.bulk_inactive');
        Route::resource('product', 'ProductController');

        // Product Gallery
        Route::resource('/product/{product_id}/gallery', 'GalleryController');

        // Coupon Routes
        // Product Routes
        Route::get('coupon/export-to-excel', 'CouponController@export_to_excel')->name('coupon.export_to_excel');
        Route::get('coupon/export-to-csv', 'CouponController@export_to_csv')->name('coupon.export_to_csv');
        Route::get('coupon/export-to-pdf', 'CouponController@export_to_pdf')->name('coupon.export_to_pdf');
        Route::post('coupon/{id}/restore', 'CouponController@restore')->name('coupon.restore');
        Route::post('coupon/{id}/force-delete', 'CouponController@force_delete')->name('coupon.force_delete');
        Route::post('coupon/bulk-delete', 'CouponController@bulk_delete')->name('coupon.bulk_delete');
        Route::post('coupon/bulk-force-delete', 'CouponController@bulk_force_delete')->name('coupon.bulk_force_delete');
        Route::post('coupon/bulk-restore', 'CouponController@bulk_restore')->name('coupon.bulk_restore');
        Route::post('coupon/bulk-active', 'CouponController@bulk_active')->name('coupon.bulk_active');
        Route::post('coupon/bulk-inactive', 'CouponController@bulk_inactive')->name('coupon.bulk_inactive');
        Route::resource('coupon', 'CouponController');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('home-category', 'OptionController@home_category')->name('home.category');
            Route::post('home-category', 'OptionController@home_category_store')->name('home.category.store');
        });

    });
});

Route::name('frontend.')->namespace('Frontend')->group(function () {
    Route::get('/', 'HomeController@home')->name('home');
});