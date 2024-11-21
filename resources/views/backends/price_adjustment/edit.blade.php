<!-- Modal -->
<div class="modal fade" id="edit_price-{{ $adjustment->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Edit Price Adjustment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('price_adjustments.update', ['price_adjustment' => $adjustment->id]) }}"
                    method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="room_id">Room</label>
                            <select name="room_id" id="room_id" class="form-control select2">
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ $adjustment->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="percentage">Percentage</label>
                            <input type="number" name="percentage" id="percentage" class="form-control"
                                value="{{ $adjustment->percentage }}" step="0.01" min="0">
                        </div>
                        <div class="col-sm-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ $adjustment->description }}</textarea>
                        </div>
                        <div class="col-sm-12">
                            <label for="type">Discount Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="long_term" {{ $adjustment->type == 'long_term' ? 'selected' : '' }}>Long-Term</option>
                                <option value="seasonal" {{ $adjustment->type == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
                                <option value="prepayment" {{ $adjustment->type == 'prepayment' ? 'selected' : '' }}>Prepayment</option>
                            </select>
                        </div>

                        <!-- Long-Term Fields (Initially Hidden) -->
                        <div class="col-sm-6" id="long-term-fields" style="display: {{ $adjustment->type == 'long_term' ? 'block' : 'none' }}">
                            <label for="min_months">Minimum Months (Long-Term)</label>
                            <input type="number" name="min_months" id="min_months" class="form-control" value="{{ $adjustment->min_months }}" min="1">
                        </div>

                        <!-- Seasonal Fields (Initially Hidden) -->
                        <div class="col-sm-6" id="seasonal-fields" style="display: {{ $adjustment->type == 'seasonal' ? 'block' : 'none' }}">
                            <label for="start_date">Start Date (Seasonal)</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $adjustment->start_date }}">
                        </div>
                        <div class="col-sm-6" id="seasonal-end-date" style="display: {{ $adjustment->type == 'seasonal' ? 'block' : 'none' }}">
                            <label for="end_date">End Date (Seasonal)</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $adjustment->end_date }}">
                        </div>

                        <!-- Prepayment Fields (Initially Hidden) -->
                        <div class="col-sm-6" id="prepayment-fields" style="display: {{ $adjustment->type == 'prepayment' ? 'block' : 'none' }}">
                            <label for="min_prepayment_months">Minimum Prepayment Months</label>
                            <input type="number" name="min_prepayment_months" id="min_prepayment_months" class="form-control" value="{{ $adjustment->min_prepayment_months }}" min="1">
                        </div>

                        <div class="col-sm-12 mt-2">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ $adjustment->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $adjustment->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="mt-2">
                            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">Update</button>
                            <a href="" type="button" data-bs-dismiss="modal" class="float-right btn btn-dark btn-sm">
                                @lang('Cancel')
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<script>
    // This script will show/hide fields based on the selected 'type'
    document.addEventListener('DOMContentLoaded', function () {
        var typeSelect = document.getElementById('type');
        var longTermFields = document.getElementById('long-term-fields');
        var seasonalFields = document.getElementById('seasonal-fields');
        var seasonalEndDate = document.getElementById('seasonal-end-date');
        var prepaymentFields = document.getElementById('prepayment-fields');

        // Function to toggle fields based on selected type
        function toggleFields() {
            var selectedType = typeSelect.value;

            // Hide all fields initially
            longTermFields.style.display = 'none';
            seasonalFields.style.display = 'none';
            seasonalEndDate.style.display = 'none';
            prepaymentFields.style.display = 'none';

            // Show relevant fields based on selected type
            if (selectedType === 'long_term') {
                longTermFields.style.display = 'block';
            } else if (selectedType === 'seasonal') {
                seasonalFields.style.display = 'block';
                seasonalEndDate.style.display = 'block';
            } else if (selectedType === 'prepayment') {
                prepaymentFields.style.display = 'block';
            }
        }

        // Run toggleFields on page load
        toggleFields();

        // Add event listener to update fields when type is changed
        typeSelect.addEventListener('change', toggleFields);
    });
</script>
