@extends('backends.master')
@section('title', 'Role')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Roles')</label>
            {{-- @if (auth()->user()->can('create role')) --}}
            <a href="{{ route('roles.create') }}" class="btn btn-primary float-right text-uppercase btn-sm" data-value="veiw">+
                @lang('Add')</a>
            {{-- @endif --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="basic-datatables" class="table table-bordered table-hover">
                    <thead class="table-secondary">
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Created at')</th>
                            <th>@lang('Action')</th>
                        </tr>
                    </thead>
                    <body>
                        @if ($roles)
                            @foreach ($roles as $role)
                                <tr>
                                    <td>{{ $role->name }}</td>
                                    <td>{{ $role->created_at ? date('d M Y, H:i a', strtotime($role->created_at)) : '' }}
                                    </td>
                                    <td>
                                        <a href="{{ route('roles.edit', ['role' => $role->id]) }}"
                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                            title="@lang('Edit')"><i
                                                class="fa fa-edit ambitious-padding-btn"></i></a>&nbsp;&nbsp;
                                        <form id="deleteForm" action="{{ route('roles.destroy', ['role' => $role->id]) }}"
                                            method="POST" class="d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm delete-btn"
                                                title="@lang('Delete')">
                                                <i class="fa fa-trash ambitious-padding-btn"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </body>
                </table>
            </div>
        </div>
    </div>
@endsection
