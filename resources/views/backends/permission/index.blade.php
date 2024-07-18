@extends('backends.master')
@section('title', 'Permission')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Permissions</label>
            <a href="{{ route('permission.create') }}" class="btn btn-primary float-right text-uppercase btn-sm"
                data-value="veiw">+
                Add New</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="basic-datatables" class="table table-bordered table-hover">
                    <thead class="table-secondary">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Guard</th>
                            <th>Created at</th>
                            <th>Actions</th>
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
                                        {{-- @include('layouts.btn_stack', [
                                            'route' => 'permission',
                                            'id' => $permission->id,
                                        ]) --}}
                                        <a href="{{ route('permission.edit', ['permission' => $permission->id]) }}"
                                            class="btn btn-primary btn-sm" data-toggle="tooltip"
                                            title="@lang('Edit')"><i
                                                class="fa fa-edit ambitious-padding-btn"></i></a>&nbsp;&nbsp;
                                        <form id="deleteForm"
                                            action="{{ route('permission.destroy', ['permission' => $permission->id]) }}"
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
    {{-- @include('layouts.delete_modal') --}}
@endsection
