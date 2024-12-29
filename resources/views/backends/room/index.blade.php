@extends('backends.master')
@section('title', 'Rooms')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Rooms</label>
            @if(auth()->user()->can('create room'))
            <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"> @lang('Add')</i></a>
            @include('backends.room.create')
            @endif
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Room Number')</th>
                        <th>@lang('Size')</th>
                        <th>@lang('Floor')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Amenity')</th>
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
                                <td>{{ $room->size }}</td>
                                <td>{{ $room->floor }}</td>
                                <td>
                                    @php
                                        $latestPricing = $room->roomPricing->sortByDesc('effective_date')->first();
                                    @endphp
                                    @if ($latestPricing)
                                        {{ $currencySymbol }}
                                        {{ number_format($latestPricing->base_price * $baseExchangeRate, 2) }}
                                    @else
                                        @lang('Not Set')
                                    @endif
                                </td>
                                <td>
                                    @foreach ($room->amenities as $amenity)
                                        <li>{{ $amenity->name }}</li>
                                    @endforeach
                                    @if ($room->amenities->isEmpty())
                                        <li>@lang('Not Set')</li>
                                    @endif
                                </td>
                                <td>{{ $room->status }}</td>
                                <td>
                                    @if(auth()->user()->can('update room'))
                                    <a href="" class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                        title="@lang('Edit')" data-bs-toggle="modal"
                                        data-bs-target="#edit_room-{{ $room->id }}"><i
                                            class="fa fa-edit ambitious-padding-btn text-uppercase">
                                            @lang('Edit')</i></a>&nbsp;&nbsp;
                                    @endif
                                    @if(auth()->user()->can('delete room'))
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
                                    @endif
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
