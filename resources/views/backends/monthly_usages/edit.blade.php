@extends('backends.master')
@section('title', 'Edit Monthly Usage')
@section('contents')
<div class="card">
    <div class="card-header">
        <label class="card-title text-uppercase">@lang('Edit Monthly Usage')</label>
    </div>
    <form action="{{ route('monthly_usages.update', $monthlyUsage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="room_id">@lang('Room')</label>
                <select name="room_id" id="room_id" class="form-control @error('room_id') is-invalid @enderror">
                    <option value="">@lang('Select Room')</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ $room->id == $monthlyUsage->room_id ? 'selected' : '' }}>
                            {{ $room->room_number }}
                        </option>
                    @endforeach
                </select>
                @error('room_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="utility_type_id">@lang('Utility Type')</label>
                <select name="utility_type_id" id="utility_type_id" class="form-control @error('utility_type_id') is-invalid @enderror">
                    <option value="">@lang('Select Utility Type')</option>
                    @foreach ($utilityTypes as $utilityType)
                        <option value="{{ $utilityType->id }}" {{ $utilityType->id == $monthlyUsage->utility_type_id ? 'selected' : '' }}>
                            {{ $utilityType->type }}
                        </option>
                    @endforeach
                </select>
                @error('utility_type_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="month">@lang('Month')</label>
                <input type="number" name="month" id="month" class="form-control @error('month') is-invalid @enderror" min="1" max="12" value="{{ $monthlyUsage->month }}">
                @error('month')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="year">@lang('Year')</label>
                <input type="number" name="year" id="year" class="form-control @error('year') is-invalid @enderror" value="{{ $monthlyUsage->year }}">
                @error('year')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="usage">@lang('Usage')</label>
                <input type="number" name="usage" id="usage" class="form-control @error('usage') is-invalid @enderror" step="0.01" value="{{ $monthlyUsage->usage }}">
                @error('usage')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                <i class="fas fa-save"></i> @lang('Update')
            </button>
            <a href="{{ route('monthly_usages.index') }}" class="float-right btn btn-dark btn-sm">
                @lang('Cancel')
            </a>
        </div>
    </form>
</div>
@endsection
