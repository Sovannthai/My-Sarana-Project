@extends('backends.master')
@section('title', 'Edit User')
@section('contents')
<div class="back-btn">
    <a href="{{ route('users.index') }}" class="float-left" data-value="veiw">
        <i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;
        Back
    </a><br>
</div><br>
<div class="card">
    <div class="card-header text-uppercase">@lang('Edit')</div>
    <div class="card-body">
        <form action="{{ route('users.update',['user'=>$user->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group row">
                <div class="col-sm-4">
                    <label for="">@lang('Full Name')</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter full name" value="{{ $user->name }}">
                </div>
                <div class="col-sm-4">
                    <label for="">@lang('Email')</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter email" value="{{ $user->email }}">
                    @error('email')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-sm-4">
                    <label for="">@lang('Password')</label>
                    <input type="password" class="form-control" name="password" placeholder="Enter password">
                </div>
                <div class="col-sm-4">
                    <label for="">@lang('Role')</label>
                    <select class="form-control ambitious-form-loading select2" name="role" id="role">
                        <option value="{{ old('role') }}" disabled selected>@lang('Select')</option>
                        @foreach ($roles as $role)
                        @if (old('role') == $role->id)
                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                        @elseif ($user->roles->contains($role->id))
                        <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                        @else
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="photo" class="col-form-label">@lang('Profile')</label>
                    <input name="image" type="file" class="dropify" data-height="100" data-default-file="{{ url('uploads/all_photo/' . $user->image) }}" value="{{ $user->image }}" /><br>
                    <input type="hidden" name="video" value="{{ $user->image }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-sm float-lg-right ml-1">@lang('Update')</button>
            <a href="{{ route('users.index') }}" class="btn btn-dark btn-sm float-lg-right">@lang('Cancel')</a>
        </form>
    </div>
</div>
@endsection
