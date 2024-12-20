@extends('backends.master')
@section('title','Home')
@section('contents')
@section('content-header', 'Welcome, ' . auth()->user()->name)
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
        transform: 5s;
        transform: translateY(-15px);
    }

    .card-chart {
        /* border: 2px solid #2e3ff6 !important; */
        position: relative;
        border: 2px solid transparent;
        background-image: linear-gradient(white, white),
            linear-gradient(45deg, slateblue, #ff75c3, #0d9bb3);
        background-origin: border-box;
        background-clip: padding-box, border-box;
        border-radius: 10px;
        padding: 1rem;
    }
</style>
@if (auth()->user()->can('view dashborad'))
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
        <h3 class="fw-bold mb-3">@yield('content-header')</h3>
    </div>
    <div class="row">
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('users.index') }}">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-primary bubble-shadow-small">
                                    <i class="fas fa-users"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark">@lang('Total Renter')</p>
                                    <h4 class="card-title">{{ $total_renters }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('rooms.index') }}">
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
                                    <p class="card-category text-dark">@lang('Total Room')</p>
                                    <h4 class="card-title">{{ $total_rooms }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="#">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark">@lang('Total Amount')</p>
                                    <h4 class="card-title">$ 1,345</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('user-request.index') }}">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                    <i class="fa fa-comments"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark">@lang('Total Request')</p>
                                    <h4 class="card-title">{{ $unreadMessagesCount }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-chart">
                <div class="card-header" data-toggle="collapse" data-target="#barChartCard">
                    <div class="card-title text-uppercase">@lang('Total Amount Current Year')</div>
                </div>
                <div id="barChartCard" class="collapse show">
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var barChart = document.getElementById('barChart').getContext('2d');
    var myBarChart = new Chart(barChart, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            datasets: [{
                label: "Sales",
                backgroundColor: 'rgb(23, 125, 255)',
                borderColor: 'rgb(23, 125, 255)',
                data: [3, 2, 9, 5, 4, 6, 4, 6, 7, 8, 7, 4],
            }],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            },
        }
    });
</script>
@endsection
