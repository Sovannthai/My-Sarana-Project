<div class="modal fade" id="createMonthlyUsageModal" tabindex="-1" aria-labelledby="createMonthlyUsageModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
                    <div id="utility-container">
                        <div class="row utility-item mb-3">
                            <div class="col-sm-6">
                                <label for="utility_type_id_0" class="form-label">@lang('Utility Type')</label>
                                <select name="utility_type_id[]" class="form-select">
                                    @foreach ($utilityTypes as $utilityType)
                                        <option value="{{ $utilityType->id }}">{{ $utilityType->type }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label for="usage_0" class="form-label">@lang('Usage')</label>
                                <input type="text" class="form-control usage-input" name="usage[]" required>
                            </div>
                            <div class="col-sm-2 mt-4">
                                <button type="button"
                                    class="btn btn-danger btn-sm remove-utility">@lang('Remove')</button>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex">
                        <button type="button" id="add-utility" class="btn btn-primary">@lang('Add More')</button>
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
