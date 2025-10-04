@extends('layouts.app')

@section('title', 'My Appointments')

@section('content')
<h3>My Appointments</h3>

@if($appointments->isEmpty())
    <div class="alert alert-info">No appointments scheduled yet.</div>
@else
    <div class="list-group">
        @foreach($appointments as $appointment)
            <div class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    Department / Program: {{ $appointment->department?->name }} {{ $appointment->program?->name }}<br>
                    Scheduled At: {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('M d, Y H:i') }}<br>
                    Status:
                    <span class="badge 
                        @if($appointment->status == 'pending') bg-warning 
                        @elseif($appointment->status == 'approved') bg-info
                        @elseif($appointment->status == 'completed') bg-success 
                        @else bg-danger @endif">
                        {{ ucfirst($appointment->status) }}
                    </span><br>
                    Notes: {{ $appointment->notes }}
                </div>
                <div>
                    Clinic Staff: {{ $appointment->clinicStaff?->personalInformation->first_name ?? 'Unassigned' }}
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
