<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        if (request()->wantsJson()) {
            return response()->json(Supplier::all());
        }
        return view('suppliers.index', ['suppliers' => Supplier::all()]);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        $supplier = Supplier::create($data);

        if (request()->wantsJson()) {
            return response()->json($supplier, 201);
        }
        return redirect()->route('suppliers.show', $supplier)->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        if (request()->wantsJson()) {
            return response()->json($supplier);
        }
        return view('suppliers.show', ['supplier' => $supplier]);
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:255',
        ]);

        $supplier->update($data);

        if (request()->wantsJson()) {
            return response()->json($supplier);
        }
        return redirect()->route('suppliers.show', $supplier)->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        if (request()->wantsJson()) {
            return response()->noContent();
        }
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
