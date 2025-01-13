@extends('backends.master')
@section('title', __('Utilities Type'))
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Utilities Type')</label>
            @if(auth()->user()->can('create utilitytype'))
            <a href="" class="float-right btn btn-primary btn-sm" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"> @lang('Add Utility Type')</i>
            </a>
            @include('backends.utilitie_type.create')
            @endif
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-dark">
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($utilityTypes as $utility_type)
                        <tr>
                            <td>{{ $utility_type->type }}</td>
                            <td>
                                @if(auth()->user()->can('update utilitytype'))
                                <a href="" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#edit_utilities-{{ $utility_type->id }}">@lang('Edit')</a>
                                &nbsp;&nbsp;
                                @endif
                                @if(auth()->user()->can('delete utilitytype'))
                                <form action="{{ route('utilities.destroyType', ['id' => $utility_type->id]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                        title="@lang('Delete Rate')">
                                        <i class="fa fa-trash"></i> @lang('Delete')
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @include('backends.utilitie_type.edit')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
