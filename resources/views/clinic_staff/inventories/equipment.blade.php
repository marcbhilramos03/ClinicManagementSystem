@extends('layouts.app')

@section('title', 'Equipment Inventory')

@section('content')
<div class="container">
    <h2 class="mb-4">Equipment Inventory</h2>

    <a href="{{ route('clinic_staff.inventories.equipment') }}" class="btn btn-sm btn-secondary mb-3">
        View Medicines
    </a>

    @if($equipments->isEmpty())
        <div class="alert alert-info">No equipment available.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Condition</th>
                </tr>
            </thead>
            <tbody>
                @foreach($equipments as $equipment)
                    <tr>
                        <td>{{ $equipment->name }}</td>
                        <td>{{ $equipment->quantity }}</td>
                        <td>{{ $equipment->condition ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
