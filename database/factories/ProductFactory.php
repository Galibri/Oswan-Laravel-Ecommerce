<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

$factory->define(Product::class, function (Faker $faker) {
    $path = public_path('uploads/images/products');
    if (!File::isDirectory($path)) {
        File::makeDirectory($path, 0777, true, true);
    }
    $randomLetters = '';
    for ($i = 0; $i < 5; $i++) {
        $randomLetters .= strtoupper($faker->randomLetter);
    }
    return [
        'title'               => $title = $faker->text(60),
        'slug'                => Str::slug($title),
        'product_category_id' => ProductCategory::all()->random()->id,
        'brand_id'            => Brand::all()->random()->id,
        'short_description'   => $faker->paragraph(rand(2, 7)),
        'description'         => $faker->paragraph(rand(30, 40)),
        'price'               => $price = $faker->randomFloat(2, 10, 100),
        'selling_price'       => $price - rand(0, 5),
        'sku'                 => rand(10, 99) . $randomLetters . rand(10, 99),
        'qty'                 => rand(15, 100),
        'virtual'             => false,
        'thumbnail'           => $faker->image('public/uploads/images/products', 600, 600, 'transport', false),
        'status'              => true
    ];
});