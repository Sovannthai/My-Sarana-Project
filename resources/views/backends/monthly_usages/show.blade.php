@extends('backends.master')
@section('title', 'Monthly Usage Records')
@section('contents')

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <label class="card-title font-weight-bold text-uppercase">
                @lang('Monthly Usage Records')
            </label>
            <a href="#" class="btn btn-primary text-uppercase btn-sm" data-bs-toggle="modal"
                data-bs-target="#createMonthlyUsageModal">
                <i class="fas fa-plus"></i> @lang('Add Usage')
            </a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('No.')</th>
                        <th>@lang('Utility Type')</th>
                        <th>@lang('Usage')</th>
                        <th>@lang('Month')</th>
                        <th>@lang('Year')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($monthlyUsages as $usage)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $usage->utilityType ? $usage->utilityType->type : __('Unknown Utility Type') }}</td>
                            <td>{{ $usage->usage }}</td>
                            <td>{{ date('F', mktime(0, 0, 0, $usage->month, 1)) }}</td>
                            <td>{{ $usage->year }}</td>
                            <td>
                                <a href="#" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editMonthlyUsageModal-{{ $usage->id }}">
                                    <i class="fas fa-edit"></i> @lang('Edit')
                                </a>&nbsp;&nbsp;

                                <form id="deleteForm"
                                    action="{{ route('monthly_usages.destroy', ['monthly_usage' => $usage->id]) }}"
                                    method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                        title="@lang('Delete')">
                                        <i class="fa fa-trash ambitious-padding-btn text-uppercase">
                                            @lang('Delete')
                                        </i>
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">@lang('No Records Found')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @include('backends.monthly_usages.create')

    @foreach ($monthlyUsages as $usage)
        @include('backends.monthly_usages.edit', ['usage' => $usage])
    @endforeach

@endsection
