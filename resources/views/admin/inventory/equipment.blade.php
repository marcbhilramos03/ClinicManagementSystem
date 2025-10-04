@extends('layouts.app')

@section('title', 'Equipment Inventory')

@section('content')
<div class="container py-4">
    <h3>Equipment Inventory</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Add Equipment Button (Modal Trigger) -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
        Add Equipment
    </button>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Quantity</th>
                <th>Condition</th>
                <th>Expiration Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>{{ $item->type }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->condition }}</td>
                <td>{{ $item->expiration_date ?? '-' }}</td>
                <td>
                    <a href="{{ route('admin.inventory.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.inventory.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this equipment?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No equipment found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Add Equipment Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-labelledby="addEquipmentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="{{ route('admin.inventory.store') }}" method="POST">
        @csrf
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addEquipmentModalLabel">Add Equipment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="equipmentName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="equipmentName" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="equipmentType" class="form-label">Type</label>
                    <input type="text" class="form-control" id="equipmentType" name="type" required>
                </div>
                <div class="mb-3">
                    <label for="equipmentQuantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="equipmentQuantity" name="quantity" required>
                </div>
                <div class="mb-3">
                    <label for="equipmentCondition" class="form-label">Condition</label>
                    <input type="text" class="form-control" id="equipmentCondition" name="condition">
                </div>
                <div class="mb-3">
                    <label for="equipmentExpiration" class="form-label">Expiration Date</label>
                    <input type="date" class="form-control" id="equipmentExpiration" name="expiration_date">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Save Equipment</button>
            </div>
        </div>
    </form>
  </div>
</div>
@endsection
