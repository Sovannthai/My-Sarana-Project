@extends('backends.master')

@section('title', 'Edit Utility Type')

@section('contents')
<div class="back-btn">
    <a href="{{ route('utility_types.index') }}" class="float-left">
        <i class="fas fa-angle-double-left"></i>&nbsp;&nbsp;Back</a>
    <br>
</div><br>

<div class="show-item">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <label class="card-title text-uppercase">@lang('Edit Utility Type')</label>
                </div>
                <form action="{{ route('utility_types.update', ['utility_type' => $utilityType->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="type">@lang('Type')</label>
                            <input type="text" name="type" value="{{ $utilityType->type }}" class="form-control" placeholder="@lang('Enter type')" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
