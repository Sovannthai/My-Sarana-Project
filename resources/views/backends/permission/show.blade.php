@extends('backends.master')
@push('css')
    <style>
        .table-borderless td,
        .table-borderless th {
            border: 0;
        }
        .show-item{
            padding: 10px;
        }
    </style>
@endpush
@section('contents')
<div class="show-item">
    <div class="back-btn">
        <a href="{{route('permission.index')}}" class="float-left" data-value="veiw">
            <i class="fa-solid fa-angles-left"></i>&nbsp;&nbsp;
            Back to all Permissions
        </a><br>
    </div><br>
    <div class="card">
        <div class="card-body">
            <div class="col-sm-12">
                <div class="row">
                    <div class="form-group col-xs-6 col-sm-4 col-md-3 ">
                        <label class="font-weight-bold mb-1">@lang('ID')</label>
                        <p>{{ $permission->id}}</p>
                    </div>
                    <div class="form-group col-xs-6 col-sm-4 col-md-3">
                        <label class="font-weight-bold mb-1">@lang('Name')</label>
                        <p>{{ $permission->name}}</p>
                    </div>
                    <div class="form-group col-xs-6 col-sm-4 col-md-3 ">
                        <label class="font-weight-bold mb-1">@lang('Create at')</label>
                        <p>{{\Carbon\Carbon::parse($permission->create_at)->format('d-m-Y')}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
