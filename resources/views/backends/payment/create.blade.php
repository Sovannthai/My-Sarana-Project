<!-- Create Payment Modal -->
<div class="modal fade" id="createPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPaymentModalLabel">Create Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="user_contract_id">Tenant</label>
                            <select name="user_contract_id" id="user_contract_id" class="form-control select2">
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->user->name }} -
                                        {{ $contract->room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="amount">Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                                min="0" required disabled>
                        </div>
                        <div class="col-sm-6">
                            <label for="type">Payment Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="" selected>-- Select Type --</option>
                                <option value="rent">Rent</option>
                                <option value="utility">Utility</option>
                                <option value="advance">Advance</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="month_paid">Month Paid</label>
                            <input type="number" name="month_paid" id="month_paid" class="form-control" min="1"
                                max="12">
                        </div>
                        <div class="col-sm-6">
                            <label for="year_paid">Year Paid</label>
                            <input type="number" name="year_paid" id="year_paid" class="form-control" min="1900"
                                max="{{ date('Y') }}">
                        </div>
                        <div class="col-sm-12 mt-2">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="completed">Completed</option>
                                <option value="partial">Partial</option>
                                <option value="pending">Pending</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <button type="submit"
                                class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">Submit</button>
                            <a href="#" type="button" data-bs-dismiss="modal"
                                class="float-right btn btn-dark btn-sm">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#amount').prop('disabled', true);

        $('#type').on('change', function() {
            var paymentType = $(this).val();

            if (paymentType === 'rent') {
                $('#amount').prop('disabled', false);

                var contractId = $('#user_contract_id').val();

                console.log(contractId)

                if (contractId) {
                    $.ajax({
                        url: "{{ route('payments.getRoomPrice', '') }}/" + contractId,
                        method: 'GET',
                        success: function(response) {
                            if (response.price) {
                                $('#amount').val(response.price).prop('disabled', false);
                            } else {
                                alert('Error: Price not found.');
                                $('#amount').val('').prop('disabled', true);
                            }
                        },
                        error: function(xhr) {
                            console.error("AJAX Error:", xhr.responseText);
                            alert('Failed to fetch room price. Please try again.');
                        }
                    });

                }
            } else {
                $('#amount').val('').prop('disabled', true);
            }
        });

        $('#user_contract_id').on('change', function() {
            var contractId = $(this).val();

            console.log("Selected contract ID: " + contractId);

            if ($('#type').val() === 'rent' && contractId) {
                $.ajax({
                    url: "{{ route('payments.getRoomPrice', '') }}/" + contractId,
                    method: 'GET',
                    success: function(response) {
                        console.log("Room Price Response:", response);

                        if (response.price) {
                            $('#amount').val(response.price).prop('disabled', false);
                        } else {
                            $('#amount').val('').prop('disabled', true);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", error);
                    }
                });
            }
        });
    });
</script>
