<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Option;
use App\Models\Admin\ProductCategory;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function home_category()
    {
        $productCategories = ProductCategory::whereStatus(1)->latest()->get();
        $selected          = [];
        if (self::get_option('home_products_by_categories', true)) {
            $selected = self::get_option('home_products_by_categories', true);
        }
        return view('admin.option.home-category', compact('productCategories', 'selected'));
    }

    public function home_category_store(Request $request)
    {
        Option::updateOrCreate(
            ['key' => 'home_products_by_categories'],
            ['value' => json_encode($request->home_products_by_categories)]
        );
        return redirect()->back()->with('success', 'Option saved');
    }

    /**
     * Retrive values
     */
    public static function get_option($key, $isJson = false)
    {
        if ($isJson === false) {
            $data = Option::where('key', $key)->latest()->first();
            if ($data) {
                return $data->value;
            }
            return false;
        }
        $data = Option::where('key', $key)->first();
        if ($data) {
            return json_decode($data->value, true);
        }
        return false;
    }
}