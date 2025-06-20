<?php

namespace App\Http\Controllers;

use App\Models\SalesOrder;
use App\Models\Product;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SalesOrderController extends Controller
{
    public function index()
    {
        $orders = SalesOrder::with('items.product')->get();
        return view('sales_orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::all();
        return view('sales_orders.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        // Create Sales Order
        $order = SalesOrder::create([
            'customer_name' => $request->customer_name,
            'total_amount' => 0, // will update later
        ]);

        $total = 0;

        // Process each product
        foreach ($request->products as $item) {
            $product = Product::find($item['product_id']);

            if ($product->quantity < $item['quantity']) {
                return back()->withErrors(['Stock insufficient for '.$product->name]);
            }

            $subtotal = $product->price * $item['quantity'];
            $total += $subtotal;

            // Create Sales Order Item
            SalesOrderItem::create([
                'sales_order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            // Reduce product stock
            $product->decrement('quantity', $item['quantity']);
        }

        // Update total amount
        $order->update(['total_amount' => $total]);

        return redirect()->route('sales-orders.index')->with('success', 'Sales order created successfully.');
    }

    public function show(SalesOrder $salesOrder)
    {
        $salesOrder->load('items.product');
        return view('sales_orders.show', compact('salesOrder'));
    }

    public function destroy(SalesOrder $salesOrder)
    {
        $salesOrder->delete();
        return redirect()->route('sales-orders.index')->with('success', 'Sales order deleted.');
    }

    public function exportPdf(SalesOrder $salesOrder)
    {
        $salesOrder->load('items.product');
        $pdf = Pdf::loadView('sales_orders.pdf', compact('salesOrder'));
        return $pdf->download('SalesOrder_'.$salesOrder->id.'.pdf');
    }
}
