@extends('backends.master')
@section('title', 'User Management')
@section('contents')
    <div class="card">
        <div class="card-header text-uppercase">
            @lang('Users')
            @if (auth()->user()->can('create user'))
                <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm float-right">+ @lang('Add')</a>
            @endif
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('Profile')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Role')</th>
                        <th>@lang('Email')</th>
                        <th>@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <span>
                                    <a class="example-image-link"
                                        href="{{ $user->image ? asset('uploads/all_photo/' . $user->image) : $user->avatar }}"
                                        data-lightbox="lightbox-{{ $user->id }}">
                                        <img class="example-image image-thumbnail"
                                            src="{{ $user->image ? asset('uploads/all_photo/' . $user->image) : $user->avatar }}"
                                            alt="profile" width="50px" height="50px" style="cursor:pointer" />
                                    </a>
                                </span>
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ @$user->roles->first()->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if (auth()->user()->can('update user'))
                                    <a href="{{ route('users.edit', ['user' => $user->id]) }}"
                                        class="btn btn-outline-primary btn-sm text-uppercase" data-toggle="tooltip"
                                        title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn">
                                            @lang('Edit')</i></a>&nbsp;&nbsp;
                                @endif
                                @if ($user->telegram_id != null)
                                    <form action="{{ route('send-invoice', ['userId' => $user->id]) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning btn-sm">
                                            @lang('Send Invoice')
                                        </button>
                                    </form>
                                @endif
                                @if (@$user->roles->first()->name != 'Admin')
                                    <a href="{{ route('invoice.download', $user->id) }}"
                                        class="btn btn-outline-info btn-sm">
                                        Download Invoice
                                    </a>
                                @endif
                                @if (@$user->roles->first()->name != 'Admin')
                                    @if (auth()->user()->can('delete user'))
                                        <form id="deleteForm" action="{{ route('users.destroy', ['user' => $user->id]) }}"
                                            method="POST" class=" d-inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-outline-danger btn-sm delete-btn text-uppercase"
                                                title="@lang('Delete')">
                                                <i class="fa fa-trash ambitious-padding-btn"> @lang('Delete')</i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('js')
    @endpush
@endsection
