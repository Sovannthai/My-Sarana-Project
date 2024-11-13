@extends('backends.master')
@section('title', 'Permission')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Permissions</label>
            <a href="{{ route('permission.create') }}" class="btn btn-primary float-right text-uppercase btn-sm"
                data-value="veiw">
                <i class="fas fa-plus"> @lang('Add')</i></a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-dark">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Guard')</th>
                        <th>@lang('Created at')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>

                <body>
                    @if ($permissions)
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->guard_name }}</td>
                                <td>{{ $permission->created_at ? date('d M Y, H:i a', strtotime($permission->created_at)) : '' }}
                                </td>
                                <td>
                                    <a href="{{ route('permission.edit', ['permission' => $permission->id]) }}"
                                        class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                        title="@lang('Edit')"><i
                                            class="fa fa-edit ambitious-padding-btn text-uppercase">
                                            @lang('Edit')</i></a>&nbsp;&nbsp;
                                    <form id="deleteForm"
                                        action="{{ route('permission.destroy', ['permission' => $permission->id]) }}"
                                        method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                            title="@lang('Delete')">
                                            <i class="fa fa-trash ambitious-padding-btn text-uppercase">
                                                @lang('Delete')</i>
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
@endsection
