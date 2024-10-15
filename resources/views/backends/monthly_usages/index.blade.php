@extends('backends.master')
@section('title', 'Monthly Usages')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Monthly Usages</label>
            <a href="{{ route('monthly_usages.create') }}" class="btn btn-primary float-right text-uppercase btn-sm">
                <i class="fas fa-plus"></i> @lang('Add Monthly Usage')
            </a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead>
                    <tr>
                        <th>@lang('Room')</th>
                        <th>@lang('Utility Type')</th>
                        <th>@lang('Month')</th>
                        <th>@lang('Year')</th>
                        <th>@lang('Usage')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($monthlyUsages as $usage)
                        <tr>
                            <td>{{ $usage->room->room_number }}</td>
                            <td>{{ $usage->utilityType->type }}</td>
                            <td>{{ $usage->month }}</td>
                            <td>{{ $usage->year }}</td>
                            <td>{{ $usage->usage }}</td>
                            <td>
                                <a href="{{ route('monthly_usages.edit', $usage->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-edit"></i> @lang('Edit')
                                </a>
                                <form action="{{ route('monthly_usages.destroy', $usage->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn">
                                        <i class="fa fa-trash"></i> @lang('Delete')
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
