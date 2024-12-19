<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Add Utility Payment</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('store-advance-utility-payment') }}" method="POST" id="createUtililtyPaymentForm">
                @csrf
                <div class="row">
                    <input type="hidden" name="payment_id" value="{{ $payment->id }}">
                    <div class="col-sm-4">
                        <label for="contract_id">Room Name/Number</label>
                        <select name="contract_id" id="contract_id" class="form-control">
                            <option value="{{ $contract->id }}">{{ $contract->room->room_number }}</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label for="month_paid">Month Paid</label>
                        <select name="month_paid" id="month_paid" class="form-select">
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
                    <div class="col-sm-4">
                        <label for="year_paid">Year Paid</label>
                        <input type="number" class="form-control" id="year" name="year_paid"
                            value="{{ date('Y') }}" required>
                    </div>
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
                                            <th>Rate</th>
                                            <th>Subtotal</th>
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
                                    class="form-control" step="0.01" min="0" readonly style="color: black;">
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-2">
                    <button type="submit" class="btn btn-primary btn-sm float-right mb-2 ml-1">Submit</button>
                    <button type="button" class="btn btn-dark btn-sm float-right"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#month_paid, #contract_id').on('change', function() {
            let month_paid = $('#month_paid').val();
            let contract_id = $('#contract_id').val();

            if (month_paid && contract_id) {
                $.ajax({
                    url: "{{ route('advance-payment.utility', '') }}/" + contract_id,
                    type: 'GET',
                    data: {
                        month_paid: month_paid
                    },
                    success: function(response) {
                        console.log(response);
                        var utilityHtml = '';
                        if (response.utility_usage.length > 0) {
                            response.utility_usage.forEach(function(utility) {
                                let utilityType = utility.utility_type || 'N/A';
                                let usage = utility.usage ? parseFloat(utility
                                    .usage) : 0;
                                let ratePerUnit = 0;
                                let totalPrice = 0;
                                let utilityRate = response.utilityRates.find(rate =>rate.utility_type_id == utility.utility_type_id);
                                if (utilityRate) {
                                    ratePerUnit = parseFloat(utilityRate.rate_per_unit);
                                    totalPrice = usage * ratePerUnit;
                                }

                                utilityHtml += `
                                    <tr data-id="${utility.utility_type_id || ''}"
                                    data-type="${utilityType}"
                                    data-usage="${usage}"
                                    data-rate="${ratePerUnit}"
                                    data-total="${totalPrice}">
                                        <td>${utilityType}</td>
                                        <td>${usage.toFixed(2)}</td>
                                        <td>$ ${ratePerUnit.toFixed(2)}</td>
                                        <td>$ ${totalPrice.toFixed(2)}</td>
                                    </tr>`;
                            });
                        } else {
                            utilityHtml = `
                            <tr>
                                <td colspan="4" class="text-center">No utilities found.</td>
                            </tr>`;
                        }

                        $('#utility-details tbody').html(utilityHtml);
                        $('#total_utility_amount').val(response.total_cost);
                    },

                    error: function(xhr) {
                        console.error('Error fetching data:', xhr);
                        alert('Failed to load utility data. Please try again.');
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $('#createUtililtyPaymentForm').on('submit', function(e) {
            e.preventDefault();
            $('.dynamic-input').remove();

            var utilityInputs = '';
            $(this).find('#utility-details tbody tr').each(function() {
                var utilityId = $(this).data('id');
                var utilityType = $(this).data('type');
                var usage = $(this).data('usage');
                var rate = $(this).data('rate');
                var total = $(this).data('total');

                if (utilityId && utilityType && usage && rate && total) {
                    utilityInputs += `
                    <input type="hidden" name="utility_ids[]" value="${utilityId}" class="dynamic-input">
                    <input type="hidden" name="utility_types[]" value="${utilityType}" class="dynamic-input">
                    <input type="hidden" name="utility_usages[]" value="${usage}" class="dynamic-input">
                    <input type="hidden" name="utility_rates[]" value="${rate}" class="dynamic-input">
                    <input type="hidden" name="utility_totals[]" value="${total}" class="dynamic-input">
                `;
                }
            });
            $(this).append(utilityInputs);
            this.submit();
        });
    });
</script>
