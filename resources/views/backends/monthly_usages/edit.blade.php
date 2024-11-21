<!-- resources/views/backends/monthly_usages/edit.blade.php -->

<div class="modal fade" id="editMonthlyUsageModal-{{ $usage->id }}" tabindex="-1" aria-labelledby="editMonthlyUsageModalLabel-{{ $usage->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('monthly_usages.update', $usage->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editMonthlyUsageModalLabel-{{ $usage->id }}">@lang('Edit Monthly Usage')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="room_id" value="{{ $usage->room_id }}">

                    <div class="mb-3">
                        <label for="utility_type_id" class="form-label">@lang('Utility Type')</label>
                        <select name="utility_type_id" class="form-select">
                            @foreach ($utilityTypes as $utilityType)
                                <option value="{{ $utilityType->id }}" {{ $utilityType->id == $usage->utility_type_id ? 'selected' : '' }}>
                                    {{ $utilityType->type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="usage" class="form-label">@lang('Usage')</label>
                        <input type="text" class="form-control" id="usage" name="usage" value="{{ $usage->usage }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="month" class="form-label">@lang('Month')</label>
                        <select name="month" class="form-select select2">
                            <option value="1" {{ $usage->month == 1 ? 'selected' : '' }}>@lang('January')</option>
                            <option value="2" {{ $usage->month == 2 ? 'selected' : '' }}>@lang('February')</option>
                            <option value="3" {{ $usage->month == 3 ? 'selected' : '' }}>@lang('March')</option>
                            <option value="4" {{ $usage->month == 4 ? 'selected' : '' }}>@lang('April')</option>
                            <option value="5" {{ $usage->month == 5 ? 'selected' : '' }}>@lang('May')</option>
                            <option value="6" {{ $usage->month == 6 ? 'selected' : '' }}>@lang('June')</option>
                            <option value="7" {{ $usage->month == 7 ? 'selected' : '' }}>@lang('July')</option>
                            <option value="8" {{ $usage->month == 8 ? 'selected' : '' }}>@lang('August')</option>
                            <option value="9" {{ $usage->month == 9 ? 'selected' : '' }}>@lang('September')</option>
                            <option value="10" {{ $usage->month == 10 ? 'selected' : '' }}>@lang('October')</option>
                            <option value="11" {{ $usage->month == 11 ? 'selected' : '' }}>@lang('November')</option>
                            <option value="12" {{ $usage->month == 12 ? 'selected' : '' }}>@lang('December')</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="year" class="form-label">@lang('Year')</label>
                        <input type="number" class="form-control" id="year" name="year" value="{{ $usage->year }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
