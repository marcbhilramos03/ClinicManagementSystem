@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">My Profile</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">Personal Info</div>
        <div class="card-body">
            <p><strong>School ID:</strong> {{ $info?->school_id }}</p>
            <p><strong>Category:</strong> {{ ucfirst(str_replace('_',' ',$info?->category)) }}</p>
            <p><strong>Name:</strong> {{ $info?->first_name }} {{ $info?->middle_name }} {{ $info?->last_name }}</p>
            <p><strong>Gender:</strong> {{ ucfirst($info?->gender) }}</p>
            <p><strong>Birthdate:</strong> {{ $info?->birthdate }}</p>
            <p><strong>Address:</strong> {{ $info?->address }}</p>
            <p><strong>Phone:</strong> {{ $info?->contact_no }}</p>
            <p><strong>Emergency Contact:</strong> {{ $info?->emergency_contact_name }} ({{ $info?->emergency_contact_relationship }}) - {{ $info?->emergency_contact_no }}</p>
        </div>
        <div class="card-footer text-end">
            <a href="{{ route('patient.profile.edit') }}" class="btn btn-primary">Edit Profile</a>
        </div>
    </div>
</div>
@endsection
