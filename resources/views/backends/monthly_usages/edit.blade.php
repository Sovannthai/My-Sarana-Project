<div class="modal fade" id="editMonthlyUsageModal-{{ $usage->id }}" tabindex="-1"
    aria-labelledby="editMonthlyUsageModalLabel-{{ $usage->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('monthly_usages.update', $usage->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title" id="editMonthlyUsageModalLabel-{{ $usage->id }}">
                        @lang('Edit Monthly Usage')
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <!-- Hidden Room ID -->
                    <input type="hidden" name="room_id" value="{{ $usage->room_id }}">

                    <!-- Month -->
                    <div class="mb-3">
                        <label for="month-{{ $usage->id }}" class="form-label">@lang('Month')</label>
                        <select name="month" id="month-{{ $usage->id }}" class="form-select select2">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ $usage->month == $i ? 'selected' : '' }}>
                                    {{ \Illuminate\Support\Carbon::create()->month($i)->format('F') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <!-- Year -->
                    <div class="mb-3">
                        <label for="year-{{ $usage->id }}" class="form-label">@lang('Year')</label>
                        <input type="number" class="form-control" id="year-{{ $usage->id }}" name="year"
                            value="{{ $usage->year }}" required>
                    </div>

                    <div id="utility-container">
                        <div class="row">
                            @foreach ($usage->utilityTypes as $index => $utility)
                                <div class="utility-item col-sm-6 mb-3">
                                    <label for="utility_type_id_{{ $index }}"
                                        class="form-label">@lang('Utility Type')</label>
                                    <select name="utility_type_id[]" class="form-select" required>
                                        @foreach ($utilityTypes as $utilityType)
                                            <option value="{{ $utilityType->id }}"
                                                {{ $utilityType->id == $utility->pivot->utility_type_id ? 'selected' : '' }}>
                                                {{ $utilityType->type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 mb-3">
                                    <label for="usage_{{ $index }}" class="form-label">@lang('Usage')</label>
                                    <input type="text" class="form-control usage-input" name="usage[]"
                                        value="{{ $utility->pivot->usage }}" required>
                                </div>
                                @if ($index > 0)
                                    <div class="col-sm-2 mt-4">
                                        <button type="button"
                                            class="btn btn-sm btn-danger remove-utility">@lang('Remove')</button>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <button type="button" id="add-utility" class="btn btn-primary mt-3">@lang('Add More')</button>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="btn btn-primary">@lang('Update')</button>
                </div>
            </form>
        </div>
    </div>
</div>
