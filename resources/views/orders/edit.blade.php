@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <form action="/orders/{{$order->id}}" method="post">
                @csrf
                @method('patch')

                <div class="form-group">
                    <label for="user_id" class="col-form-label">User</label>
                    <select id="user_id" class="form-control{{ $errors->has('user_id') ? ' is-invalid' : '' }}" name="user_id">
                        @foreach ($users as $user => $label)
                            <option value="{{ $user }}"{{ $user == old('user_id', $order->user_id) ? ' selected' : '' }}>{{ $label }}</option>
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
                            <option value="{{ $product }}"{{ $product == old('product_id',$order->product_id) ? ' selected' : '' }}>{{ $label }}</option>
                        @endforeach;
                    </select>
                    @if ($errors->has('product_id'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('product_id') }}</strong></span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="quantity" class="col-form-label">Quantity</label>
                    <input type="number" class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" value="{{ old('quantity', $order->quantity) }}">
                    @if ($errors->has('quantity'))
                        <span class="invalid-feedback"><strong>{{ $errors->first('quantity') }}</strong></span>
                    @endif
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
@endsection