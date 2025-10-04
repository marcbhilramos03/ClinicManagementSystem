@extends('layouts.app')

@section('title', 'Archived / Expired Inventory')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Expired / Archived Inventory</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Expired Medicines --}}
    <h4 class="mt-4">Expired Medicines</h4>
    @if($expiredMedicines->isEmpty())
        <p>No expired medicines.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Condition</th>
                    <th>Expiration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiredMedicines as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->condition }}</td>
                        <td>{{ $item->expiration_date?->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Expired Equipment --}}
    <h4 class="mt-5">Expired Equipment</h4>
    @if($expiredEquipment->isEmpty())
        <p>No expired equipment.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Condition</th>
                    <th>Expiration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expiredEquipment as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->condition }}</td>
                        <td>{{ $item->expiration_date?->format('Y-m-d') }}</td>
                        <td>
                            <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
