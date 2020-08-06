<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin\Brand;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

$factory->define(Brand::class, function (Faker $faker) {
    $path = public_path('uploads/images/product-brands');
    if (!File::isDirectory($path)) {
        File::makeDirectory($path, 0777, true, true);
    }
    return [
        'name'        => $name = $faker->name,
        'slug'        => Str::slug($name),
        'description' => $faker->paragraph(rand(20, 25)),
        'thumbnail'   => $faker->image('public/uploads/images/product-brands', 300, 300, 'transport', false)
    ];
});