@extends('layouts.app')
@section('title', 'Add Medical Record')

@section('content')
<div class="container mt-4">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- ---------------- Step 1: Search Patient ---------------- --}}
    <div class="card mb-3">
        <div class="card-header">Step 1: Search Patient</div>
        <div class="card-body">
            <form method="GET" action="{{ route('clinic_staff.patients.add_medical_record') }}">
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
                            <a href="{{ route('clinic_staff.patients.add_medical_record', ['patient_id' => $p->id]) }}" class="btn btn-sm btn-success">Select</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    @if($selectedPatient)
    {{-- ---------------- Step 2 & 3: Add Medical Record ---------------- --}}
    <div class="card">
        <div class="card-header">
            Step 2 & 3: Add Medical Record for {{ $selectedPatient->personalInformation->first_name ?? $selectedPatient->username }}
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('clinic_staff.patients.medical_record.store') }}">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $selectedPatient->id }}">

                {{-- Checkup Type --}}
                <div class="mb-3">
                    <label for="checkup_type_id" class="form-label">Checkup Type</label>
                    <select name="checkup_type_id" id="checkup_type_id" class="form-control" required>
                        <option value="">Select Checkup Type</option>
                        @foreach($checkupTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Reason --}}
                <div class="mb-3">
                    <label for="reason" class="form-label">Reason for Visit</label>
                    <input type="text" name="reason" id="reason" class="form-control" required>
                </div>

                {{-- Diagnosis --}}
                <div class="mb-3">
                    <label for="diagnosis" class="form-label">Diagnosis</label>
                    <textarea name="diagnosis" id="diagnosis" class="form-control" rows="2" required></textarea>
                </div>

                {{-- Treatment --}}
                <div class="mb-3">
                    <label for="treatment" class="form-label">Treatment</label>
                    <textarea name="treatment" id="treatment" class="form-control" rows="2" required></textarea>
                </div>

                {{-- Notes --}}
                <div class="mb-3">
                    <label for="notes" class="form-label">Notes (Optional)</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                </div>

                <hr>
                <h5>Optional Prescription</h5>

                {{-- Medicine --}}
                <div class="mb-3">
                    <label for="medicine_id" class="form-label">Medicine</label>
                    <select name="medicine_id" id="medicine_id" class="form-control">
                        <option value="">Select Medicine</option>
                        @foreach(\App\Models\Inventories::all() as $med)
                            <option value="{{ $med->id }}">{{ $med->name }} ({{ $med->quantity }} left)</option>
                        @endforeach
                    </select>
                </div>

                {{-- Dosage --}}
                <div class="mb-3">
                    <label for="dosage" class="form-label">Dosage</label>
                    <input type="text" name="dosage" id="dosage" class="form-control">
                </div>

                {{-- Duration --}}
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" name="duration" id="duration" class="form-control">
                </div>
                <div class="mb-3">
    <label for="frequency" class="form-label">Frequency</label>
    <input type="text" name="frequency" id="frequency" class="form-control" placeholder="e.g., 3 times a day" required>
</div>

                {{-- Quantity --}}
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="quantity" class="form-control" min="1">
                </div>

                <button class="btn btn-success">Save Medical Record</button>
            </form>
        </div>
    </div>
    @endif

</div>
@endsection
