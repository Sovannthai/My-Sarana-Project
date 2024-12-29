@extends('backends.master')
@section('title', 'User Contracts')
@section('contents')
<div class="card">
    <div class="card-header">
        <label class="card-title font-weight-bold mb-1 text-uppercase">User Contracts</label>
        @if(auth()->user()->can('create contract'))
        <a href="" class="btn btn-primary float-right text-uppercase btn-sm" data-value="view" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop">
            <i class="fas fa-plus"> @lang('Add')</i></a>
        @include('backends.user_contract.create')
        @endif
    </div>
    <div class="card-body">
        <table id="basic-datatables" class="table table-bordered text-nowrap table-hover table-responsive-lg">
            <thead class="table-dark">
                <tr>
                    <th>@lang('No.')</th>
                    <th>@lang('User')</th>
                    <th>@lang('Room')</th>
                    <th>@lang('Start Date')</th>
                    <th>@lang('End Date')</th>
                    <th>@lang('Monthly Rent')</th>
                    <th>@lang('Contract PDF')</th>
                    <th>@lang('Actions')</th>
                </tr>
            </thead>

            <tbody>
                @if ($userContracts)
                @foreach ($userContracts as $contract)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $contract->user->name }}</td>
                    <td>{{ $contract->room->room_number }}</td>
                    <td>{{ $contract->start_date }}</td>
                    <td>{{ $contract->end_date ?? '-' }}</td>
                    <td>{{ $currencySymbol }} {{ number_format($contract->monthly_rent, 2) }}</td>
                    <td>
                        @if ($contract->contract_pdf)
                        @php
                        $fileExtension = pathinfo($contract->contract_pdf, PATHINFO_EXTENSION);
                        @endphp
                        @if (strtolower($fileExtension) === 'pdf')
                        <a href="{{ asset($contract->contract_pdf) }}" target="_blank" class="btn btn-info btn-sm">
                            @lang('View PDF')
                        </a>
                        @else
                        <span>
                            <a class="example-image-link"
                                href="{{ asset('uploads/all_photo/' . $contract->contract_pdf) }}"
                                data-lightbox="lightbox-{{ $contract->id }}">
                                <img class="example-image image-thumbnail"
                                    src="{{ asset('uploads/all_photo/' . $contract->contract_pdf) }}" alt="profile"
                                    width="50px" height="50px" style="cursor:pointer" />
                            </a>
                        </span>
                        @endif
                        @else
                        @lang('No File')
                        @endif
                    </td>
                    <td>
                        @if(auth()->user()->can('update contract'))
                        <a href="" class="btn btn-outline-primary btn-sm" data-toggle="tooltip" title="@lang('Edit')"
                            data-bs-toggle="modal" data-bs-target="#edit_contract-{{ $contract->id }}"><i
                                class="fa fa-edit ambitious-padding-btn text-uppercase">
                                @lang('Edit')</i></a>&nbsp;&nbsp;
                        @endif
                        @if(auth()->user()->can('delete contract'))
                        <form id="deleteForm"
                            action="{{ route('user_contracts.destroy', ['user_contract' => $contract->id]) }}"
                            method="POST" class="d-inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-outline-danger btn-sm delete-btn"
                                title="@lang('Delete')">
                                <i class="fa fa-trash ambitious-padding-btn text-uppercase">
                                    @lang('Delete')</i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @include('backends.user_contract.edit')
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
