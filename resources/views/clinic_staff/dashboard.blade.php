@extends('layouts.app')

@section('title', 'Clinic Staff Dashboard')

@section('content')
<div class="container py-4" style="max-height: 80vh; overflow-y: auto;">

    <h1 class="mb-4">Welcome, {{ auth()->user()->name ?? 'Clinic Staff' }}!</h1>

    <div class="row g-4">

        <!-- Today's Appointments -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Today's Appointments</h5>
                    @if(isset($appointments) && $appointments->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($appointments as $appt)
                                <li class="list-group-item">
                                    {{ $appt->patient->name ?? 'Patient' }} - {{ $appt->appointment_date->format('h:i A') }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No appointments scheduled.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Medical Records -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Recent Medical Records</h5>
                    @if(isset($medicalRecords) && $medicalRecords->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach($medicalRecords as $record)
                                <li class="list-group-item">
                                    {{ $record->patient->name ?? 'Patient' }} - {{ $record->diagnosis }}
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No recent medical records.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Medicine Stock Alerts -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">Medicine Stock Alerts</h5>
                    @if(isset($inventory) && $inventory->count() > 0)
                        @foreach($inventory as $item)
                            <p>
                                {{ $item->name }}: 
                                <span class="{{ $item->quantity < 5 ? 'text-danger' : 'text-success' }}">
                                    {{ $item->quantity < 5 ? 'Low Stock' : 'Sufficient' }}
                                </span>
                            </p>
                        @endforeach
                    @else
                        <p class="text-muted">No inventory data available.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
