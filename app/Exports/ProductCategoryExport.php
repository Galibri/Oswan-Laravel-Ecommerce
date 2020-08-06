<?php

namespace App\Exports;

use App\Models\Admin\ProductCategory;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductCategoryExport implements FromCollection
{
    public function collection()
    {
        return ProductCategory::all();
    }
}