@extends('layouts.app')
@section('title', 'Add Vitals')

@section('content')
<div class="container">
    <h2>Add Vitals for {{ $patient->personalInformation->first_name ?? $patient->username }}</h2>

    <form method="POST" action="{{ route('clinic_staff.patients.vitals.store', $patient->id) }}">
        @csrf

        <div class="row mb-3">
            <div class="col">
                <label>Blood Pressure</label>
                <input type="text" name="blood_pressure" class="form-control">
            </div>
            <div class="col">
                <label>Heart Rate</label>
                <input type="number" name="heart_rate" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Respiratory Rate</label>
                <input type="number" name="respiratory_rate" class="form-control">
            </div>
            <div class="col">
                <label>Temperature</label>
                <input type="number" step="0.1" name="temperature" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label>Weight (kg)</label>
                <input type="number" step="0.1" name="weight" class="form-control">
            </div>
            <div class="col">
                <label>Height (cm)</label>
                <input type="number" step="0.1" name="height" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>BMI</label>
            <input type="number" step="0.1" name="bmi" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Save Vitals</button>
    </form>
</div>
@endsection
