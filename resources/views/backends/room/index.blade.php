@extends('backends.master')
@section('title', 'Rooms')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Rooms</label>
            <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"> @lang('Add')</i></a>
            @include('backends.room.create')
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Room Number')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Size')</th>
                        <th>@lang('Floor')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($rooms)
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $room->room_number }}</td>
                                <td>{{ $room->description ?? '-' }}</td>
                                <td>{{ $room->size }}</td>
                                <td>{{ $room->floor }}</td>
                                <td>{{ $room->status }}</td>
                                <td>
                                    <a href="" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                        title="@lang('Edit')" data-bs-toggle="modal" data-bs-target="#edit_room-{{ $room->id }}"><i
                                            class="fa fa-edit ambitious-padding-btn text-uppercase">
                                            @lang('Edit')</i></a>&nbsp;&nbsp;
                                    <form id="deleteForm" action="{{ route('rooms.destroy', ['room' => $room->id]) }}"
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
                            @include('backends.room.edit')
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
