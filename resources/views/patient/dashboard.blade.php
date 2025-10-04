@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h3>Dashboard</h3>

<div class="row">
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5>Appointments</h5>
                <h2>{{ $appointmentsCount }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center">
            <div class="card-body">
                <h5>Medical Records</h5>
                <h2>{{ $recordsCount }}</h2>
            </div>
        </div>
    </div>
</div>
@endsection
