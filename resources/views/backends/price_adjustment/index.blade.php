@extends('backends.master')
@section('title', 'Price Adjustments')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Price Adjustments</label>
            <a href="{{ route('price_adjustments.create') }}" class="btn btn-primary float-right text-uppercase btn-sm">
                <i class="fas fa-plus"> @lang('Add')</i></a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>No.</th>
                        <th>Room</th>
                        <th>Amount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($priceAdjustments as $adjustment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $adjustment->room->room_number }}</td>
                            <td>{{ number_format($adjustment->amount, 2) }}</td>
                            <td>{{ $adjustment->startdate }}</td>
                            <td>{{ $adjustment->enddate ?? '-' }}</td>
                            <td>
                                <a href="{{ route('price_adjustments.edit', ['price_adjustment' => $adjustment->id]) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-edit">@lang('Edit')</i>
                                </a>
                                <form action="{{ route('price_adjustments.destroy', ['price_adjustment' => $adjustment->id]) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn">
                                        <i class="fa fa-trash">@lang('Delete')</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
