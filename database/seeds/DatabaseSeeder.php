<?php

use App\Models\Admin\Brand;
use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        File::deleteDirectory(public_path('uploads/images'));
        // $this->call(UserSeeder::class);
        $this->call(UserSeeder::class);
        factory(ProductCategory::class, 15)->create();
        factory(Brand::class, 15)->create();
        factory(Product::class, 40)->create();
    }
}