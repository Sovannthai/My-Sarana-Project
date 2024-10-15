@extends('backends.master')
@section('title', 'Utilities Management')
@section('contents')
    <div class="card">
        <div class="card-header">
            <label class="card-title font-weight-bold mb-1 text-uppercase">Utilities Management</label>
            <a href="{{ route('utilities.createType') }}" class="btn btn-primary float-right text-uppercase btn-sm">
                <i class="fas fa-plus"> @lang('Add Utility Type')</i>
            </a>
        </div>
        <div class="card-body">
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('Utility Type')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($utilityTypes->isNotEmpty())
                        @foreach ($utilityTypes as $utilityType)
                            <tr>
                                <td style="background-color: #b3e5fc;">
                                    {{ $utilityType->type }}
                                </td>
                                <td style="background-color: #b3e5fc;">
                                    <a href="{{ route('utilities.editType', $utilityType->id) }}"
                                       class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                       title="@lang('Edit Type')">
                                        <i class="fa fa-edit"></i> @lang('Edit')
                                    </a>
                                    &nbsp;&nbsp;
                                    <a href="{{ route('utilities.createRate', $utilityType->id) }}"
                                       class="btn btn-outline-success btn-sm" data-toggle="tooltip"
                                       title="@lang('Add Rate')">
                                        <i class="fas fa-plus"></i> @lang('Add Rate')
                                    </a>
                                    &nbsp;&nbsp;
                                    <form action="{{ route('utilities.destroyType', $utilityType->id) }}"
                                          method="POST" class="d-inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                                title="@lang('Delete Type')">
                                            <i class="fa fa-trash"></i> @lang('Delete')
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <table class="table table-bordered">
                                        <thead class="table-secondary">
                                            <tr>
                                                <th>@lang('Rate Per Unit')</th>
                                                <th>@lang('Actions')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($utilityType->utilityRates as $utilityRate)
                                                <tr>
                                                    <td>{{ $utilityRate->rate_per_unit }}</td>
                                                    <td>
                                                        <a href="{{ route('utilities.editRate', $utilityRate->id) }}"
                                                           class="btn btn-outline-primary btn-sm" data-toggle="tooltip"
                                                           title="@lang('Edit Rate')">
                                                            <i class="fa fa-edit"></i> @lang('Edit')
                                                        </a>
                                                        &nbsp;&nbsp;
                                                        <form action="{{ route('utilities.destroyRate', $utilityRate->id) }}"
                                                              method="POST" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                                                    title="@lang('Delete Rate')">
                                                                <i class="fa fa-trash"></i> @lang('Delete')
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="2" class="text-center">@lang('No utility types found.')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
