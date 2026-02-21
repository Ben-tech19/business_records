<?php

namespace App\Http\Controllers;

use App\Models\Good;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class GoodController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Good::with('supplier')->get());
        }
        return view('goods.index', ['goods' => Good::all()]);
    }

    public function create()
    {
        return view('goods.create', ['suppliers' => Supplier::all()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $good = Good::create($data);

        if (request()->wantsJson()) {
            return response()->json($good, 201);
        }
        return redirect()->route('goods.show', $good)->with('success', 'Product created successfully.');
    }

    public function show(Good $good)
    {
        if (request()->wantsJson()) {
            return response()->json($good->load('supplier','sales'));
        }
        return view('goods.show', ['good' => $good]);
    }

    public function edit(Good $good)
    {
        return view('goods.edit', ['good' => $good, 'suppliers' => Supplier::all()]);
    }

    public function update(Request $request, Good $good)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'buying_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock_quantity' => 'integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        $good->update($data);

        if (request()->wantsJson()) {
            return response()->json($good);
        }
        return redirect()->route('goods.show', $good)->with('success', 'Product updated successfully.');
    }

    public function destroy(Good $good)
    {
        try {
            $good->delete();

            if (request()->wantsJson()) {
                return response()->noContent();
            }
            return redirect()->route('goods.index')->with('success', 'Product deleted successfully.');
        } catch (QueryException $e) {
            if (strpos($e->getMessage(), 'FOREIGN KEY') !== false) {
                return redirect()->route('goods.index')->withErrors([
                    'error' => 'Cannot delete this product because it has associated sales. Delete the sales records first.',
                ]);
            }
            throw $e;
        }
    }
}
