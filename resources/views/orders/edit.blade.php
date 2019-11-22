@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card mb-2">
                <div class="card-header">Edit order #{{ $order->id }}</div>
                <div class="card-body">
                    <form action="/orders/{{$order->id}}" method="post">
                        @csrf
                        @method('patch')

                        @include('orders._form', [
                        'order' => $order,
                        'button' => 'Edit',
                        ])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection