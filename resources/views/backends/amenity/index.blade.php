@extends('backends.master')
@section('title', 'Amenities')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Amenities</label>
            <a href="{{ route('amenities.create') }}" class="btn btn-primary float-right text-uppercase btn-sm"
                data-value="view">
                <i class="fas fa-plus"> @lang('Add')</i></a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Description')</th>
                        <th>@lang('Additional Price')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>

                <tbody>
                    @if ($amenities)
                        @foreach ($amenities as $amenity)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $amenity->name }}</td>
                                <td>{{ $amenity->description ?? '-' }}</td>
                                <td>{{ number_format($amenity->additional_price, 2) }}</td>
                                <td>
                                    <a href="{{ route('amenities.edit', ['amenity' => $amenity->id]) }}"
                                        class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                        title="@lang('Edit')"><i
                                            class="fa fa-edit ambitious-padding-btn text-uppercase">
                                            @lang('Edit')</i></a>&nbsp;&nbsp;
                                    <form id="deleteForm"
                                        action="{{ route('amenities.destroy', ['amenity' => $amenity->id]) }}"
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
                </tbody>
            </table>
        </div>
    </div>
@endsection
