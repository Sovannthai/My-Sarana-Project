@extends('backends.master')
@section('title', 'Amenities')
@section('contents')
<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">Amenities</label>
        @if(auth()->user()->can('create amenity'))
        <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            <i class="fas fa-plus"> @lang('Add')</i></a>
        @include('backends.amenity.create')
        @endif
    </div>
    <div class="card-body">
        <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
            <thead class="table-dark">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('Name')</th>
                    <th>@lang('Additional Price')<span style="font-size:15px;">({{ $currencySymbol }})</span></th>
                    <th>@lang('Status')</th>
                    <th>@lang('Actions')</th>
                </tr>
            </thead>

            <tbody>
                @if ($amenities)
                @foreach ($amenities as $amenity)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $amenity->name }}</td>
                    <td>{{ $currencySymbol }} {{ number_format($amenity->converted_price, 2) }}</td>
                    <td>
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input toggle-status"
                                id="customSwitches{{ $amenity->id }}" data-id="{{ $amenity->id }}" {{ $amenity->status
                            == '1' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customSwitches{{ $amenity->id }}"></label>
                        </div>
                    </td>

                    <td>
                        @if(auth()->user()->can('update amenity'))
                        <a href="" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('Edit')"
                            data-bs-toggle="modal" data-bs-target="#edit_amenity-{{ $amenity->id }}"><i
                                class="fa fa-edit ambitious-padding-btn text-uppercase">
                                @lang('Edit')</i></a>&nbsp;&nbsp;
                        @endif
                        @if(auth()->user()->can('delete amenity'))
                        <form id="deleteForm" action="{{ route('amenities.destroy', ['amenity' => $amenity->id]) }}"
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
                @include('backends.amenity.edit')
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
            $('.toggle-status').on('change', function() {
                var status = $(this).prop('checked');
                var id = $(this).data('id');

                $.ajax({
                    type: "POST",
                    url: "{{ route('amenity.update_status') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        id: id,
                        status: status
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success === 1) {
                            toastr.success(response.msg);
                        } else {
                            toastr.error(response.msg);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error("An error occurred: " + xhr.responseJSON?.msg || error);
                    }
                });
            });
        });
</script>

@endsection
