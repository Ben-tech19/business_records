@extends('layouts.app')

@section('title', 'Sales')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Sales</h1>
        <a href="{{ route('sales.create') }}" class="btn">+ Record Sale</a>
    </div>

    @if($sales->isEmpty())
        <p class="text-muted">No sales recorded yet. <a href="{{ route('sales.create') }}">Record one</a></p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Amount</th>
                    <th>Profit</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                    <tr>
                        <td>#{{ $sale->id }}</td>
                        <td><a href="{{ route('goods.show', $sale->good) }}" style="color: #667eea;">{{ $sale->good->name }}</a></td>
                        <td>{{ $sale->quantity_sold }}</td>
                        <td style="font-weight: 600; color: #28a745;">KSH {{ number_format($sale->total_amount, 2) }}</td>
                        <td style="font-weight: 600; color: #667eea;">KSH {{ number_format($sale->profit, 2) }}</td>
                        <td>{{ $sale->sale_date->format('M d, Y g:i A') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">View</a>
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('sales.destroy', $sale) }}" method="POST" onsubmit="return confirm('Delete this sale?');" style="display: inline;">
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
