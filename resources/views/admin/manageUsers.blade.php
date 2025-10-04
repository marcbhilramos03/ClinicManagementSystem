@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="container-fluid">

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Users Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold">Existing Users</h6>
            <button type="button" class="btn btn-info shadow-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                <i class="fas fa-plus"></i> Add New User
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->username }}</td>
                            <td>
                                @if($user->role=='patient') 
                                    <span class="badge bg-primary fs-6">Patient</span>                            
                                @elseif($user->role=='clinic_staff')
                                    <span class="badge bg-info fs-6">Clinic Staff</span>
                                @elseif($user->role=='admin')
                                    <span class="badge bg-dark fs-6">Admin</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <button type="button"
                                    class="btn btn-info btn-sm view-details-btn"
                                    data-id="{{ $user->id }}"
                                    data-username="{{ $user->username }}"
                                    data-firstname="{{ $user->personalInformation->first_name ?? '' }}"
                                    data-lastname="{{ $user->personalInformation->last_name ?? '' }}"
                                    data-role="{{ $user->role }}"
                                    data-address="{{ $user->personalInformation->address ?? '' }}"
                                    data-contact_no="{{ $user->personalInformation->contact_no ?? '' }}"
                                    data-created="{{ $user->created_at->format('Y-m-d H:i') }}"
                                >View Details</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
     </div>
</div>

<!-- User Details Modal -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="userDetailsModalLabel"><i class="fas fa-user"></i> User Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>ID:</strong> <span id="detail-id"></span></p>
                <p><strong>Username:</strong> <span id="detail-username"></span></p>
                <p><strong>First Name:</strong> <span id="detail-firstname"></span></p>
                <p><strong>Last Name:</strong> <span id="detail-lastname"></span></p>
                <p><strong>Role:</strong> <span id="detail-role" class="badge"></span></p>
                <p><strong>Address:</strong> <span id="detail-address"></span></p>
                <p><strong>Contact Number:</strong> <span id="detail-contact_no"></span></p>
                <p><strong>Created At:</strong> <span id="detail-created"></span></p>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content shadow">
            <form action="{{ route('admin.users.create') }}" method="POST">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="createUserModalLabel"><i class="fas fa-user-plus"></i> Create New User</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Select Role --</option>
                            <option value="patient" {{ old('role')=='patient'?'selected':'' }}>Patient</option>
                            <option value="clinic_staff" {{ old('role')=='clinic_staff'?'selected':'' }}>Clinic Staff</option>
                            <option value="admin" {{ old('role')=='admin'?'selected':'' }}>Admin</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary shadow-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary shadow-sm">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.view-details-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const safeData = value => value ? value : 'N/A';

            document.getElementById('detail-id').textContent = safeData(btn.dataset.id);
            document.getElementById('detail-username').textContent = safeData(btn.dataset.username);
            document.getElementById('detail-firstname').textContent = safeData(btn.dataset.firstname);
            document.getElementById('detail-lastname').textContent = safeData(btn.dataset.lastname);

            // Role badge
            const roleSpan = document.getElementById('detail-role');
            roleSpan.textContent = safeData(btn.dataset.role);
            roleSpan.className = 'badge'; // reset class
            if(btn.dataset.role === 'patient') roleSpan.classList.add('bg-primary');
            else if(btn.dataset.role === 'clinic_staff') roleSpan.classList.add('bg-info');
            else if(btn.dataset.role === 'admin') roleSpan.classList.add('bg-dark');

            document.getElementById('detail-address').textContent = safeData(btn.dataset.address);
            document.getElementById('detail-contact_no').textContent = safeData(btn.dataset.contact_no);
            document.getElementById('detail-created').textContent = safeData(btn.dataset.created);

            new bootstrap.Modal(document.getElementById('userDetailsModal')).show();
        });
    });
});
</script>

<!-- Bootstrap JS (only once in layout) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endpush
