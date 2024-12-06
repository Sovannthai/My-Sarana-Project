<!-- Modal -->
<div class="modal fade edit_price" id="edit_price-{{ $adjustment->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_priceLabel">Edit Price Adjustment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('price_adjustments.update', ['price_adjustment' => $adjustment->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="room_id">Room</label>
                            <select name="room_id" id="room_id" class="form-control select2">
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}" @if($adjustment->room_id == $room->id) selected @endif>
                                        {{ $room->room_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="discount_type">Discount Type</label>
                            <select name="discount_type" id="discount_type" class="form-control select2 discount_type">
                                <option value="amount" {{ $adjustment->discount_type == 'amount' ? 'selected' : '' }}>Amount</option>
                                <option value="percentage" {{ $adjustment->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
                            </select>
                        </div>

                        <div class="col-sm-4" id="amount-field" >
                            <label for="amount">Discount Value</label>
                            <input type="number" name="percentage" id="amount" class="form-control"
                                   value="{{ $adjustment->percentage }}" step="0.01" min="0">
                        </div>
                        <div class="col-sm-4">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ $adjustment->start_date }}">
                        </div>
                        <div class="col-sm-4">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ $adjustment->end_date }}">
                        </div>
                        <div class="col-sm-4">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="active" {{ $adjustment->status == 'active' ? 'selected' : '' }}>Active
                                </option>
                                <option value="inactive" {{ $adjustment->status == 'inactive' ? 'selected' : '' }}>
                                    Inactive</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" rows="3">{{ $adjustment->description }}</textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit"
                                class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">Update</button>
                            <a href="" type="button" data-bs-dismiss="modal"
                                class="float-right btn btn-dark btn-sm">
                                @lang('Cancel')
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
