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
                        <ul class="list-group list-group-flush mt-3">
                            @foreach($appointments as $appt)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $appt->patient->name ?? 'Patient' }}</strong><br>
                                        <small>{{ $appt->appointment_date->format('M d, Y h:i A') }}</small>
                                    </div>
                                    <span class="badge bg-info text-dark">{{ $appt->status ?? 'Pending' }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mt-3">No appointments scheduled for today.</p>
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
                <ul class="list-group list-group-flush mt-3">
                    @foreach($medicalRecords as $record)
                        <li class="list-group-item">
                            <strong>{{ $record->clinicSession->patient->personalInformation->first_name ?? $record->clinicSession->patient->name ?? 'Patient' }}</strong> <br>
                            Diagnosis: {{ $record->diagnosis ?? 'N/A' }} <br>
                            <small>Session Date: {{ optional($record->clinicSession->session_date)->format('M d, Y') ?? 'N/A' }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mt-3">No recent medical records available.</p>
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
                        <ul class="list-group list-group-flush mt-3">
                            @foreach($inventory as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $item->name }}
                                    <span class="badge {{ $item->quantity < 5 ? 'bg-danger' : 'bg-success' }}">
                                        {{ $item->quantity < 5 ? 'Low Stock' : 'Sufficient' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted mt-3">No inventory data available.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
