<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sales Order #{{ $salesOrder->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; }
    </style>
</head>
<body>
    <h2>Sales Order #{{ $salesOrder->id }}</h2>

    <p><strong>Customer Name:</strong> {{ $salesOrder->customer_name }}</p>
    <p><strong>Date:</strong> {{ $salesOrder->created_at->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Price (₹)</th>
                <th>Subtotal (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salesOrder->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->product->sku }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }}</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3 style="text-align: right;">Total: ₹{{ number_format($salesOrder->total_amount, 2) }}</h3>
</body>
</html>
