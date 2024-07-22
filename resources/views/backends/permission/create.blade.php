@extends('backends.master')

@push('css')
    <style>
        .show-item {
            padding: 10px;
        }
    </style>
@endpush
@section('title', 'Create Permission')
@section('contents')
    <div class="back-btn">
        <a href="{{ route('permission.index') }}" class="float-left" data-value="veiw">
            <i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;
            Back
        </a><br>
    </div><br>
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <label for="" class="card-title text-uppercase">@lang('Create')</label>
                    </div>
                    <form class="form-material form-horizontal" action="{{ route('permission.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name">@lang('Permission')</label>
                                        <div class="input-group mb-3">
                                            <input type="text" id="name" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                placeholder="@lang('Type name permission')">
                                            @error('name')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit"
                                class="btn btn-outline btn-primary btn-sm text-uppercase float-right mb-2 ml-2"> <i
                                    class="fas fa-save"></i> {{ __('Submit') }}</button>
                            <a href="{{ route('permission.index') }}" class="float-right btn btn-dark btn-sm "
                                data-value="veiw">
                                Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
