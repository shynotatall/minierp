<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SalesOrder;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = SalesOrder::sum('total_amount');
        $totalOrders = SalesOrder::count();
        $lowStockProducts = Product::where('quantity', '<', 5)->get(); // Products below threshold 5

        return view('dashboard', compact('totalSales', 'totalOrders', 'lowStockProducts'));
    }
}
