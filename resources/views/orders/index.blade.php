@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">

        <div class="card mb-2">
            <div class="card-header">Add new order</div>
            <div class="card-body">
                <form action="/orders" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="user_id" class="col-form-label">User</label>
                        <select id="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id">
                            @foreach ($users as $user => $label)
                                <option value="{{ $user }}"{{ $user == old('user_id') ? ' selected' : '' }}>{{ $label }}</option>
                            @endforeach;
                        </select>
                        @if ($errors->has('user_id'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('user_id') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="product_id" class="col-form-label">Product</label>
                        <select id="product_id" class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" name="product_id">
                            @foreach ($products as $product => $label)
                                <option value="{{ $product }}"{{ $product == old('product_id') ? ' selected' : '' }}>{{ $label }}</option>
                            @endforeach;
                        </select>
                        @if ($errors->has('product_id'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('product_id') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="quantity" class="col-form-label">Quantity</label>
                        <input type="number" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity') }}">
                        @if ($errors->has('quantity'))
                            <span class="invalid-feedback"><strong>{{ $errors->first('quantity') }}</strong></span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
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