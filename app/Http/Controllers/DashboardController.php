<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\Good;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSuppliers = Supplier::count();
        $totalGoods = Good::count();
        $totalSales = Sale::count();
        $totalRevenue = Sale::sum('total_amount') ?? 0;
        $recentSales = Sale::with('good')->orderByDesc('sale_date')->take(5)->get();
        $allGoods = Good::all();

        return view('home', [
            'totalSuppliers' => $totalSuppliers,
            'totalGoods' => $totalGoods,
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'recentSales' => $recentSales,
            'allGoods' => $allGoods,
        ]);
    }
}
