<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Good;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Sale::with('good')->get());
        }
        return view('sales.index', ['sales' => Sale::with('good')->orderByDesc('sale_date')->get()]);
    }

    public function create()
    {
        return view('sales.create', ['goods' => Good::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'good_id' => 'required|exists:goods,id',
            'quantity_sold' => 'required|integer|min:1',
        ]);

        $sale = Sale::create($data);

        if (request()->wantsJson()) {
            return response()->json($sale->load('good'), 201);
        }
        return redirect()->route('sales.show', $sale)->with('success', 'Sale recorded successfully.');
    }

    public function show(Sale $sale)
    {
        if (request()->wantsJson()) {
            return response()->json($sale->load('good'));
        }
        return view('sales.show', ['sale' => $sale]);
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();

        if (request()->wantsJson()) {
            return response()->noContent();
        }
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }
}
