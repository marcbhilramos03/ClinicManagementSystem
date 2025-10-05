@extends('layouts.app')

@section('title', 'My Medical Records')

@section('content')
<div class="container mt-4">
    <h3>My Medical Records</h3>

    @if($records->isEmpty())
        <div class="alert alert-info">No medical records found.</div>
    @else
        @foreach($records as $record)
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-primary text-white">
                    {{ $record->clinicSession->checkupType->name ?? 'General Visit' }} — 
                    {{ \Carbon\Carbon::parse($record->clinicSession->session_date)->format('M d, Y') }}
                </div>
                <div class="card-body">
                    <p><strong>Staff:</strong> 
                        {{ $record->clinicSession->ClinicStaff->personalInformation->first_name ?? $record->clinicSession->staff->username ?? 'N/A' }}
                    </p>
                    <p><strong>Diagnosis:</strong> {{ $record->diagnosis ?? 'N/A' }}</p>
                    <p><strong>Treatment:</strong> {{ $record->treatment ?? 'N/A' }}</p>
                    <p><strong>Notes:</strong> {{ $record->notes ?? 'N/A' }}</p>
                </div>
            </div>
        @endforeach

        <div class="mt-3">
            {{ $records->links() }}
        </div>
    @endif
</div>
@endsection
