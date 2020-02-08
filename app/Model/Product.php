<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $casts = [
        'sizes' => 'json',
    ];
}
