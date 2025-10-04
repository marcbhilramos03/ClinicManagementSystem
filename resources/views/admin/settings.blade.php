@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Admin Settings</h2>
    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Admin Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
        </div>
        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>
        <!-- Notifications -->
        <div class="mb-3">
            <label class="form-label">Notifications</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="notify_users" id="notify_users" {{ old('notify_users', true) ? 'checked' : '' }}>
                <label class="form-check-label" for="notify_users">
                    Receive notifications about user activity
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
@endsection