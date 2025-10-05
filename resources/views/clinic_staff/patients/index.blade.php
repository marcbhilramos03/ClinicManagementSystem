@extends('layouts.app')
@section('title', 'Patients List')

@section('content')
<div class="container">
    <h2>Patients</h2>

    <form method="GET" action="{{ route('clinic_staff.patients.index') }}" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by name..." value="{{ request('search') }}">
            <button class="btn btn-outline-primary">Search</button>
        </div>
    </form>

    @if($patients->isEmpty())
        <div class="alert alert-info">No patients found.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                @foreach($patients as $patient)
                    @php
                        $pi = $patient->personalInformation;
                        $fullName = $pi ? ($pi->first_name.' '.$pi->last_name) : $patient->username;
                        $phone = $pi ? $pi->phone : '-';
                        $address = $pi ? $pi->address : '-';
                    @endphp
                    <tr>
                        <td>{{ $fullName }}</td>
                        <td>{{ $patient->username }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $phone }}</td>
                        <td>{{ $address }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
