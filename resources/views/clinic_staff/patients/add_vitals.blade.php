@extends('layouts.app')
@section('title', 'Add Vitals')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Step 1: Search Patient --}}
    <div class="card mb-3">
        <div class="card-header">Step 1: Search Patient</div>
        <div class="card-body">
            <form method="GET" action="{{ route('clinic_staff.patients.add_vitals') }}">
                <div class="input-group mb-2">
                    <input type="text" name="search" class="form-control" placeholder="Enter School ID" value="{{ request('search') }}">
                    <button class="btn btn-primary">Search</button>
                </div>
            </form>

            @if($patients->count())
                <ul class="list-group mt-2">
                    @foreach($patients as $p)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $p->personalInformation->first_name ?? $p->username }} {{ $p->personalInformation->last_name ?? '' }}
                            <a href="{{ route('clinic_staff.patients.add_vitals', ['patient_id' => $p->id]) }}" class="btn btn-sm btn-success">Select</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if($selectedPatient)
    {{-- Step 2 & 3: Add Vitals --}}
    <div class="card shadow-sm">
        <div class="card-header bg-info text-white">
            Step 2 & 3: Add Vitals for {{ $selectedPatient->personalInformation->first_name ?? $selectedPatient->username }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('clinic_staff.patients.vitals.store') }}">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">

                {{-- Checkup Type --}}
                <div class="mb-3">
                    <label for="checkup_type_id" class="form-label">Checkup Type</label>
                    <select name="checkup_type_id" id="checkup_type_id" class="form-select" required>
                        <option value="">Select Checkup Type</option>
                        @foreach($checkupTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Optional Reason --}}
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason (Optional)</label>
                    <input type="text" name="reason" id="reason" class="form-control" placeholder="Reason for vitals check">
                </div>

                {{-- Weight --}}
                <div class="mb-3">
                    <label for="weight" class="form-label">Weight (kg)</label>
                    <input type="number" step="0.1" name="weight" id="weight" class="form-control" required>
                </div>

                {{-- Height --}}
                <div class="mb-3">
                    <label for="height" class="form-label">Height (cm)</label>
                    <input type="number" step="0.1" name="height" id="height" class="form-control" required>
                </div>

                {{-- Blood Pressure --}}
                <div class="mb-3">
                    <label for="blood_pressure" class="form-label">Blood Pressure</label>
                    <input type="text" name="blood_pressure" id="blood_pressure" class="form-control" required>
                </div>

                {{-- Heart Rate --}}
                <div class="mb-3">
                    <label for="heart_rate" class="form-label">Heart Rate (bpm)</label>
                    <input type="number" name="heart_rate" id="heart_rate" class="form-control" required>
                </div>

                {{-- Respiratory Rate --}}
                <div class="mb-3">
                    <label for="respiratory_rate" class="form-label">Respiratory Rate (breaths/min)</label>
                    <input type="number" name="respiratory_rate" id="respiratory_rate" class="form-control" required>
                </div>

                {{-- Temperature --}}
                <div class="mb-3">
                    <label for="temperature" class="form-label">Temperature (°C)</label>
                    <input type="number" step="0.1" name="temperature" id="temperature" class="form-control" required>
                </div>

                <button class="btn btn-success">Save Vitals & Create Session</button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection
