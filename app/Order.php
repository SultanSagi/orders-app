<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    protected $guarded = [
        'id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getTotalAttribute()
    {
        $rate = $this->canBeCalculatedWithDiscount() ? 1-$this->product->discount/100 : 1;

        return money_format('%.2n',$this->quantity * $this->product->price * $rate);
    }

    public function scopeFilter($query, $filters)
    {
        if(array_key_exists('date', $filters) && $date = $filters['date']) {
            $date = $date == 'today' ? Carbon::today() : Carbon::now()->subWeek();
            $query->where('orders.created_at', '>=', $date->startOfDay());
        }

        if(array_key_exists('product_id', $filters) && $product = $filters['product_id']) {
            $query->where('product_id', $product);
        }

        if(array_key_exists('user_id', $filters) && $user = $filters['user_id']) {
            $query->where('user_id', $user);
        }

        if(array_key_exists('q', $filters) && $q = $filters['q']) {
            $query->where(function ($query) use ($q) {
                $query->whereHas('user', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                })
                ->orWhereHas('product', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                });
            });
        }
    }

    public function canBeCalculatedWithDiscount()
    {
        return $this->product->name == 'Pepsi Cola' && $this->product->discount && $this->quantity > 2;
    }
}
