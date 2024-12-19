@extends('backends.master')
@section('title', 'Expense Dashboard')

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
</style>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <label class="card-title font-weight-bold mb-1 text-uppercase">Expense Dashboard</label>
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
                                    <p class="card-category text-dark">Total Transactions</p>
                                    <h4 class="card-title">{{ $totalTransactions }}</h4>
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
                                    <p class="card-category text-dark">Total Expenses</p>
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
                                    <p class="card-category text-dark">Total Categories</p>
                                    <h4 class="card-title">{{ $totalCategories }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Transactions Card -->
            <div class="col-12 dashboard-card">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Recent Transactions</h4>
                    </div>
                    <div class="card-body">
                        <ul>
                            @foreach ($recentTransactions as $transaction)
                                <li>
                                    <strong>{{ $transaction->category->title ?? 'Uncategorized' }}</strong> - ${{ number_format($transaction->amount, 2) }} ({{ $transaction->date }})
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
