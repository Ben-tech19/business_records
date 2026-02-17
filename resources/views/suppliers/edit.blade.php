@extends('layouts.app')

@section('title', 'Edit Supplier')

@section('content')
    <h1>Edit Supplier</h1>

    <form action="{{ route('suppliers.update', $supplier) }}" method="POST" style="max-width: 500px;">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="name">Supplier Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name', $supplier->name) }}" required autofocus>
            @error('name')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div class="form-group">
            <label for="contact">Contact (Email/Phone)</label>
            <input type="text" id="contact" name="contact" value="{{ old('contact', $supplier->contact) }}">
            @error('contact')<small style="color: #dc3545;">{{ $message }}</small>@enderror
        </div>

        <div style="display: flex; gap: 10px;">
            <button type="submit" class="btn">Update Supplier</button>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
