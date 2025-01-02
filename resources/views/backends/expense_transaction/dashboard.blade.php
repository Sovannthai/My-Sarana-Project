@extends('backends.master')
@section('title', __('Expense Dashboard'))

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

    .dashboard-card {
        margin-bottom: 1.5rem;
    }
    .btn-active {
        background-color: transparent !important;
        color: rgb(0, 0, 0);
        border-color: #3295ff !important;
    }
    .hide {
        display: none;
    }
</style>
    <form method="GET" action="{{ route('expense_dashboard.dashboard') }}">
        <div class="btn-group mb-4 hide" role="group">
            <button type="submit" class="btn btn-primary {{ request('filter') === 'this_month' ? 'btn-active' : '' }}" name="filter" value="this_month">This Month</button>
            {{-- <button type="submit" class="btn btn-primary {{ request('filter') === 'last_month' ? 'btn-active' : '' }}" name="filter" value="last_month">Last Month</button> --}}
            <button type="submit" class="btn btn-primary {{ request('filter') === 'this_year' ? 'btn-active' : '' }}" name="filter" value="this_year">This Year</button>
            <button type="submit" class="btn btn-primary {{ request('filter') === 'last_year' ? 'btn-active' : '' }}" name="filter" value="last_year">Last Year</button>
        </div>
    </form>
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <label class="card-title font-weight-bold mb-1 text-uppercase">@lang('Expense Dashboard')</label>
    </div>
    <div class="card-body card-container">
        <div class="row">
            <!-- Total Transactions Card -->
            <div class="col-sm-6 col-md-4 dashboard-card">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-info bubble-shadow-small">
                                    <i class="fas fa-coins"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark">@lang('Total Income')</p>
                                    <h4 class="card-title">{{ $totalIncome }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Expense Amount Card -->
            <div class="col-sm-6 col-md-4 dashboard-card">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-success bubble-shadow-small">
                                    <i class="fas fa-wallet"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark">@lang('Total Expenses')</p>
                                    <h4 class="card-title">${{ number_format($totalExpense, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Categories Card -->
            <div class="col-sm-6 col-md-4 dashboard-card">
                <div class="card card-stats card-round">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-icon">
                                <div class="icon-big text-center icon-warning bubble-shadow-small">
                                    <i class="fas fa-list-alt"></i>
                                </div>
                            </div>
                            <div class="col col-stats ms-3 ms-sm-0">
                                <div class="numbers">
                                    <p class="card-category text-dark">Balacne</p>
                                    <h4 class="card-title">${{ number_format($balance, 2) }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 dashboard-card">
                <div class="card">
                    <!-- Insert the Polar Area Chart -->
                    <div class="mt-3 mb-3">
                        <canvas id="chart_expense"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 dashboard-card">
                <div class="card">
                    <div class="mt-3 mb-3">
                        <canvas id="chart_income"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 dashboard-card">
                <div class="card shadow-sm">
                    <div class="card-header bg-gradient-primary text-white d-flex align-items-center justify-content-between">
                        <h4 class="card-title mb-0">Recent Transactions</h4>
                        <i class="fas fa-exchange-alt fs-5"></i>
                    </div>
                    <div class="card-body p-3">
                        @if ($recentTransactions->isEmpty())
                            <p class="text-muted text-center">No recent transactions available.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($recentTransactions as $transaction)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong class="text-primary">{{ $transaction->category->title ?? 'Uncategorized' }}</strong>
                                            <span class="text-muted d-block small">({{ $transaction->date }})</span>
                                        </div>
                                        <span class="badge bg-success text-white fs-6">
                                            ${{ number_format($transaction->amount, 2) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="card-footer text-end bg-light">
                        <a href="{{ route('expense_transactions.index') }}" class="btn btn-link text-primary">View All</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('chart_expense').getContext('2d');

        const labels = @json($chartLabels);
        const dataValues = @json($chartValues);

        const data = {
            labels: labels,
            datasets: [{
                data: dataValues,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(255, 159, 64, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        };

        const options = {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    enabled: true
                }
            },
            scales: {
                r: {
                    ticks: {
                        stepSize: 100
                    }
                }
            }
        };

        new Chart(ctx, {
            type: 'polarArea',
            data: data,
            options: options
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctxIncome = document.getElementById('chart_income').getContext('2d');

        const months = @json($months);
        const monthlyRoomValues = @json($monthlyRoomValues);
        const monthlyUtilityValues = @json($monthlyUtilityValues);

        new Chart(ctxIncome, {
            type: 'bar',
            data: {
                labels: months,
                datasets: [{
                    label: 'Room Income',
                    data: monthlyRoomValues,
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',  // Light teal for Room Income
                    borderColor: 'rgba(75, 192, 192, 1)',      // Dark teal border for Room Income
                    borderWidth: 1
                },
                {
                    label: 'Utilities Income',
                    data: monthlyUtilityValues,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)',  // Light red for Utilities Income
                    borderColor: 'rgba(255, 99, 132, 1)',      // Dark red border for Utilities Income
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount ($)'
                        }
                    }
                }
            }
        });
    });
</script>

