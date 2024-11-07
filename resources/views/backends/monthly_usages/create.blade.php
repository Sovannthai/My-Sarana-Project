@extends('backends.master')
@section('title', 'Add Monthly Usage')
@section('contents')
<div class="card">
    <div class="card-header">
        <label class="card-title text-uppercase">@lang('Choose Room, Month, and Year')</label>
    </div>
    <form action="{{ route('monthly_usages.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="room_id">@lang('Room')</label>
                <select name="room_id" id="room_id" class="form-control @error('room_id') is-invalid @enderror">
                    <option value="">@lang('Select Room')</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                    @endforeach
                </select>
                @error('room_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="month">@lang('Month')</label>
                <input type="number" name="month" id="month" class="form-control @error('month') is-invalid @enderror" min="1" max="12" placeholder="@lang('Enter Month')">
                @error('month')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="year">@lang('Year')</label>
                <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" placeholder="@lang('Enter Year')">
                @error('year')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div id="utility-section" style="display: none;">
                <label class="mt-3">@lang('Utility Types & Usage')</label>
                <div id="utility-inputs"></div>
                <button type="button" class="btn btn-sm btn-success mt-2" onclick="addUtilityInput()">
                    @lang('Add Utility Type')
                </button>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                <i class="fas fa-next"></i> @lang('Submit')
            </button>
            <a href="{{ route('monthly_usages.index') }}" class="float-right btn btn-dark btn-sm">
                @lang('Cancel')
            </a>
        </div>
    </form>
</div>

<script>
    document.getElementById('month').addEventListener('change', toggleUtilitySection);
    document.getElementById('year').addEventListener('change', toggleUtilitySection);

    function toggleUtilitySection() {
        const month = document.getElementById('month').value;
        const year = document.getElementById('year').value;
        if (month && year) {
            document.getElementById('utility-section').style.display = 'block';
        }
    }

    function addUtilityInput() {
        const container = document.getElementById('utility-inputs');
        const index = container.children.length;
        const utilityRow = `
            <div class="form-group row" id="utility-row-${index}">
                <div class="col-md-6">
                    <select name="utility_types[${index}][utility_type_id]" class="form-control" required>
                        <option value="">@lang('Select Utility Type')</option>
                        @foreach ($utilityTypes as $utilityType)
                            <option value="{{ $utilityType->id }}">{{ $utilityType->type }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="utility_types[${index}][usage]" class="form-control" step="0.01" required placeholder="@lang('Enter Usage')">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-sm btn-danger" onclick="removeUtilityInput(${index})">@lang('Remove')</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', utilityRow);
    }

    function removeUtilityInput(index) {
        document.getElementById(`utility-row-${index}`).remove();
    }
</script>
@endsection
