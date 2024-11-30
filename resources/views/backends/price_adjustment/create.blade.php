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
                        <div class="col-sm-4">
                            <label for="room_id">Room</label>
                            <select name="room_id" id="room_id" class="form-control select2">
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="discount_type">Discount Type</label>
                            <select name="discount_type" id="discount_type" class="form-control select2">
                                <option value="amount">Amount</option>
                                <option value="percentage">Percentage</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="percentage">Discount Value</label>
                            <input type="number" name="percentage" id="percentage" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-sm-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
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
</Script>
