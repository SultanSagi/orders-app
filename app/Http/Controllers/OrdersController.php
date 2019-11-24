<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\User;

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

        $orders = Order::latest('created_at')
            ->filter(request(['date', 'product_id', 'user_id', 'q']))
            ->with('user', 'product')
            ->paginate(10);

        if(request()->expectsJson()) {
            return response($orders, 200);
        }

        return view('orders.index', compact('orders', 'users', 'products'));
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

        Order::create($attributes);

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

        $order->update($attributes);

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
