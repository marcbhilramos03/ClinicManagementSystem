@extends('layouts.app')

@section('title', 'Admin Profile')

@section('content')
<div class="container">
    <!-- Profile Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <p><strong>Username:</strong> {{ Auth::user()->username }}</p>
            <p><strong>Role:</strong> <span class="badge bg-dark">{{ Auth::user()->role }}</span></p>
            <p><strong>Joined:</strong> {{ Auth::user()->created_at->format('Y-m-d H:i') }}</p>

            @php $info = Auth::user()->personalInformation; @endphp

            <p><strong>First Name:</strong> {{ $info->first_name ?? 'N/A' }}</p>
            <p><strong>Middle Name:</strong> {{ $info->middle_name ?? 'N/A' }}</p>
            <p><strong>Last Name:</strong> {{ $info->last_name ?? 'N/A' }}</p>
            <p><strong>Gender:</strong> {{ $info->gender ?? 'N/A' }}</p>
            <p><strong>Date of Birth:</strong> {{ $info->birthdate ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $info->address ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $info->contact_no ?? 'N/A' }}</p>

            <p><strong>Credential Type:</strong> {{ ucfirst($info->credential_type ?? 'none') }}</p>
            @if($info && $info->credential_type === 'license')
                <p><strong>License Type:</strong> {{ $info->license_type ?? 'N/A' }}</p>
            @elseif($info && $info->credential_type === 'degree')
                <p><strong>Degree:</strong> {{ $info->degree ?? 'N/A' }}</p>
            @endif

            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                Edit Profile
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Personal Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control"
                                value="{{ old('first_name', $info->first_name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="middle_name" class="form-label">Middle Name</label>
                            <input type="text" name="middle_name" id="middle_name" class="form-control"
                                value="{{ old('middle_name', $info->middle_name ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control"
                                value="{{ old('last_name', $info->last_name ?? '') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="male" {{ ($info->gender ?? '')=='male' ? 'selected':'' }}>Male</option>
                                <option value="female" {{ ($info->gender ?? '')=='female' ? 'selected':'' }}>Female</option>
                                <option value="other" {{ ($info->gender ?? '')=='other' ? 'selected':'' }}>Other</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="birthdate" class="form-label">Date of Birth</label>
                            <input type="date" name="birthdate" id="birthdate" class="form-control"
                                value="{{ old('birthdate', $info->birthdate ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" name="address" id="address" class="form-control"
                                value="{{ old('address', $info->address ?? '') }}">
                        </div>

                        <div class="mb-3">
                            <label for="contact_no" class="form-label">Phone</label>
                            <input type="text" name="contact_no" id="contact_no" class="form-control"
                                value="{{ old('contact_no', $info->contact_no ?? '') }}">
                        </div>
                      <!-- Credential Type -->
                        <div class="mb-3">
                            <label for="credential_type" class="form-label">Credential Type</label>
                            <select name="credential_type" id="credential_type" class="form-control">
                                <option value="none" {{ ($info->credential_type ?? '')=='none'?'selected':'' }}>None</option>
                                <option value="license" {{ ($info->credential_type ?? '')=='license'?'selected':'' }}>License</option>
                                <option value="degree" {{ ($info->credential_type ?? '')=='degree'?'selected':'' }}>Degree</option>
                                <option value="both" {{ ($info->credential_type ?? '')=='both'?'selected':'' }}>Both</option>
                            </select>
                        </div>

                        <!-- License Fields -->
                        <div class="mb-3" id="license_fields" style="display: none;">
                            <label for="license_type" class="form-label">License Type</label>
                            <input type="text" name="license_type" id="license_type" class="form-control"
                                value="{{ old('license_type', $info->license_type ?? '') }}">
                        </div>

                        <!-- Degree Fields -->
                        <div class="mb-3" id="degree_fields" style="display: none;">
                            <label for="degree" class="form-label">Degree</label>
                            <input type="text" name="degree" id="degree" class="form-control"
                                value="{{ old('degree', $info->degree ?? '') }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Personal Info</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const credentialSelect = document.getElementById('credential_type');
    const licenseFields = document.getElementById('license_fields');
    const degreeFields = document.getElementById('degree_fields');

    function toggleFields() {
        const value = credentialSelect.value;

        licenseFields.style.display = (value === 'license' || value === 'both') ? 'block' : 'none';
        degreeFields.style.display = (value === 'degree' || value === 'both') ? 'block' : 'none';
    }

    // Initialize on page load
    toggleFields();

    // Update on change
    credentialSelect.addEventListener('change', toggleFields);
});
</script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@endsection
