@extends('layouts.app')

@section('title', $supplier->name)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>{{ $supplier->name }}</h1>
        <div style="display: flex; gap: 10px;">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn">Edit</a>
                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Delete this supplier?');" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            @endif
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div style="background: #f8f9fa; padding: 20px; border-radius: 6px; margin-bottom: 30px;">
        <p><strong>Contact:</strong> {{ $supplier->contact ?? 'Not provided' }}</p>
        <p><strong>Created:</strong> {{ $supplier->created_at->format('M d, Y g:i A') }}</p>
        <p><strong>Last Updated:</strong> {{ $supplier->updated_at->format('M d, Y g:i A') }}</p>
    </div>

    <h2>Associated Goods ({{ $supplier->goods->count() }})</h2>
    
    @if($supplier->goods->isEmpty())
        <p class="text-muted">No goods from this supplier yet.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Category</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplier->goods as $good)
                    <tr>
                        <td><a href="{{ route('goods.show', $good) }}" style="color: #667eea;">{{ $good->name }}</a></td>
                        <td>{{ $good->category ?? '—' }}</td>
                        <td>KSH {{ number_format($good->buying_price, 2) }}</td>
                        <td>KSH {{ number_format($good->selling_price, 2) }}</td>
                        <td>{{ $good->stock_quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
