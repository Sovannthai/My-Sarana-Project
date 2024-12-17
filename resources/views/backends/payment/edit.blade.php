<!-- Create Payment Modal -->
@foreach ($payments as $payment)
    <style>
        input {
            color: black;
        }
    </style>
    <div class="modal fade" id="editpaymentmodal-{{ $payment->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="editpaymentmodalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editpaymentmodalLabel">Create Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.store') }}" method="POST" id="createPaymentForm">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="user_contract_id">Contract</label>
                                <select name="user_contract_id" id="user_contract_id" class="form-control select2">
                                    <option value="" selected>-- Select Contract --</option>
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}"
                                            {{ $contract->id == $payment->user_contract_id ? 'selected' : '' }}>
                                            {{ $contract->user->name }} -
                                            {{ $contract->room->room_number }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="room_price">Room Price</label>
                                <input type="number" name="room_price" id="room_price" class="form-control"
                                    step="0.01" min="0" readonly style="color: black;"
                                    value="{{ $payment->room_price }}">
                            </div>
                            <hr
                                style="height: 1px;background-color: #000000;margin: 10px 0;width:-webkit-fill-available;">
                            <fieldset>
                                <h6 data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Discount value will be auto completed when you choose on another contract">
                                    Discount Details <i class="fa fa-info-circle"></i></h6>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="discount_value">Total Discount</label>
                                        <input type="number" name="discount_value" id="discount_value"
                                            class="form-control" step="0.01" min="0" required readonly
                                            style="color: black;" value="{{ $payment->total_discount }}">
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="discount_type">Discount Type</label>
                                        <input type="text" name="discount_type" id="discount_type"
                                            class="form-control text-uppercase" required readonly style="color: black;"
                                            value="{{ $payment->discount_type }}">
                                    </div>
                                </div>
                            </fieldset>
                            <hr
                                style="height: 1px;background-color: #000000;margin: 10px 0;width:-webkit-fill-available;">
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
                                                @foreach ($payment->paymentamenities as $amenity)
                                                    <tr>
                                                        <td>{{ @$amenity->amenity->name }}</td>
                                                        <td>{{ $amenity->amenity_price }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="total_amount_amenity">Total Amenity Price</label>
                                        <input type="number" name="total_amount_amenity" id="total_amount_amenity"
                                            class="form-control" step="0.01" min="0" readonly
                                            style="color: black;" value="{{ $payment->total_amount_amenity }}">
                                    </div>
                                </div>
                            </fieldset>
                            <hr
                                style="height: 1px;background-color: #000000;margin: 10px 0;width:-webkit-fill-available;">
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
                                                @foreach ($payment->paymentutilities as $utility)
                                                    <tr>
                                                        <td>{{ @$utility->utility->type }}</td>
                                                        <td>{{ $utility->usage }}</td>
                                                        <td>{{ $utility->rate_per_unit }}</td>
                                                        <td>{{ $utility->total_amount }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="total_utility_amount">Total Utility Price</label>
                                        <input type="number" name="total_utility_amount" id="total_utility_amount"
                                            class="form-control" step="0.01" min="0" readonly
                                            style="color: black;" value="{{ $payment->total_utility_amount }}">
                                    </div>
                                </div>
                            </fieldset>
                            <div class="col-sm-12">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control"
                                    step="0.01" min="0" required readonly style="color: black;"
                                    value="{{ $payment->total_amount }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="type">Payment Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="" selected>-- Select Type --</option>
                                    <option value="all_paid" {{ $payment->type == 'all_paid' ? 'selected' : '' }}>Paid for
                                        All</option>
                                    <option value="rent" {{ $payment->type == 'rent' ? 'selected' : '' }}>Rent</option>
                                    <option value="utility" {{ $payment->type == 'utility' ? 'selected' : '' }}>Utility
                                    </option>
                                    <option value="advance" {{ $payment->type == 'advance' ? 'selected' : '' }}>Advance
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="amount">Paid Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control"
                                    step="0.01" min="0" required readonly style="color: black;"
                                    value="{{ $payment->amount }}">
                            </div>
                            <div class="col-sm-6" id="from-date-field" style="display: none;">
                                <label for="form_date">From Date</label>
                                <input type="date" name="form_date" id="form_date" class="form-control"
                                    value="{{ $payment->start_date }}">
                            </div>
                            <div class="col-sm-6" id="to-date-field" style="display: none;">
                                <label for="to_date">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control"
                                    value="{{ $payment->end_date }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="payment_date">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control"
                                    required value="{{ $payment->payment_date }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="month_paid">Month Paid</label>
                                <select name="month_paid" id="month_paid-{{ $payment->id }}" class="form-select">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}"
                                            {{ $payment->month_paid == $i ? 'selected' : '' }}>
                                            {{ \Illuminate\Support\Carbon::create()->month($i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="year_paid">Year Paid</label>
                                <input type="number" class="form-control" id="year" name="year_paid"
                                    value="{{ date('Y') }}" required>
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
@endforeach
