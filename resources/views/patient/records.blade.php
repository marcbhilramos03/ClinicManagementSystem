@extends('layouts.app')

@section('title', 'My Medical Records')

@section('content')
<h3>Medical Records</h3>

@if($records->isEmpty())
    <div class="alert alert-info">No medical records found.</div>
@else
    <div class="list-group">
        @foreach($records as $record)
            <div class="list-group-item">
                <strong>Date:</strong> {{ $record->clinicSession?->appointment_date ?? 'N/A' }}<br>
                <strong>Staff:</strong> {{ $record->staff?->personalInformation->first_name ?? 'N/A' }}<br>
                <strong>Diagnosis:</strong> {{ $record->diagnosis }}<br>
                <strong>Treatment:</strong> {{ $record->treatment }}<br>
                <strong>Notes:</strong> {{ $record->notes }}
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $records->links() }}
    </div>
@endif
@endsection
