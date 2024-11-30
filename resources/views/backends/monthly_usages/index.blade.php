@extends('backends.master')
@section('title', 'Monthly Usages')

@section('contents')

<style>
    .card-stats {
        position: relative;
        border: 2px solid transparent;
        background-image: linear-gradient(white, white), linear-gradient(45deg, slateblue, #ff75c3, #0d9bb3);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        transition: transform 0.3s ease-in-out;
        border-radius: 10px;
        overflow: hidden;
    }

    .card-stats:hover {
        transform: translateY(-10px);
    }

    .card-container {
        padding: 2rem;
    }

    .room-card {
        margin-bottom: 1.5rem;
    }
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <label class="card-title font-weight-bold mb-1 text-uppercase">ROOMS</label>
    </div>
    <div class="card-body card-container">
        <div class="row">
            @foreach ($rooms as $room)
                <div class="col-sm-6 col-md-3 room-card">
                    <a href="{{ route('monthly_usages.show', $room->id) }}">
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
                                            <h4 class="card-title">Room: {{ $room->room_number ?? 'Unnamed Room' }}</h4>
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
</div>
@endsection
