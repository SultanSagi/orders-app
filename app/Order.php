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
        return $this->quantity * $this->product->price;
    }

    public function scopeFilter($query, $filters)
    {
        if(array_key_exists('date', $filters) && $date = $filters['date']) {
            $date = $date == 'today' ? Carbon::today()->startOfDay() : Carbon::now()->subWeek();
            $query->where('orders.created_at', '>=', $date);
        }

        if(array_key_exists('product_id', $filters) && $product = $filters['product_id']) {
            $query->where('product_id', $product);
        }

        if(array_key_exists('user_id', $filters) && $user = $filters['user_id']) {
            $query->where('user_id', $user);
        }

        if(array_key_exists('q', $filters) && $q = $filters['q']) {
            $query->whereHas('user', function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            })
            ->orWhereHas('product', function ($query) use ($q) {
                $query->where('name', 'like', '%' . $q . '%');
            });
        }
    }
}
