@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        <p><a href="#" class="btn btn-success">Add User</a></p>

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
                        <a href="#">
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