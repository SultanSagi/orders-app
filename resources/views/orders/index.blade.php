@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-6 justify-content-center">
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
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-header">Search</div>
                    <div class="card-body">
                        <form action="?" method="GET">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="date" id="date" class="form-control">
                                            <option value="">All time</option>
                                            <option value="week"{{ request('date') == 'week' ? 'selected' : '' }}>Last 7 days</option>
                                            <option value="today"{{ request('date') == 'today' ? 'selected' : '' }}>Today</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select id="user_id" class="form-control" name="user_id">
                                            <option value="">All users</option>
                                            @foreach ($users as $user => $label)
                                                <option value="{{ $user }}"{{ $user == request('user_id') ? ' selected' : '' }}>{{ $label }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select id="product_id" class="form-control" name="product_id">
                                            <option value="">All products</option>
                                            @foreach ($products as $product => $label)
                                                <option value="{{ $product }}"{{ $product == request('product_id') ? ' selected' : '' }}>{{ $label }}</option>
                                            @endforeach;
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        Rows count: {{ $count }}
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

                @forelse ($orders as $order)
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

                            <form method="POST" action="/orders/{{$order->id}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <p>No orders yet.</p>
                @endforelse

                </tbody>
            </table>

        {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection