@extends('backends.master')
@section('title', 'Edit Utility Type')
@section('contents')
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title text-uppercase">@lang('Edit Utility Type')</label>
                    </div>
                    <form action="{{ route('utilities.updateType', ['utilityType' => $utilityType->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="type">@lang('Utility Type')</label>
                                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror" value="{{ $utilityType->type }}">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                <i class="fas fa-save"></i> @lang('Submit')
                            </button>
                            <a href="{{ route('utilities.index') }}" class="float-right btn btn-dark btn-sm">
                                @lang('Cancel')
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
