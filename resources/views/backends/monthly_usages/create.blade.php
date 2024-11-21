<div class="modal fade" id="createMonthlyUsageModal" tabindex="-1" aria-labelledby="createMonthlyUsageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('monthly_usages.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createMonthlyUsageModalLabel">@lang('Add Monthly Usage')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="room_id" value="{{ $room->id }}">

                    <div class="mb-3">
                        <label for="utility_type_id" class="form-label">@lang('Utility Type')</label>
                        <select name="utility_type_id" class="form-select">
                            @foreach ($utilityTypes as $utilityType)
                                <option value="{{ $utilityType->id }}">{{ $utilityType->type }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="usage" class="form-label">@lang('Usage')</label>
                        <input type="text" class="form-control" id="usage" name="usage" required>
                    </div>

                    <div class="mb-3">
                        <label for="month" class="form-label">@lang('Month')</label>
                        <select name="month" class="form-select select2">
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
                    <div class="mb-3">
                        <label for="year" class="form-label">@lang('Year')</label>
                        <input type="number" class="form-control" id="year" name="year"
                            value="{{ date('Y') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>
