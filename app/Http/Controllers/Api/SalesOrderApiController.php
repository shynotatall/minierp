<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SalesOrderApiController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'customer_name' => 'required|string|max:255',
                'products'      => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity'   => 'required|integer|min:1',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation Error',
                'errors'  => $e->errors()
            ], 422);
        }

        DB::beginTransaction();
        try {
            $order = SalesOrder::create([
                'customer_name' => $validated['customer_name'],
                'total_amount'  => 0,
            ]);

            $total = 0;

            foreach ($validated['products'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->quantity < $item['quantity']) {
                    DB::rollBack();
                    return response()->json(['message' => 'Insufficient stock for ' . $product->name], 400);
                }

                $subtotal = $product->price * $item['quantity'];
                $total += $subtotal;

                SalesOrderItem::create([
                    'sales_order_id' => $order->id,
                    'product_id'     => $product->id,
                    'quantity'       => $item['quantity'],
                    'price'          => $product->price,
                ]);

                $product->decrement('quantity', $item['quantity']);
            }

            $order->update(['total_amount' => $total]);
            DB::commit();

            return response()->json([
                'message' => 'Sales order created successfully!',
                'order'   => $order->load('items.product')
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $order = SalesOrder::with('items.product')->find($id);

        if (!$order) {
            return response()->json(['message' => 'Sales order not found'], 404);
        }

        return response()->json([
            'order_id'      => $order->id,
            'customer_name' => $order->customer_name,
            'total_amount'  => $order->total_amount,
            'items' => $order->items->map(function ($item) {
                return [
                    'product_name' => $item->product->name,
                    'quantity'     => $item->quantity,
                    'price'        => $item->price,
                    'subtotal'     => $item->price * $item->quantity,
                ];
            }),
        ]);
    }
}
