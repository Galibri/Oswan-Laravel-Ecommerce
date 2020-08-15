<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['starts_at', 'expires_at'];

    public function getCouponTypeAttribute()
    {
        return $this->is_fixed == true ? __('Fixed') : __('Percentage');
    }

    public function getStatusTextAttribute()
    {
        return $this->status == true ? __('Active') : __('Inactive');
    }
}