<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_revenue' => Order::whereIn('status', ['paid', 'delivered'])->sum('total'),
            'orders_count' => Order::count(),
            'low_stock_products' => Product::where('stock', '<=', 5)->count(),
        ];

        return view('admin.dashboard', compact('metrics'));
    }
}
