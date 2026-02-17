@extends('layouts.app')

@section('title', 'Sale #' . $sale->id)

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Sale #{{ $sale->id }}</h1>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('sales.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
        <div style="background: #f8f9fa; padding: 20px; border-radius: 6px;">
            <h3 style="margin-top: 0; color: #667eea;">Product</h3>
            <p>
                <strong>Name:</strong> 
                <a href="{{ route('goods.show', $sale->good) }}" style="color: #667eea;">{{ $sale->good->name }}</a>
            </p>
            <p><strong>Category:</strong> {{ $sale->good->category ?? '—' }}</p>
            <p><strong>Supplier:</strong> 
                @if($sale->good->supplier)
                    <a href="{{ route('suppliers.show', $sale->good->supplier) }}" style="color: #667eea;">{{ $sale->good->supplier->name }}</a>
                @else
                    Not assigned
                @endif
            </p>
        </div>

        <div style="background: #f8f9fa; padding: 20px; border-radius: 6px;">
            <h3 style="margin-top: 0; color: #667eea;">Sale Details</h3>
            <p><strong>Quantity Sold:</strong> {{ $sale->quantity_sold }} units</p>
            <p><strong>Unit Price:</strong> KSH {{ number_format($sale->good->selling_price, 2) }}</p>
            <p><strong>Sale Date:</strong> {{ $sale->sale_date->format('M d, Y g:i A') }}</p>
        </div>
    </div>

    <div style="background: #e8f5e9; padding: 20px; border-radius: 6px; border-left: 4px solid #28a745;">
        <h3 style="margin-top: 0; color: #1b5e20;">Financial Summary</h3>
        <table style="width: 100%; border: none; margin: 0;">
            <tr>
                <td style="border: none; padding: 8px 0;"><strong>Total Sale Amount:</strong></td>
                <td style="border: none; padding: 8px 0; text-align: right; font-weight: 600; color: #28a745; font-size: 18px;">KSH {{ number_format($sale->total_amount, 2) }}</td>
            </tr>
            <tr>
                <td style="border: none; padding: 8px 0;"><strong>Total Cost (COGS):</strong></td>
                <td style="border: none; padding: 8px 0; text-align: right;">KSH {{ number_format($sale->quantity_sold * $sale->good->buying_price, 2) }}</td>
            </tr>
            <tr style="border-top: 2px solid #28a745;">
                <td style="border: none; padding: 8px 0;"><strong>Profit:</strong></td>
                <td style="border: none; padding: 8px 0; text-align: right; font-weight: 600; color: #28a745; font-size: 18px;">KSH {{ number_format($sale->profit, 2) }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #ddd; color: #6c757d; font-size: 12px;">
        <p>
            <strong>Recorded:</strong> {{ $sale->created_at->format('M d, Y g:i A') }}<br>
            <strong>Last Updated:</strong> {{ $sale->updated_at->format('M d, Y g:i A') }}
        </p>
    </div>
@endsection
