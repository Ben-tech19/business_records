@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>

    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; border-radius: 6px; text-align: center;">
            <h3 style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Total Suppliers</h3>
            <p style="margin: 0; font-size: 32px; font-weight: bold;">{{ $totalSuppliers }}</p>
        </div>

        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 20px; border-radius: 6px; text-align: center;">
            <h3 style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Total Products</h3>
            <p style="margin: 0; font-size: 32px; font-weight: bold;">{{ $totalGoods }}</p>
        </div>

        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 20px; border-radius: 6px; text-align: center;">
            <h3 style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Total Sales</h3>
            <p style="margin: 0; font-size: 32px; font-weight: bold;">{{ $totalSales }}</p>
        </div>

        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white; padding: 20px; border-radius: 6px; text-align: center;">
            <h3 style="margin: 0 0 10px 0; font-size: 14px; opacity: 0.9;">Total Revenue</h3>
            <p style="margin: 0; font-size: 32px; font-weight: bold;">KSH {{ number_format($totalRevenue, 2) }}</p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div style="background: white; padding: 20px; border-radius: 6px; border: 1px solid #ddd;">
            <h2>Recent Sales</h2>
            @if($recentSales->isEmpty())
                <p class="text-muted">No sales yet.</p>
            @else
                <table style="font-size: 14px;">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Amount</th>
                            <th>Profit</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSales as $sale)
                            <tr>
                                <td><a href="{{ route('goods.show', $sale->good) }}" style="color: #667eea; text-decoration: none;">{{ substr($sale->good->name, 0, 15) }}</a></td>
                                <td>{{ $sale->quantity_sold }}</td>
                                <td>KSH {{ number_format($sale->total_amount, 2) }}</td>
                                <td style="color: #28a745; font-weight: 600;">KSH {{ number_format($sale->profit, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div style="background: white; padding: 20px; border-radius: 6px; border: 1px solid #ddd;">
            <h2>Low Stock Alert</h2>
            @php $lowStockGoods = $allGoods->where('stock_quantity', '<', 50); @endphp
            @if($lowStockGoods->isEmpty())
                <p class="text-muted">All products have sufficient stock.</p>
            @else
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($lowStockGoods->take(5) as $good)
                        <li>
                            <a href="{{ route('goods.show', $good) }}" style="color: #667eea; text-decoration: none;">{{ $good->name }}</a>
                            <span style="background: #ffc107; color: #000; padding: 2px 6px; border-radius: 3px; font-size: 12px; margin-left: 5px;">
                                {{ $good->stock_quantity }} units
                            </span>
                        </li>
                    @endforeach
                </ul>
                @if($lowStockGoods->count() > 5)
                    <p class="text-muted" style="font-size: 12px; margin-top: 10px;">+{{ $lowStockGoods->count() - 5 }} more</p>
                @endif
            @endif
        </div>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="{{ route('suppliers.index') }}" class="btn">Manage Suppliers</a>
        <a href="{{ route('goods.index') }}" class="btn">Manage Products</a>
        <a href="{{ route('sales.index') }}" class="btn">View Sales</a>
        <a href="{{ route('sales.create') }}" class="btn">Record Sale</a>
    </div>
@endsection
