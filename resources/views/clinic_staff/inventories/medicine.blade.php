@extends('layouts.app')

@section('title', 'Medicines Inventory')

@section('content')
<div class="container">
    <h2 class="mb-4">Medicines Inventory</h2>

    <a href="{{ route('clinic_staff.inventories.medicine') }}" class="btn btn-sm btn-secondary mb-3">
        View Equipment
    </a>

    @if($medicines->isEmpty())
        <div class="alert alert-info">No medicines available.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Expiration Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($medicines as $medicine)
                    <tr>
                        <td>{{ $medicine->name }}</td>
                        <td>{{ $medicine->quantity }}</td>
                        <td>{{ $medicine->expiration_date ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
