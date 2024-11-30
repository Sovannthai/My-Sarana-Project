@extends('backends.master')
@section('title', 'Price Adjustments')
@section('contents')
<div class="card">
      <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Price Adjustments</label>
            <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop">
                <i class="fas fa-plus"> @lang('Add')</i></a>
            @include('backends.price_adjustment.create')
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>No.</th>
                        <th>Room</th>
                        <th>Discount Type</th>
                        <th>Discount</th>
                        <th>Description</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($priceAdjustments as $adjustment)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $adjustment->room->room_number }}</td>
                            <td>{{ $adjustment->discount_type }}</td>
                            <td>{{ $adjustment->percentage }}%</td>
                            <td>{{ $adjustment->description ?? '-' }}</td>
                            <td>{{ $adjustment->start_date ? \Carbon\Carbon::parse($adjustment->start_date)->format('Y-m-d') : '-' }}</td>
                            <td>{{ $adjustment->end_date ? \Carbon\Carbon::parse($adjustment->end_date)->format('Y-m-d') : '-' }}</td>
                            <td>
                                @if($adjustment->status == 'active')
                                    <span class="badge bg-success">@lang('Active')</span>
                                @else
                                    <span class="badge bg-danger">@lang('Inactive')</span>
                                @endif
                            </td>
                            <td>
                                <a href="" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#edit_price-{{ $adjustment->id }}">
                                    <i class="fa fa-edit">@lang('Edit')</i>
                                </a>
                                <form
                                    action="{{ route('price_adjustments.destroy', ['price_adjustment' => $adjustment->id]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn">
                                        <i class="fa fa-trash">@lang('Delete')</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @include('backends.price_adjustment.edit')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>s
@endsection
