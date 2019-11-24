<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function getPriceAttribute($value)
    {
        return money_format('%.2n', $value/100);
    }
}
