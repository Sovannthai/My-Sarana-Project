@extends('backends.master')

@push('css')
    <style>
        .show-item {
            padding: 10px;
        }
    </style>
@endpush

@section('title', 'Create Amenity')
@section('contents')
    <div class="back-btn">
        <a href="{{ route('amenities.index') }}" class="float-left" data-value="view">
            <i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;
            Back
        </a><br>
    </div><br>
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title text-uppercase">@lang('Create Amenity')</label>
                    </div>
                    <form action="{{ route('amenities.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" placeholder="@lang('Enter amenity name')">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">@lang('Description')</label>
                                <textarea name="description" id="description" class="form-control" placeholder="@lang('Enter amenity description')"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="additional_price">@lang('Additional Price')</label>
                                <input type="number" step="0.01" name="additional_price" id="additional_price" class="form-control @error('additional_price') is-invalid @enderror" placeholder="@lang('Enter additional price')">
                                @error('additional_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                <i class="fas fa-save"></i> @lang('Submit')
                            </button>
                            <a href="{{ route('amenities.index') }}" class="float-right btn btn-dark btn-sm">
                                @lang('Back')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
