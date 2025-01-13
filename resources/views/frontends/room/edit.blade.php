@extends('backends.master')

@push('css')
    <style>
        .show-item {
            padding: 10px;
        }
    </style>
@endpush

@section('title', 'Edit Room')

@section('contents')
    <div class="back-btn">
        <a href="{{ route('rooms.index') }}" class="float-left" data-value="view">
            <i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;
            @lang('Back')
        </a><br>
    </div><br>
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label for="" class="card-title text-uppercase">@lang('Edit Room')</label>
                    </div>
                    <form class="form-material form-horizontal" action="{{ route('rooms.update', $room->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <!-- Room Number -->
                                <div class="col-sm-6">
                                    <label for="room_number">@lang('Room Number')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="room_number" name="room_number"
                                            value="{{ old('room_number', $room->room_number) }}"
                                            class="form-control @error('room_number') is-invalid @enderror"
                                            placeholder="@lang('Enter Room Number')">
                                        @error('room_number')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="size">@lang('Size')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="size" name="size"
                                            value="{{ old('size', $room->size) }}"
                                            class="form-control @error('size') is-invalid @enderror"
                                            placeholder="@lang('Enter Room Size')">
                                        @error('size')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="floor">@lang('Floor')</label>
                                    <div class="input-group mb-3">
                                        <input type="number" id="floor" name="floor"
                                            value="{{ old('floor', $room->floor) }}"
                                            class="form-control @error('floor') is-invalid @enderror"
                                            placeholder="@lang('Enter Floor Number')">
                                        @error('floor')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label for="status">@lang('Status')</label>
                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>
                                            @lang('Available')</option>
                                        <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>
                                            @lang('Occupied')</option>
                                        <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>
                                            @lang('Under Maintenance')</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <!-- Room Description -->
                                <div class="col-sm-12">
                                    <label for="description">@lang('Description')</label>
                                    <div class="input-group mb-3">
                                        <textarea id="description" name="description" rows="4" class="form-control @error('description') is-invalid @enderror"
                                            placeholder="@lang('Enter Room Description')">{{ old('description', $room->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit"
                                class="btn btn-outline btn-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                <i class="fas fa-save"></i> {{ __('Update') }}
                            </button>
                            <a href="{{ route('rooms.index') }}" class="float-right btn btn-dark btn-sm">
                                @lang('Back')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
