@extends('backends.master')
@section('title', 'Monthly Usages for Room ' . $room->room_number)

@section('contents')
<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">Monthly Usages for Room {{ $room->room_number }}</label>
        <a href="#" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
           data-bs-target="#addUsageModal">
            <i class="fas fa-plus"> Add</i>
        </a>
    </div>

    <!-- Modal for Adding New Monthly Usage -->
    <div class="modal fade" id="addUsageModal" tabindex="-1" aria-labelledby="addUsageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('monthly_usages.store') }}" method="POST" class="modal-content">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUsageModalLabel">Add Monthly Usage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="utility_type_id" class="form-label">Utility Type</label>
                        <select name="utility_types[0][utility_type_id]" class="form-control" required>
                            <option value="">Select Utility Type</option>
                            @foreach($utilityTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="month" class="form-label">Month</label>
                        <input type="number" name="month" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year</label>
                        <input type="number" name="year" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="usage" class="form-label">Usage</label>
                        <input type="number" name="utility_types[0][usage]" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-info" id="addAnotherUtility">Add Another Utility</button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Monthly Usage History Table -->
    <div class="card-body">
        <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
            <thead class="table-secondary">
                <tr>
                    <th>No.</th>
                    <th>Utility Type</th>
                    <th>Month</th>
                    <th>Year</th>
                    <th>Usage</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyUsages as $index => $usage)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $usage->utilityType ? $usage->utilityType->type : 'N/A' }}</td>
                        <td>{{ $usage->month }}</td>
                        <td>{{ $usage->year }}</td>
                        <td>{{ $usage->usage }}</td>
                        <td>
                            <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                               data-bs-target="#editUsageModal-{{ $usage->id }}">
                                <i class="fa fa-edit"> Edit</i>
                            </a>
                            <form action="{{ route('monthly_usages.destroy', $usage->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm delete-btn">
                                    <i class="fa fa-trash"> Delete</i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    <!-- Modal for Editing Monthly Usage -->
                    <div class="modal fade" id="editUsageModal-{{ $usage->id }}" tabindex="-1" aria-labelledby="editUsageModalLabel-{{ $usage->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form action="{{ route('monthly_usages.update', $usage->id) }}" method="POST" class="modal-content">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUsageModalLabel-{{ $usage->id }}">Edit Monthly Usage</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="utility_type_id" class="form-label">Utility Type</label>
                                        <select name="utility_type_id" class="form-control" required>
                                            <option value="">Select Utility Type</option>
                                            @foreach($utilityTypes as $type)
                                                <option value="{{ $type->id }}" {{ $usage->utility_type_id == $type->id ? 'selected' : '' }}>
                                                    {{ $type->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="month" class="form-label">Month</label>
                                        <input type="number" name="month" value="{{ $usage->month }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="year" class="form-label">Year</label>
                                        <input type="number" name="year" value="{{ $usage->year }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="usage" class="form-label">Usage</label>
                                        <input type="number" name="usage" value="{{ $usage->usage }}" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Add another utility input field when the button is clicked
    document.getElementById('addAnotherUtility').addEventListener('click', function() {
        const form = document.querySelector('form');
        const index = form.querySelectorAll('input[name^="utility_types"]').length;
        const newField = `
            <div class="mb-3">
                <label for="utility_type_id" class="form-label">Utility Type</label>
                <select name="utility_types[${index}][utility_type_id]" class="form-control" required>
                    <option value="">Select Utility Type</option>
                    @foreach($utilityTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->type }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="usage" class="form-label">Usage</label>
                <input type="number" name="utility_types[${index}][usage]" class="form-control" required>
            </div>
        `;
        form.querySelector('.modal-body').insertAdjacentHTML('beforeend', newField);
    });
</script>
@endsection
