@extends('layouts.app')

@section('title', $good->name)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>{{ $good->name }}</h1>
        <div style="display: flex; gap: 10px;">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('goods.edit', $good) }}" class="btn">Edit</a>
                <form action="{{ route('goods.destroy', $good) }}" method="POST" onsubmit="return confirm('Delete this good?');" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endif
            <a href="{{ route('goods.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <div style="background: #f8f9fa; padding: 20px; border-radius: 6px;">
            <h3 style="margin-top: 0; color: #667eea;">Pricing & Stock</h3>
            <p><strong>Buying Price:</strong> KSH {{ number_format($good->buying_price, 2) }}</p>
            <p><strong>Selling Price:</strong> KSH {{ number_format($good->selling_price, 2) }}</p>
            <p><strong>Profit per Unit:</strong> KSH {{ number_format($good->selling_price - $good->buying_price, 2) }}</p>
            <p><strong>Margin:</strong> {{ round((($good->selling_price - $good->buying_price) / $good->buying_price) * 100, 1) }}%</p>
            <p><strong>Current Stock:</strong> 
                <span style="background: {{ $good->stock_quantity < 50 ? '#ffc107' : '#28a745' }}; color: white; padding: 4px 8px; border-radius: 4px;">
                    {{ $good->stock_quantity }} units
                </span>
            </p>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 6px;">
            <h3 style="margin-top: 0; color: #667eea;">Details</h3>
            <p><strong>Category:</strong> {{ $good->category ?? 'Not set' }}</p>
            <p><strong>Supplier:</strong> 
                @if($good->supplier)
                    <a href="{{ route('suppliers.show', $good->supplier) }}" style="color: #667eea;">{{ $good->supplier->name }}</a>
                @else
                    Not assigned
                @endif
            </p>
            <p><strong>Created:</strong> {{ $good->created_at->format('M d, Y g:i A') }}</p>
            <p><strong>Last Updated:</strong> {{ $good->updated_at->format('M d, Y g:i A') }}</p>
        </div>
    </div>

    <h2>Sales History ({{ $good->sales->count() }} sales)</h2>
    
    @if($good->sales->isEmpty())
        <p class="text-muted">No sales recorded for this product yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Quantity Sold</th>
                    <th>Total Amount</th>
                    <th>Profit</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($good->sales as $sale)
                    <tr>
                        <td><a href="{{ route('sales.show', $sale) }}" style="color: #667eea;">#{{ $sale->id }}</a></td>
                        <td>{{ $sale->quantity_sold }}</td>
                        <td>KSH {{ number_format($sale->total_amount, 2) }}</td>
                        <td>KSH {{ number_format($sale->profit, 2) }}</td>
                        <td>{{ $sale->sale_date->format('M d, Y g:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
