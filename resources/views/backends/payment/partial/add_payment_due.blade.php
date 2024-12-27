@foreach ($payment_using_for_modals as $payment)
    <div class="modal fade" id="add_payment_due-{{ $payment->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Due Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('payments.update', ['payment' => $payment->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="befor_paid_amount" value="{{ $payment->amount }}">
                        <input type="hidden" name="payment_status" value="{{ $payment->payment_status }}">
                        <input type="hidden" name="total_amount_paid" value="{{ $payment->total_amount }}">
                        <input type="hidden" name="total_due" value="{{ $payment->total_due_amount }}">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="paid_due_amount">Total Due</label>
                                <input type="number" step="any" min="0.00" class="form-control"
                                    id="paid_due_amount" name="paid_due_amount"
                                    value="{{ $payment->total_due_amount }}" readonly style="color: black">
                            </div>
                            <div class="col-sm-6">
                                <label for="due_type">Due Type</label>
                                @if ($payment->type == 'rent')
                                    <input type="text" class="form-control" id="due_type" name="due_type" disabled style="color: black" value="Utility">
                                @elseif($payment->type == 'utility')
                                    <input type="text" class="form-control" id="due_type" name="due_type" disabled style="color: black" value="Rent">
                                @else
                                    <input type="text" class="form-control" id="due_type" name="due_type" disabled style="color: black" value="All Paid">
                                @endif
                            </div>
                            <div class="col-sm-12">
                                <label for="type">Payment Type</label>
                                <select name="type" id="type" class="form-control">
                                    <option value="all_paid" selected>Paid for All</option>
                                </select>
                            </div>
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
    </div>
@endforeach
