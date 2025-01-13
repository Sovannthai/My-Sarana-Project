<div class="modal fade" id="create_price" tabindex="-1" aria-labelledby="create_priceLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="create_priceLabel">@lang('Create Price Adjustment')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('price_adjustments.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-4">
                            <label for="room_id">@lang('Room')</label>
                            <select name="room_id" id="room_id" class="form-control select2" required>
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="discount_type">@lang('Discount Type')</label>
                            <select name="discount_type" id="discount_type" class="form-control select2">
                                <option value="amount">@lang('Amount')</option>
                                <option value="percentage">@lang('Percentage')</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label for="percentage">@lang('Discount Value')</label>
                            <input type="number" name="discount_value" id="percentage" class="form-control" step="0.01" min="0">
                        </div>
                        <div class="col-sm-4">
                            <label for="start_date">@lang('Start Date')</label>
                            <input type="date" name="start_date" id="start_date" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="end_date">@lang('End Date')</label>
                            <input type="date" name="end_date" id="end_date" class="form-control">
                        </div>
                        <div class="col-sm-4">
                            <label for="status">@lang('Status')</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="active">@lang('Active')</option>
                                <option value="inactive">@lang('Inactive')</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="description">@lang('Description')</label>
                            <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">@lang('Create')</button>
                            <a href="#" class="float-right btn btn-dark btn-sm" data-bs-dismiss="modal">
                                @lang('Cancel')
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
