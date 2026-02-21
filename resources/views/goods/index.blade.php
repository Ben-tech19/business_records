@extends('layouts.app')

@section('title', 'Goods')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Products (Goods)</h1>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('goods.create') }}" class="btn">+ Add Product</a>
        @endif
    </div>

    @if($goods->isEmpty())
        <p class="text-muted">No products found. @if(auth()->user()->role === 'admin') <a href="{{ route('goods.create') }}">Create one</a>@endif</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Buying Price</th>
                    <th>Selling Price</th>
                    <th>Margin</th>
                    <th>Stock</th>
                    <th>Supplier</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($goods as $good)
                    <tr>
                        <td>{{ $good->name }}</td>
                        <td>{{ $good->category ?? '—' }}</td>
                        <td>KSH {{ number_format($good->buying_price, 2) }}</td>
                        <td>KSH {{ number_format($good->selling_price, 2) }}</td>
                        <td>{{ round((($good->selling_price - $good->buying_price) / $good->buying_price) * 100, 1) }}%</td>
                        <td>
                            <span style="background: {{ $good->stock_quantity < 50 ? '#ffc107' : '#28a745' }}; color: white; padding: 4px 8px; border-radius: 4px;">
                                {{ $good->stock_quantity }}
                            </span>
                        </td>
                        <td>{{ $good->supplier->name ?? '—' }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('goods.show', $good) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">View</a>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('goods.edit', $good) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">Edit</a>
                                    <form action="{{ route('goods.destroy', $good) }}" method="POST" onsubmit="return confirm('Delete this good?');" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
