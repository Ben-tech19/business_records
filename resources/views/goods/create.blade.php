@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
    <h1>Create New Product</h1>

    <form action="{{ route('goods.store') }}" method="POST" style="max-width: 600px;">
        @csrf
        
        <div class="form-group">
            <label for="name">Product Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
            @error('name')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" id="category" name="category" value="{{ old('category') }}">
            @error('category')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="buying_price">Buying Price ($) *</label>
                <input type="number" id="buying_price" name="buying_price" step="0.01" min="0" value="{{ old('buying_price') }}" required>
                @error('buying_price')<small style="color: #dc3545;">{{ $message }}</small>@enderror
            </div>

            <div class="form-group">
                <label for="selling_price">Selling Price ($) *</label>
                <input type="number" id="selling_price" name="selling_price" step="0.01" min="0" value="{{ old('selling_price') }}" required>
                @error('selling_price')<small style="color: #dc3545;">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="form-group">
            <label for="stock_quantity">Initial Stock Quantity</label>
            <input type="number" id="stock_quantity" name="stock_quantity" min="0" value="{{ old('stock_quantity', 0) }}">
            @error('stock_quantity')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label for="supplier_id">Supplier</label>
            <select id="supplier_id" name="supplier_id">
                <option value="">— Select a supplier —</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                @endforeach
            </select>
            @error('supplier_id')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">Create Product</button>
            <a href="{{ route('goods.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
