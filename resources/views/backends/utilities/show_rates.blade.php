@extends('backends.master')

@section('title', __('Utility Rates for') . ' ' . $utilityType->type)

@section('contents')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title text-uppercase">{{ $utilityType->type }}: @lang('Rates')</h5>
            <div class="card-tools">
                <a href="{{ route('utilities.createRate', $utilityType->id) }}" class="btn btn-outline-primary btn-sm">
                    <i class="fa fa-plus"></i> @lang('Add Rate')
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-secondary">
                    <tr>
                        <th>@lang('Rate Per Unit')</th>
                        <th>@lang('Is Active')</th>
                        <th>@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($utilityType->utilityRates as $utilityRate)
                        <tr>
                            <td>{{ $utilityRate->rate_per_unit }}</td>
                            <td>
                                {{ $utilityRate->is_active ? __('Yes') : __('No') }}
                            </td>
                            <td>
                                <a href="{{ route('utilities.editRate', $utilityRate->id) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-edit"></i> @lang('Edit')
                                </a>
                                &nbsp;&nbsp;
                                <form action="{{ route('utilities.destroyRate', $utilityRate->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
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
