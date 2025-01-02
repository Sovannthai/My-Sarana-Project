@extends('backends.master')
@section('title', __('Monthly Usages'))

@section('contents')
<style>
    .card-stats {
        position: relative;
        border: 2px solid transparent;
        background-image: linear-gradient(white, white),
            linear-gradient(45deg, slateblue, #ff75c3, #0d9bb3);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        transition: 0.5s;
    }

    .card-stats:hover {
        transform: translateY(-15px);
    }
</style>

<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Rooms')</label>
        <a href="{{ route('rooms.create') }}" class="btn btn-primary float-right text-uppercase btn-sm">
            <i class="fas fa-plus"> @lang('Add Room')</i>
        </a>
    </div>
    <div class="row">
        @foreach ($rooms as $room)
            <div class="col-sm-6 col-md-3 mb-4">
                <a href="{{ route('rooms.detail', ['id' => $room->id]) }}">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-door-closed"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category text-dark">{{ $room->room_number }}</p>
                                        <h4 class="card-title">{{ $room->name ?? 'Unnamed Room' }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
