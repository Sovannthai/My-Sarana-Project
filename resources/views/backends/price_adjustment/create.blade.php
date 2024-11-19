<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create Price Adjustment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('price_adjustments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="room_id">Room</label>
                            <select name="room_id" id="room_id" class="form-control select2">
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="percentage">Percentage</label>
                            <input type="number" name="percentage" id="percentage" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-sm-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-sm-12">
                            <label for="type">Discount Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="long_term">Long-Term</option>
                                <option value="seasonal">Seasonal</option>
                                <option value="prepayment">Prepayment</option>
                            </select>
                        </div>

                        <!-- Long-Term Fields -->
                        <div class="col-sm-6" id="min_months_field" style="display:none;">
                            <label for="min_months">Minimum Months (Long-Term)</label>
                            <input type="number" name="min_months" id="min_months" class="form-control" min="1">
                        </div>

                        <!-- Seasonal Fields -->
                        <div class="col-sm-6" id="start_date_field" style="display:none;">
                            <label for="start_date">Start Date (Seasonal)</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-sm-6" id="end_date_field" style="display:none;">
                            <label for="end_date">End Date (Seasonal)</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>

                        <!-- Prepayment Fields -->
                        <div class="col-sm-6" id="min_prepayment_months_field" style="display:none;">
                            <label for="min_prepayment_months">Minimum Prepayment Months</label>
                            <input type="number" name="min_prepayment_months" id="min_prepayment_months" class="form-control" min="1">
                        </div>

                        <div class="col-sm-12 mt-2">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">Submit</button>
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

<Script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const minMonthsField = document.getElementById('min_months_field');
    const startDateField = document.getElementById('start_date_field');
    const endDateField = document.getElementById('end_date_field');
    const minPrepaymentMonthsField = document.getElementById('min_prepayment_months_field');

    // Function to hide all the fields
    function hideAllFields() {
        minMonthsField.style.display = 'none';
        startDateField.style.display = 'none';
        endDateField.style.display = 'none';
        minPrepaymentMonthsField.style.display = 'none';
    }

    // Event listener for when the type is changed
    typeSelect.addEventListener('change', function() {
        hideAllFields();

        const selectedType = typeSelect.value;

        if (selectedType === 'long_term') {
            minMonthsField.style.display = 'block';
        } else if (selectedType === 'seasonal') {
            startDateField.style.display = 'block';
            endDateField.style.display = 'block';
        } else if (selectedType === 'prepayment') {
            minPrepaymentMonthsField.style.display = 'block';
        }
    });

    // Trigger the change event on page load to hide/unhide fields based on default selection
    typeSelect.dispatchEvent(new Event('change'));
});

</Script>
