<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container py-5">
    <h2 class="mb-4 text-center">Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                   <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('patient.profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">School ID *</label>
            <input type="text" name="school_id" class="form-control" value="{{ old('school_id', $info?->school_id) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Category *</label>
            <select name="category" class="form-select" required>
                @foreach(['student','faculty','non_teaching_personnel','admin','other'] as $cat)
                    <option value="{{ $cat }}" @selected(old('category', $info?->category) == $cat)>{{ ucfirst(str_replace('_',' ',$cat)) }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Department</label>
            <select name="department_id" class="form-select">
                <option value="">-- Select Department --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" @selected(old('department_id', $info?->department_id) == $dept->id)>{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Program</label>
            <select name="program_id" class="form-select">
                <option value="">-- Select Program --</option>
                @foreach($programs as $prog)
                    <option value="{{ $prog->id }}" @selected(old('program_id', $info?->program_id) == $prog->id)>{{ $prog->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">First Name *</label>
                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $info?->first_name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Middle Name</label>
                <input type="text" name="middle_name" class="form-control" value="{{ old('middle_name', $info?->middle_name) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label">Last Name *</label>
                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $info?->last_name) }}" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Gender *</label>
                <select name="gender" class="form-select" required>
                    <option value="">Select Gender</option>
                    @foreach(['male','female','other'] as $gender)
                        <option value="{{ $gender }}" @selected(old('gender', $info?->gender) == $gender)>{{ ucfirst($gender) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Birthdate *</label>
                <input type="date" name="birthdate" class="form-control" value="{{ old('birthdate', $info?->birthdate) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Address *</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $info?->address) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Phone *</label>
            <input type="text" name="contact_no" class="form-control" value="{{ old('contact_no', $info?->contact_no) }}" required>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Emergency Contact Name *</label>
                <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $info?->emergency_contact_name) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Emergency Contact No *</label>
                <input type="text" name="emergency_contact_no" class="form-control" value="{{ old('emergency_contact_no', $info?->emergency_contact_no) }}" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Relationship *</label>
                <input type="text" name="emergency_contact_relationship" class="form-control" value="{{ old('emergency_contact_relationship', $info?->emergency_contact_relationship) }}" required>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Save Profile</button>
    </form>
</div>
</body>
</html>
