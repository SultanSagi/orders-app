@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        <div class="card mb-2">
            <div class="card-header">Add new order</div>
            <div class="card-body">
                <form action="/orders" method="post">
                    @csrf

                    @include('orders._form', [
                        'order' => new \App\Order,
                        'button' => 'Add',
                        ])
                </form>
            </div>
        </div>

        <table class="table table-bordered table-striped">
            <thead>
            <tr>
                <th>User</th>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ money_format('%.2n', $order->product->price/100) }} EUR</td>
                    <td>{{ $order->quantity }}</td>
                    <td>{{ money_format('%.2n', $order->total/100) }} EUR</td>
                    <td>{{ $order->created_at->format('d M Y, g:iA') }}</td>
                    <td>
                        <a href="/orders/{{$order->id}}/edit">
                            Edit
                        </a>
                         <a href="#">
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>

        {{ $orders->links() }}
        </div>
    </div>
@endsection