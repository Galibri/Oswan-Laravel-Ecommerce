<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Controller;
use App\Models\Admin\ProductCategory;

class HomeController extends Controller
{
    public function home()
    {
        $category_ids           = OptionController::get_option('home_products_by_categories', true);
        $slideProductCategories = ProductCategory::whereIn('id', $category_ids)->has('products')->get();
        return view('frontend.home.index', compact('slideProductCategories'));
    }
}