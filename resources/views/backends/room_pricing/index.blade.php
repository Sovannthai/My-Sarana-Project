@extends('backends.master')
@section('title', 'Rooms Pricing')
@section('contents')
    <div class="card">
        <h5 class=" ml-3 mt-2 mb-0 card-title">
            <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example"
                id="heading-example" class="d-block bg-success-header">
                <i class="fa fa-filter bg-success-header"></i>
                @lang('Filter')
            </a>
        </h5>
        <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
            <div class="mt-1 ml-3 mb-4">
                <div class="row">
                    <div class="col-sm-4">
                        <label for="room_id">@lang('Room')</label>
                        <select name="room_id" id="room_id" class="form-control select2">
                            <option value="">{{ __('All') }}</option>
                            @foreach ($rooms as $row)
                                <option value="{{ $row->id }}" {{ $row->id == request('room_id') ? 'selected' : '' }}>
                                    {{ $row->room_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold text-uppercase">Rooms Pricing</label>
            @if(auth()->user()->can('create roomprice'))
            <a href="" class="btn btn-primary float-right text-uppercase" data-bs-toggle="modal"
                data-bs-target="#create-pricing">
                <i class="fas fa-plus"> @lang('Add')</i></a>
            @include('backends.room_pricing.create')
            @endif
            <div class="search-row col-sm-4 float-lg-right">
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class=" form-control search-box" autocomplete="off" placeholder="@lang('Search...')">
            </div>
        </div>
        @include('backends.room_pricing._table_room_pricing')
    </div>
    <script>
        $(document).ready(function() {
            $(document).on('keyup', '.search-box', function(e) {
                var search = $(this).val();
                var room_id = $('#room_id').val();
                $.ajax({
                    type: "get",
                    url: window.location.href,
                    data: {
                        'search': search,
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.view) {
                            $('.table-wrap').replaceWith(response.view);
                        }
                    }
                });

            })
            $(document).on('change', '#room_id', function(e) {
                e.preventDefault();
                var room_id = $('#room_id').val();
                $.ajax({
                    type: "GET",
                    url: '{{ route('room-prices.index') }}',
                    data: {
                        'room_id': room_id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        if (response.view) {
                            $('.table-wrap').replaceWith(response.view);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
            $('#room_id').select2();
        });
    </script>
@endsection
