<?php

namespace App\Models\Frontend;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    public function user()
    {
        $this->belongsTo(User::class);
    }
}