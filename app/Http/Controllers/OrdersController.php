<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;
use Carbon\Carbon;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        $orders = Order::latest('orders.created_at');

        if($date = request('date')) {
            $date = $date == 'today' ? Carbon::today()->startOfDay() : Carbon::now()->subWeek();
            $orders->where('orders.created_at', '>=', $date);
        }

        if($product = request('product_id')) {
            $orders->where('product_id', $product);
        }

        if($user = request('user_id')) {
            $orders->where('user_id', $user);
        }

        if($q = request('q')) {
            $orders->where('users.name', 'like', '%' . $q . '%')
                    ->orWhere('products.name', 'like', '%' . $q . '%');
        }

        $count = $orders->count();

        $orders = $orders
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->selectRaw(
                'users.name user,
                products.name product,
                products.price,
                orders.id,
                orders.quantity,
                orders.total,
                orders.created_at'
            )
            ->paginate(10);

        if(request()->expectsJson()) {
            return response($orders, 200);
        }

        return view('orders.index', compact('orders', 'users', 'products', 'count'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $attributes = request()->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::find($attributes['product_id']);

        Order::create($attributes + ['total' => $product->price * $attributes['quantity']]);

        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        $users = User::pluck('name', 'id');
        $products = Product::pluck('name', 'id');

        return view('orders.edit', compact('order', 'users', 'products'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order)
    {
        $attributes = request()->validate([
            'user_id' => 'required|sometimes',
            'product_id' => 'required|sometimes',
            'quantity' => 'required|sometimes',
        ]);

        $product = Product::find($attributes['product_id']);

        $order->update($attributes + ['total' => $product->price * $attributes['quantity']]);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order $order
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect('/');
    }
}
