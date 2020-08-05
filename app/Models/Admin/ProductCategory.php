<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function getStatusTextAttribute()
    {
        if ($this->status == false) {
            return __('Inactive');
        }
        return __('Active');
    }

    public function setThumbnailAttribute($value)
    {
        $this->attributes['thumbnail'] = 'uploads/images/product-categories/' . $value;
    }

    public function getDefaultThumbnailAttribute()
    {
        if ($this->thumbnail == null) {
            return 'assets/150.jpg';
        }
        return $this->thumbnail;
    }

}
