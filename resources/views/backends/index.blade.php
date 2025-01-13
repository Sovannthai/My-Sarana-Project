@extends('backends.master')
@section('title',__('Home'))
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

    .btn-active {
        background-color: transparent !important;
        color: rgb(0, 0, 0);
        border-color: #3295ff !important;
    }
</style>
@if (auth()->user()->can('view dashborad'))
<div class="d-flex justify-content-between align-items-center flex-wrap pt-2 pb-4">
    <h3 class="fw-bold mb-3">@yield('content-header')</h3>
    <form method="GET" action="{{ route('home') }}">
        <div class="btn-group" role="group" aria-label="Basic example">
            <button type="submit" class="btn btn-primary {{ request('filter') === 'this_month' ? 'btn-active' : '' }}"
                name="filter" value="this_month">
                @lang('This Month')
            </button>
            <button type="submit" class="btn btn-primary {{ request('filter') === 'last_month' ? 'btn-active' : '' }}"
                name="filter" value="last_month">
                @lang('Last Month')
            </button>
            <button type="submit" class="btn btn-primary {{ request('filter') === 'this_year' ? 'btn-active' : '' }}"
                name="filter" value="this_year">
                @lang('This Year')
            </button>
        </div>
    </form>

</div>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <a href="{{ route('payments.index') }}">
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
                                <h4 class="card-title">$ {{ number_format($room_income_amount,2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-md-3">
        <a href="{{ route('payments.index') }}">
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
                                <p class="card-category text-dark">@lang('Total Utility Amount')</p>
                                <h4 class="card-title">$ {{ number_format($total_utility_amount,2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-md-3">
        <a href="{{ route('payments.index') }}">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category text-dark">@lang('Total Due Amount')</p>
                                <h4 class="card-title">$ {{ number_format($total_due_amount,2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <div class="col-sm-6 col-md-3">
        <a href="{{ route('expense_transactions.index') }}">
            <div class="card card-stats card-round">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                                <i class="fas fa-hand-holding-usd"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category text-dark">@lang('Total Expense')</p>
                                <h4 class="card-title">$ {{ number_format($total_expenses,2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>

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
                                <p class="card-category text-dark">@lang('Available Room')</p>
                                <h4 class="card-title">{{ $total_avilable_rooms }}</h4>
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
                                <p class="card-category text-dark">@lang('Occupied Room')</p>
                                <h4 class="card-title">{{ $total_occupied_rooms }}</h4>
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
                                <i class="fas fa-wrench"></i>
                            </div>
                        </div>
                        <div class="col col-stats ms-3 ms-sm-0">
                            <div class="numbers">
                                <p class="card-category text-dark nowrap">@lang('Maintenancec Room')</p>
                                <h4 class="card-title">{{ $total_maintenance_rooms }}</h4>
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
    $(document).ready(function() {
        var monthlyTotals = @json(array_values($monthlyTotals));

        var barChart = document.getElementById('barChart').getContext('2d');
        var myBarChart = new Chart(barChart, {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Sales",
                    backgroundColor: 'rgb(23, 125, 255)',
                    borderColor: 'rgb(23, 125, 255)',
                    data: monthlyTotals,
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
    });
</script>
@endsection
