@extends('backends.master')

@push('css')
    <style>
        .show-item {
            padding: 10px;
        }
    </style>
@endpush
@section('title', 'Create Room')
@section('contents')
    <div class="back-btn">
        <a href="{{ route('rooms.index') }}" class="float-left" data-value="view">
            <i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;
            Back
        </a><br>
    </div><br>
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label for="" class="card-title text-uppercase">@lang('Create Room')</label>
                    </div>
                    <form class="form-material form-horizontal" action="{{ route('rooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <!-- Room Number -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="room_number">@lang('Room Number')</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="room_number" name="room_number"
                                                class="form-control @error('room_number') is-invalid @enderror"
                                                placeholder="@lang('Enter Room Number')">
                                            @error('room_number')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Room Description -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">@lang('Description')</label>
                                        <div class="input-group mb-3">
                                            <textarea id="description" name="description"
                                                class="form-control @error('description') is-invalid @enderror"
                                                placeholder="@lang('Enter Room Description')"></textarea>
                                            @error('description')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Room Size -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="size">@lang('Size')</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="size" name="size"
                                                class="form-control @error('size') is-invalid @enderror"
                                                placeholder="@lang('Enter Room Size')">
                                            @error('size')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Floor -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="floor">@lang('Floor')</label>
                                        <div class="input-group mb-3">
                                            <input type="number" id="floor" name="floor"
                                                class="form-control @error('floor') is-invalid @enderror"
                                                placeholder="@lang('Enter Floor Number')">
                                            @error('floor')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Status -->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">@lang('Status')</label>
                                        <select id="status" name="status" class="form-control @error('status') is-invalid @enderror">
                                            <option value="available">@lang('Available')</option>
                                            <option value="occupied">@lang('Occupied')</option>
                                            <option value="maintenance">@lang('Under Maintenance')</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline btn-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                <i class="fas fa-save"></i> {{ __('Submit') }}
                            </button>
                            <a href="{{ route('rooms.index') }}" class="float-right btn btn-dark btn-sm " data-value="view">
                                Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
