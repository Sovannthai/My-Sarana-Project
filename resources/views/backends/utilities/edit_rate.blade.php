@extends('backends.master')
@section('title', 'Edit Utility Rate')
@section('contents')
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label class="card-title text-uppercase">@lang('Edit Utility Rate')</label>
                    </div>
                    <form action="{{ route('utilities.updateRate', ['utilityRate' => $utilityRate->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="rate_per_unit">@lang('Rate Per Unit')</label>
                                <input type="number" name="rate_per_unit" id="rate_per_unit" class="form-control @error('rate_per_unit') is-invalid @enderror" value="{{ $utilityRate->rate_per_unit }}">
                                @error('rate_per_unit')
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
