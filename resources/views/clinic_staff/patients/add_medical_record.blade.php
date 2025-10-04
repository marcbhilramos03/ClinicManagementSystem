@extends('layouts.app')
@section('title', 'Add Medical Record')

@section('content')
<div class="container">
    <h2>Add Medical Record for {{ $patient->personalInformation->first_name ?? $patient->username }}</h2>

    <form method="POST" action="{{ route('clinic_staff.patients.medical_record.store', $patient->id) }}">
        @csrf

        <div class="mb-3">
            <label>Diagnosis</label>
            <input type="text" name="diagnosis" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Treatment</label>
            <input type="text" name="treatment" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="note" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>

        <h5>Prescription (optional)</h5>
        <div class="mb-3">
            <label>Medicine</label>
            <select name="inventory_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($inventories as $item)
                    <option value="{{ $item->id }}">{{ $item->name }} (Stock: {{ $item->quantity }})</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Dosage</label>
            <input type="text" name="dosage" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save</button>
    </form>
</div>
@endsection
