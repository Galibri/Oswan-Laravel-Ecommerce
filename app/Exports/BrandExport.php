<?php

namespace App\Exports;

use App\Models\Admin\Brand;
use Maatwebsite\Excel\Concerns\FromCollection;

class BrandExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Brand::all();
    }
}
