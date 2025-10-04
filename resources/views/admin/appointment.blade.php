@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Appointments Management</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card p-3">

        <!-- Create Appointment Button -->
        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                + New Appointment
            </button>
        </div>

        <!-- Appointments Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Department / Program</th>
                        <th>Clinic Staff</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->department?->name ?? '' }} {{ $appointment->program?->name ?? '' }}</td>
                            <td>{{ $appointment->clinicStaff?->personalInformation->first_name ?? 'Unassigned' }}</td>
                            <td>{{ $appointment->appointment_date->format('Y-m-d H:i') }}</td>
                            <td><span class="badge bg-info text-dark">{{ ucfirst($appointment->status) }}</span></td>
                            <td>{{ $appointment->notes }}</td>
                            <td>
                                <!-- Edit button -->
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal{{ $appointment->id }}">Edit</button>
                                
                                <!-- Delete form -->
                                <form action="{{ route('admin.appointments.destroy', $appointment) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this appointment?')">Delete</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal{{ $appointment->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('admin.appointments.updateStatus', $appointment) }}">
                                    @csrf @method('PATCH')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Appointment</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-2">
                                                <label>Clinic Staff</label>
                                                <select name="clinic_staff_id" class="form-control">
                                                    <option value="">-- Unassigned --</option>
                                                    @foreach($clinicStaff as $staff)
                                                        <option value="{{ $staff->id }}" @selected($appointment->clinic_staff_id == $staff->id)>
                                                            {{ $staff->personalInformation->first_name ?? $staff->username }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label>Date</label>
                                                <input type="datetime-local" name="appointment_date" class="form-control"
                                                       value="{{ $appointment->appointment_date->format('Y-m-d\TH:i') }}">
                                            </div>
                                            <div class="mb-2">
                                                <label>Status</label>
                                                <select name="status" class="form-control">
                                                    @foreach(['pending','approved','completed','cancelled'] as $status)
                                                        <option value="{{ $status }}" @selected($appointment->status == $status)>{{ ucfirst($status) }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-2">
                                                <label>Notes</label>
                                                <textarea name="notes" class="form-control">{{ $appointment->notes }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-success">Save</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create Appointment Modal -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('admin.appointments.store') }}">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Appointment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Department -->
                        <div class="mb-2">
                            <label>Department</label>
                            <select name="department_id" class="form-control" required>
                                <option value="">-- Select Department --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Program -->
                        <div class="mb-2">
                            <label>Program</label>
                            <select name="program_id" class="form-control">
                                <option value="">-- None --</option>
                                @foreach($programs as $prog)
                                    <option value="{{ $prog->id }}">{{ $prog->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Clinic Staff -->
                        <div class="mb-2">
                            <label>Clinic Staff</label>
                            <select name="clinic_staff_id" class="form-control">
                                <option value="">-- Unassigned --</option>
                                @foreach($clinicStaff as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->personalInformation->first_name ?? $staff->username }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date -->
                        <div class="mb-2">
                            <label>Date</label>
                            <input type="datetime-local" name="appointment_date" class="form-control" required>
                        </div>

                        <!-- Notes -->
                        <div class="mb-2">
                            <label>Notes</label>
                            <textarea name="notes" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div> <!-- End Container -->
@endsection
