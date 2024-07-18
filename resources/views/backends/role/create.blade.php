@extends('backends.master')
@section('title','Create Role')
<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 40px;
        /* Smaller width */
        height: 20px;
        /* Smaller height */
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        /* Smaller height */
        width: 16px;
        /* Smaller width */
        left: 2px;
        /* Adjusted for smaller size */
        bottom: 2px;
        /* Adjusted for smaller size */
        background-color: white;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        transform: translateX(18px);
        /* Adjusted for smaller size */
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 20px;
        /* Adjusted for smaller size */
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>
@section('contents')
    <div class="show-item">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form class="form-material form-horizontal" action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name"><b>@lang('Roles')</b></label>
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
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description"><b>Description</b></label>
                                        <textarea class="form-control" name="description" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class="">
                                    <label for="view_user" class="mr-2"><b>@lang('All Permission')</b></label><br>
                                    <label class="switch">
                                        <input type="checkbox" id="select-all">
                                        <span class="slider round"></span>
                                    </label>
                                </div><br>
                                <div class="row">
                                    @foreach ($permissions as $permission => $permissionList)
                                        <div class="col-sm-4">
                                            <label class="mr-2"><b>{{ ucwords($permission) }}</b></label><br><br>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    @foreach ($permissionList as $perm)
                                                        <div class="form-group">
                                                            <div class="input-group">
                                                                <label class="switch">
                                                                    <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" data-toggle="toggle">
                                                                    <span class="slider round"></span>
                                                                </label>
                                                                <span class="ml-2">{{ $perm->display }}</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit"
                                class="btn btn-outline btn-primary btn-sm mb-2 text-uppercase float-right ml-2">
                                <i class="fas fa-save"></i> {{ __('Submit') }}
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-dark btn-sm mb-2 float-right">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
