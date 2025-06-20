@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sales Orders</h2>

    <a href="{{ route('sales-orders.create') }}" class="btn btn-success mb-3">Create New Order</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Total (₹)</th>
                <th>Date</th>
                <th>PDF</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->total_amount }}</td>
                <td>{{ $order->created_at->format('d M Y') }}</td>
                <td><a href="{{ route('sales-orders.pdf', $order->id) }}" class="btn btn-sm btn-info">PDF</a></td>
                <td>
                    <form action="{{ route('sales-orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Delete this order?');">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
