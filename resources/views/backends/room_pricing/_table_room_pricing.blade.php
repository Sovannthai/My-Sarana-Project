<div class="card-body table-wrap table-responsive">
    <table class="table table-bordered text-nowrap table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>@lang('No.')</th>
                <th>@lang('Room Number')</th>
                <th>@lang('Price')</th>
                <th>@lang('Effective Date')</th>
                <th>@lang('Actions')</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($room_pricings as $room)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $room->room->room_number }}</td>
                    <td>{{ $currencySymbol }} {{ number_format($room->converted_price, 2) }}</td>
                    <td>{{ $room->effective_date }}</td>
                    <td>
                        @if(auth()->user()->can('update roomprice'))
                        <a href="" class="btn btn-outline-primary btn-sm text-uppercase" data-bs-toggle="modal"
                            data-bs-target="#edit-pricing-{{ $room->id }}">
                            <i class="fa fa-edit"></i> @lang('Edit')
                        </a>
                        @endif
                        @if(auth()->user()->can('delete roomprice'))
                        <form action="{{ route('room-prices.destroy',['room_price'=>$room->id]) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn text-uppercase">
                                <i class="fa fa-trash"></i> @lang('Delete')
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @include('backends.room_pricing.edit')
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">@lang('No records found')</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="col-12 d-flex flex-row flex-wrap">
        <div class="col-12 col-sm-6 text-center text-sm-left" style="margin-block: 20px">
            {{ __('Showing') }} {{ $paginatedRoomPricings->firstItem() }} {{ __('to') }}
            {{ $paginatedRoomPricings->lastItem() }} {{ __('of') }} {{ $paginatedRoomPricings->total() }}
            {{ __('entries') }}
        </div>
        <div class="col-12 col-sm-6"> {{ $paginatedRoomPricings->appends(request()->input())->links() }}</div>
    </div>
</div>
