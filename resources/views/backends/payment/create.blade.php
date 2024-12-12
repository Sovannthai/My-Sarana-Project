<!-- Create Payment Modal -->
<style>
    input {
        color: black;
    }
</style>
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
                            <label for="user_contract_id">Contract</label>
                            <select name="user_contract_id" id="user_contract_id" class="form-control select2">
                                <option value="" selected>-- Select Contract --</option>
                                @foreach ($contracts as $contract)
                                    <option value="{{ $contract->id }}">{{ $contract->user->name }} -
                                        {{ $contract->room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="room_price">Room Price</label>
                            <input type="number" name="room_price" id="room_price" class="form-control" step="0.01"
                                min="0" readonly style="color: black;">
                        </div>
                        <hr style="height: 1px;background-color: #000000;margin: 10px 0;width:-webkit-fill-available;">
                        <fieldset>
                            <h6 data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Discount value will be auto completed when you choose on another contract">
                                Discount Details <i class="fa fa-info-circle"></i></h6>
                            <div class="row">
                                <div class="col-sm-6">
                                    <label for="discount_value">Total Discount</label>
                                    <input type="number" name="discount_value" id="discount_value" class="form-control"
                                        step="0.01" min="0" required readonly style="color: black;">
                                </div>
                                <div class="col-sm-6">
                                    <label for="discount_type">Discount Type</label>
                                    <input type="text" name="discount_type" id="discount_type"
                                        class="form-control text-uppercase" required readonly style="color: black;">
                                </div>
                            </div>
                        </fieldset>
                        <hr style="height: 1px;background-color: #000000;margin: 10px 0;width:-webkit-fill-available;">
                        <fieldset>
                            <h6>Amenity Details</h6>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="amenity-details">
                                        <thead>
                                            <tr>
                                                <th>Amenity Name</th>
                                                <th>Additional Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Amenity details -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-4">
                                    <label for="total_amount_amenity">Total Amenity Price</label>
                                    <input type="number" name="total_amount_amenity" id="total_amount_amenity"
                                        class="form-control" step="0.01" min="0" readonly
                                        style="color: black;">
                                </div>
                            </div>
                        </fieldset>
                        <hr style="height: 1px;background-color: #000000;margin: 10px 0;width:-webkit-fill-available;">
                        <fieldset>
                            <h6>Utility Details</h6>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered" id="utility-details">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Usage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Utility details -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-4">
                                    <label for="total_utility_amount">Total Utility Price</label>
                                    <input type="number" name="total_utility_amount" id="total_utility_amount"
                                        class="form-control" step="0.01" min="0" readonly
                                        style="color: black;">
                                </div>
                            </div>
                        </fieldset>
                        <div class="col-sm-12">
                            <label for="total_amount">Total Amount</label>
                            <input type="number" name="total_amount" id="total_amount" class="form-control"
                                step="0.01" min="0" required readonly style="color: black;">
                        </div>
                        <div class="col-sm-6">
                            <label for="type">Payment Type</label>
                            <select name="type" id="type" class="form-control">
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
                                min="0" required readonly style="color: black;">
                        </div>
                        <div class="col-sm-6" id="from-date-field" style="display: none;">
                            <label for="form_date">From Date</label>
                            <input type="date" name="form_date" id="form_date" class="form-control">
                        </div>
                        <div class="col-sm-6" id="to-date-field" style="display: none;">
                            <label for="to_date">To Date</label>
                            <input type="date" name="to_date" id="to_date" class="form-control">
                        </div>
                        <div class="col-sm-6">
                            <label for="payment_date">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" class="form-control"
                                required>
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
        var roomPrice = 0;
        function fetchRoomPrice(contractId) {
            return $.ajax({
                url: "{{ route('payments.getRoomPrice', '') }}/" + contractId,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response.price);
                    if (response.price) {
                        roomPrice = parseFloat(response.price);
                    } else {
                        alert('Room price not found.');
                        roomPrice = 0;
                    }
                },
                error: function(error) {
                    console.error("Error fetching room price:", error);
                    alert("Failed to retrieve room price.");
                    roomPrice = 0;
                }
            });
        }
        $('#type').on('change', function() {
            if ($(this).val() === 'advance') {
                $('#from-date-field, #to-date-field').slideDown();
            } else {
                $('#from-date-field, #to-date-field').slideUp();
                $('#form_date, #to_date').val('');
                $('#amount').val('');
            }
        });

        $('#user_contract_id').on('change', function() {
            var contractId = $(this).val();
            if (contractId) {
                fetchRoomPrice(contractId);
            }
        });
        $('#form_date, #to_date').on('change', function() {
            var fromDate = $('#form_date').val();
            var toDate = $('#to_date').val();

            if (fromDate && toDate) {
                var start = new Date(fromDate);
                var end = new Date(toDate);

                if (start <= end) {
                    var totalMonths = getMonthDifference(start, end);
                    var totalPrice = totalMonths * roomPrice;
                    $('#amount').val(totalPrice.toFixed(2));
                } else {
                    alert('From Date cannot be after To Date.');
                    $('#amount').val('');
                }
            } else {
                $('#amount').val('');
            }
        });
        function getMonthDifference(start, end) {
            var yearDiff = end.getFullYear() - start.getFullYear();
            var monthDiff = end.getMonth() - start.getMonth();
            var dayDiff = end.getDate() - start.getDate();

            var totalMonths = yearDiff * 12 + monthDiff;
            if (dayDiff > 0) {
                totalMonths += 1;
            }

            return totalMonths;
        }
    });

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
                    fetchPrice("{{ route('payments.getRoomPrice', '') }}/" + contractId, paymentType);
                }
            } else if (paymentType === 'all_paid' || paymentType === 'utility') {
                $('#amount').prop('disabled', false);
                if (contractId) {
                    fetchPrice("{{ route('payments.getTotalRoomPrice', '') }}/" + contractId,
                        paymentType);
                }
            } else {
                $('#amount').val('').prop('disabled', true);
            }
        });

        $('#user_contract_id').on('change', function() {
            var contractId = $(this).val();
            var paymentType = $('#type').val();

            if (contractId) {
                if (paymentType === 'rent') {
                    fetchPrice("{{ route('payments.getRoomPrice', '') }}/" + contractId, paymentType);
                } else if (paymentType === 'utility' || paymentType === 'all_paid') {
                    fetchPrice("{{ route('payments.getTotalRoomPrice', '') }}/" + contractId,
                        paymentType);
                }
            }
        });

        function fetchPrice(url, paymentType) {
            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    if (paymentType === 'utility') {
                        if (response.totalCost) {
                            $('#amount').val(response.totalCost).prop('disabled', false);
                        } else {
                            alert('Error: Total cost not found.');
                            $('#amount').val('').prop('disabled', true);
                        }
                    } else {
                        if (response.price) {
                            $('#amount').val(response.price).prop('disabled', false);
                        } else {
                            alert('Error: Price not found.');
                            $('#amount').val('').prop('disabled', true);
                        }
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
                        // console.log("Response received:", response);
                        if (response.price && response.discount) {
                            $('#total_amount').val(response.price);
                            $('#discount_value').val(response.discount.discount_value);
                            $('#discount_type').val(response.discount.discount_type);
                            $('#total_amount_amenity').val(response.amenity_prices);
                            $('#total_utility_amount').val(response.totalCost);
                            $('#room_price').val(response.room_price);
                        } else {
                            alert('Discount data is incomplete.');
                            $('#total_amount').val('');
                            $('#discount_value').val('');
                            $('#discount_type').val('');
                            $('#total_amount_amenity').val();
                            $('#total_utility_amount').val();
                            $('#room_price').val('');
                        }
                        //Amenity
                        var amenityHtml = '';
                        if (response.amenities.length > 0) {
                            response.amenities.forEach(function(amenity) {
                                amenityHtml += `
                                <tr>
                                    <td>${amenity.name}</td>
                                    <td>${amenity.additional_price}</td>
                                </tr>`;
                            });
                        } else {
                            amenityHtml =
                                '<tr><td colspan="2">No amenities found.</td></tr>';
                        }
                        $('#amenity-details tbody').html(amenityHtml);
                        //utility
                        var utilityHtml = '';
                        if (response.utilityUsage.length > 0) {
                            response.utilityUsage.forEach(function(utility) {
                                utilityHtml += `
                                <tr>
                                    <td>${utility.utility_type}</td>
                                    <td>${utility.usage}</td>
                                </tr>`;
                            });
                        } else {
                            utilityHtml =
                                '<tr><td colspan="2">No utilities found.</td></tr>';
                        }

                        $('#utility-details tbody').html(utilityHtml);
                        $('#total_utility_amount').val(response.totalCost);
                    },
                    error: function(error) {
                        console.error('Error fetching price:', error);
                        alert('Unable to fetch price. Please try again.');
                    }
                });
            } else {
                $('#total_amount').val('');
                $('#discount_value').val('');
                $('#discount_type').val('');
            }
        });
    });
</script>
