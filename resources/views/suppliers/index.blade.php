@extends('layouts.app')

@section('title', 'Suppliers')

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Suppliers</h1>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('suppliers.create') }}" class="btn">+ Add Supplier</a>
        @endif
    </div>

    @if($suppliers->isEmpty())
        <p class="text-muted">No suppliers found. @if(auth()->user()->role === 'admin') <a href="{{ route('suppliers.create') }}">Create one</a>@endif</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Goods Count</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($suppliers as $supplier)
                    <tr>
                        <td>{{ $supplier->id }}</td>
                        <td>{{ $supplier->name }}</td>
                        <td>{{ $supplier->contact ?? '—' }}</td>
                        <td>{{ $supplier->goods->count() }}</td>
                        <td>{{ $supplier->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="actions">
                                <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">View</a>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px;">Edit</a>
                                    <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" onsubmit="return confirm('Delete this supplier?');" style="display: inline;">
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
