@extends('layouts.app')

@section('title', 'Appointments')

@section('content')
@php
    $user = auth()->user();
@endphp

<div class="container py-4">
    <h1 class="mb-4">Appointments Dashboard</h1>

    @if(!$user)
        <div class="alert alert-warning">
            You are not logged in.
        </div>
    @else
        <p class="mb-4">Welcome, {{ $user?->username ?? $user?->name ?? 'Clinic Staff' }}!</p>

        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Appointments</h5>

                        @if($appointments->isEmpty())
                            <p>No appointments found.</p>
                        @else
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Patient</th>
                                        <th>Department</th>
                                        <th>Program</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appointment)
                                        <tr>
                                            <td>{{ $appointment->patient?->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->department?->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->program?->name ?? 'N/A' }}</td>
                                            <td>{{ $appointment->appointment_date }}</td>
                                            <td>{{ ucfirst($appointment->status) }}</td>
                                            <td>
                                                <a href="#" class="btn btn-sm btn-primary">View</a>
                                                <a href="#" class="btn btn-sm btn-warning">Edit</a>
                                                <form action="{{ route('clinic_staff.appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this appointment?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
