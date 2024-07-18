@extends('backends.master')
@section('title','Edit Role')
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
                    <form class="form-material form-horizontal" action="{{ route('roles.update', $role->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="name"><b>@lang('Name')</b></label>
                                        <div class="input-group mb-3">
                                            <input type="text" value="{{ $role->name }}" name="name"
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
                                <!-- Uncomment this if you want to include description -->
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description"><b>Description</b></label>
                                        <textarea class="form-control" name="description" rows="3">{{ $role->description }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div>
                                <div class="d-flex">
                                    <label for="" class="mr-2"><b>@lang('Permissions')</b></label>
                                </div>
                                <br>
                                <div class="row">
                                    @foreach ($permissions as $permission => $permissionList)
                                        <div class="col-md-4">
                                            <label for="" class="mr-2"><b>{{ ucwords($permission) }}</b></label>
                                            <br><br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @foreach ($permissionList as $perm)
                                                        <div class="form-group">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group">
                                                                    <label class="switch">
                                                                        <input type="checkbox" id="view_user"
                                                                        name="permissions[]"
                                                                        @if (in_array($perm->name, $rolePermissions)) checked @endif
                                                                        value="{{ $perm->name }}" data-toggle="toggle">
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                    <span class="ml-2">{{ $perm->display }}</span>
                                                                </div>
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
