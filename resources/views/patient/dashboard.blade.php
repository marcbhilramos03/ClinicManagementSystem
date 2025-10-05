@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h3>Dashboard</h3>
    <div class="row g-3">
        <!-- Next Appointment -->
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Next Appointment</h5>
                    @if($nextAppointment)
                        <p class="mb-0">
                            {{ $nextAppointment->appointment_date->format('M d, Y H:i') }}
                        </p>
                            <p class="mb-0">
         {{ $nextAppointment->notes ?? 'No notes' }}
                         </p>
                        <small>
                            Staff: {{ $nextAppointment->clinicStaff?->personalInformation->first_name ?? 'Unassigned' }}
                        </small>
                    @else
                        <p class="mb-0 text-muted">No upcoming appointments</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Medical Records Count -->
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5>Medical Records</h5>
                    <h2>{{ $recordsCount }}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
