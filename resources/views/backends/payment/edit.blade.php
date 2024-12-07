<!-- Edit Payment Modal -->
@foreach ($payments as $payment)
    <div class="modal fade" id="editPaymentModal-{{ $payment->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="editPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentModalLabel">Edit Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.update', ['payment' => $payment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="user_contract_id">Tenant</label>
                                <select name="user_contract_id" id="user_contract_id" class="form-control select2">
                                    @foreach ($contracts as $contract)
                                        <option value="{{ $contract->id }}"
                                            {{ $payment->user_contract_id == $contract->id ? 'selected' : '' }}>
                                            {{ $contract->user->name }} - {{ $contract->room->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="total_amount">Total Amount</label>
                                <input type="number" name="total_amount" id="total_amount" class="form-control"
                                    step="0.01" min="0" value="{{ $payment->total_amount }}" required readonly
                                    style="color: black;">
                            </div>
                            <div class="col-sm-6">
                                <label for="type">Payment Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="rent" {{ $payment->type == 'rent' ? 'selected' : '' }}>Rent
                                    </option>
                                    <option value="utility" {{ $payment->type == 'utility' ? 'selected' : '' }}>Utility
                                    </option>
                                    <option value="advance" {{ $payment->type == 'advance' ? 'selected' : '' }}>Advance
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" id="amount" class="form-control"
                                    value="{{ $payment->amount }}" step="0.01" min="0" style="color: black;"
                                    required readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="payment_date">Payment Date</label>
                                <input type="date" name="payment_date" id="payment_date" class="form-control"
                                    value="{{ $payment->payment_date }}" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="month_paid">Month Paid</label>
                                <select name="month_paid" id="month_paid-{{ $payment->id }}"
                                    class="form-select select2">
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
                                <input type="number" name="year_paid" id="year_paid" class="form-control"
                                    value="{{ $payment->year_paid }}" min="1900" max="{{ date('Y') }}">
                            </div>
                            <div class="col-sm-6">
                                <label for="status">Status</label>
                                <select name="payment_status" id="status" class="form-control select2">
                                    <option value="completed"
                                        {{ $payment->payment_status == 'completed' ? 'selected' : '' }}>Completed
                                    </option>
                                    <option value="partial"
                                        {{ $payment->payment_status == 'partial' ? 'selected' : '' }}>Partial</option>
                                    <option value="pending"
                                        {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
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
@endforeach
