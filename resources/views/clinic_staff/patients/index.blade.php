@extends('layouts.app')
@section('title', 'Patients')

@section('content')
<div class="container">
    <h2>Patients</h2>

    <form method="GET" action="{{ route('clinic_staff.patients.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search patients..." value="{{ request('search') }}">
            <button class="btn btn-outline-secondary">Search</button>
        </div>
    </form>

    @if($patients->isEmpty())
        <div class="alert alert-info">No patients found.</div>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    @php
                        $pi = $patient->personalInformation;
                        $fullName = $pi ? ($pi->first_name.' '.$pi->last_name) : $patient->username;
                    @endphp
                    <tr>
                        <td>{{ $fullName }}</td>
                        <td>{{ $patient->username }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>
                            <a href="{{ route('clinic_staff.patients.medical_record.create', $patient->id) }}" class="btn btn-sm btn-primary">Add Record</a>
                            <a href="{{ route('clinic_staff.patients.vitals.create', $patient->id) }}" class="btn btn-sm btn-warning">Add Vitals</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
