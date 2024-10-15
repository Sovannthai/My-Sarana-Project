@extends('backends.master')
@section('title', 'Create Room')
@section('contents')
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title text-uppercase">@lang('Create Room')</label>
                    </div>
                    <form action="{{ route('rooms.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="room_number">@lang('Room Number')</label>
                                <input type="text" name="room_number" id="room_number" class="form-control @error('room_number') is-invalid @enderror" placeholder="@lang('Enter room number')">
                                @error('room_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <textarea name="description" id="description" class="form-control" placeholder="@lang('Enter room description')"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="size">@lang('Size')</label>
                                <input type="text" name="size" id="size" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="floor">@lang('Floor')</label>
                                <input type="number" name="floor" id="floor" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="status">@lang('Status')</label>
                                <input type="text" name="status" id="status" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                <i class="fas fa-save"></i> @lang('Submit')
                            </button>
                            <a href="{{ route('rooms.index') }}" class="float-right btn btn-dark btn-sm">
                                @lang('Cancel')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
