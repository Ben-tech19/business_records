@extends('layouts.app')

@section('title', 'Record Sale')

@section('content')
    <h1>Record New Sale</h1>

    <form action="{{ route('sales.store') }}" method="POST" style="max-width: 500px;">
        @csrf
        
        <div class="form-group">
            <label for="good_id">Product *</label>
            <select id="good_id" name="good_id" required autofocus onchange="updateStockDisplay()">
                <option value="">— Select a product —</option>
                @foreach($goods as $good)
                    <option value="{{ $good->id }}" data-stock="{{ $good->stock_quantity }}" data-price="{{ $good->selling_price }}" {{ old('good_id') == $good->id ? 'selected' : '' }}>
                        {{ $good->name }} (Stock: {{ $good->stock_quantity }}, Price: KSH {{ number_format($good->selling_price, 2) }})
                    </option>
                @endforeach
            </select>
            @error('good_id')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <p style="margin: 0;"><strong>Available Stock:</strong> <span id="stock-display">—</span></p>
        </div>

        <div class="form-group">
            <label for="quantity_sold">Quantity Sold *</label>
            <input type="number" id="quantity_sold" name="quantity_sold" min="1" value="{{ old('quantity_sold') }}" required>
            @error('quantity_sold')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div style="background: #e7f3ff; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
            <p style="margin: 0;"><strong>Selling Price:</strong> <span id="price-display">—</span></p>
            <p style="margin: 10px 0 0 0; font-size: 16px; font-weight: 600;"><strong>Total Sale Amount:</strong> <span id="total-display" style="color: #28a745;">—</span></p>
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">Record Sale</button>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>

    <script>
        function updateStockDisplay() {
            const select = document.getElementById('good_id');
            const option = select.options[select.selectedIndex];
            const stock = option.dataset.stock || 0;
            const price = parseFloat(option.dataset.price) || 0;
            
            document.getElementById('stock-display').textContent = stock + ' units';
            document.getElementById('price-display').textContent = '$' + price.toFixed(2);
            updateTotal();
        }

        function updateTotal() {
            const select = document.getElementById('good_id');
            const quantity = parseInt(document.getElementById('quantity_sold').value) || 0;
            const option = select.options[select.selectedIndex];
            const price = parseFloat(option.dataset.price) || 0;
            const total = quantity * price;
            
            document.getElementById('total-display').textContent = '$' + total.toFixed(2);
        }

        document.getElementById('quantity_sold').addEventListener('input', updateTotal);
        
        // Initialize on page load
        updateStockDisplay();
    </script>
@endsection
