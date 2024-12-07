<!-- Create Payment Modal -->
<div class="modal fade" id="createPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="createPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPaymentModalLabel">Create Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('payments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="user_contract_id">Contract</label>
                            <select name="user_contract_id" id="user_contract_id" class="form-control select2">
                                <<<<<<< HEAD <option value="" selected>-- Select Contract --</option>
                                    =======
                                    <option value="" selected>-- Select Tenant --</option>
                                    >>>>>>> pheakdey_branch
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}">{{ $contract->user->name }} -
                                            {{ $contract->room->room_number }}</option>
                                    @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="total_amount">Total Amount</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control"
                                step="0.01" min="0" required readonly style="color: black;">
                        </div>
                        <div class="col-sm-4">
                            <label for="total_amount">Total Discount</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control"
                                step="0.01" min="0" required readonly style="color: black;">
                        </div>
                        <div class="col-sm-4">
                            <label for="total_amount">Discount Type</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control"
                                step="0.01" min="0" required readonly style="color: black;">
                        </div>
                        <div class="col-sm-6">
                            <label for="type">Payment Type</label>
                            <select name="type" id="type" class="form-control select2">
                                <option value="" selected>-- Select Type --</option>
                                <option value="all_paid">Paid for All</option>
                                <option value="rent">Rent</option>
                                <option value="utility">Utility</option>
                                <option value="advance">Advance</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="amount">Paid Amount</label>
                            <input type="number" name="amount" id="amount" class="form-control" step="0.01"
                                min="0" required readonly>
                        </div>
                        <div class="col-sm-6">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="month_paid">Month Paid</label>
                            <select name="month_paid" class="form-select select2">
                                <option value="1">@lang('January')</option>
                                <option value="2">@lang('February')</option>
                                <option value="3">@lang('March')</option>
                                <option value="4">@lang('April')</option>
                                <option value="5">@lang('May')</option>
                                <option value="6">@lang('June')</option>
                                <option value="7">@lang('July')</option>
                                <option value="8">@lang('August')</option>
                                <option value="9">@lang('September')</option>
                                <option value="10">@lang('October')</option>
                                <option value="11">@lang('November')</option>
                                <option value="12">@lang('December')</option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="year_paid">Year Paid</label>
                            <input type="number" class="form-control" id="year" name="year_paid"
                                value="{{ date('Y') }}" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="payment_status">Status</label>
                            <select name="payment_status" id="status" class="form-control">
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

        $('#createPaymentModal').on('show.bs.modal', function() {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0];
            const currentMonth = today.getMonth() + 1;
            const currentYear = today.getFullYear();


            $('#payment_date').val(formattedDate);
            $('select[name="month_paid"]').val(currentMonth);
            $('input[name="year_paid"]').val(currentYear);
        });


        $('#amount').prop('disabled', true);
        $('#type').on('change', function() {
            var paymentType = $(this).val();
            var contractId = $('#user_contract_id').val();

            if (paymentType === 'rent') {
                $('#amount').prop('disabled', false);

                if (contractId) {
                    fetchPrice("{{ route('payments.getRoomPrice', '') }}/" + contractId);
                }
            } else if (paymentType === 'all_paid') {
                $('#amount').prop('disabled', false);

                if (contractId) {
                    fetchPrice("{{ route('payments.getTotalRoomPrice', '') }}/" + contractId);
                }
            } else {
                $('#amount').val('').prop('disabled', true);
            }
        });
        $('#user_contract_id').on('change', function() {
            var contractId = $(this).val();

            if ($('#type').val() === 'rent' && contractId) {
                fetchPrice("{{ route('payments.getRoomPrice', '') }}/" + contractId);
            } else if ($('#type').val() === 'all_paid' && contractId) {
                fetchPrice("{{ route('payments.getTotalRoomPrice', '') }}/" + contractId);
            }
        });

        function fetchPrice(url) {
            $.ajax({
                url: url,
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
                    alert('Failed to fetch price. Please try again.');
                }
            });
        }
    });

    //Get Total Room Price
    $(document).ready(function() {
        $('#user_contract_id').on('change', function() {
            var contractId = $(this).val();

            if (contractId) {
                $.ajax({
                    url: "{{ route('payments.getTotalRoomPrice', '') }}/" + contractId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#total_amount').val(response.price);
                    },
                    error: function(error) {
                        console.error('Error fetching price:', error);
                        alert('Unable to fetch price. Please try again.');
                    }
                });
            } else {
                $('#total_amount').val('');
            }
        });
    });
</script>
