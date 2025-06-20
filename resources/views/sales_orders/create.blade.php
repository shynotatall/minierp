@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Sales Order</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form action="{{ route('sales-orders.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="customer_name" class="form-label">Customer Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>

        <h5>Select Products:</h5>
        @foreach ($products as $product)
            <div class="mb-2">
                <input type="checkbox" name="products[{{ $loop->index }}][product_id]" value="{{ $product->id }}">
                {{ $product->name }} (₹{{ $product->price }}, Stock: {{ $product->quantity }})
                <input type="number" name="products[{{ $loop->index }}][quantity]" placeholder="Qty" min="1" class="form-control d-inline-block" style="width:100px;">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary mt-3">Place Order</button>
    </form>
</div>
@endsection
