@extends('backends.master')
@section('title', 'Monthly Usage Records')
@section('contents')
    <style>
        .remove-utility {
            margin-top: 10px;
        }
    </style>
    <div class="back-btn">
        <a href="{{ route('monthly_usages.index') }}" class="float-left" data-value="veiw">
            <i class="fas fa-arrow-left"></i>&nbsp;&nbsp;
            Back To all Rooms
        </a><br>
    </div><br>
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
            <table id="basic-datatables" class="table table-bordered text-nowrap table-hover">
                <thead class="table-dark">
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
                            <td>
                                @if ($usage->utilityTypes->isNotEmpty())
                                    <ul>
                                        @foreach ($usage->utilityTypes as $utilityType)
                                            <li>{{ $utilityType->type }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>@lang('No Utility Types')</span>
                                @endif
                            </td>
                            <td>
                                @if ($usage->utilityTypes->isNotEmpty())
                                    <ul>
                                        @foreach ($usage->utilityTypes as $utility)
                                            <li>
                                                <span>{{ $utility->pivot->usage }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span>@lang('No Usage Data')</span>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Carbon::create()->month($usage->month)->format('F') }}</td>
                            <td>{{ $usage->year }}</td>
                            <td>
                                <a href="#" class="btn btn-outline-primary btn-sm text-uppercase"
                                    data-bs-toggle="modal" data-bs-target="#editMonthlyUsageModal-{{ $usage->id }}">
                                    <i class="fas fa-edit"> @lang('Edit')</i>
                                </a>

                                <form action="{{ route('monthly_usages.destroy', $usage->id) }}" method="POST"
                                    class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger delete-btn btn-sm text-uppercase">
                                        <i class="fa fa-trash"> @lang('Delete')</i>
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
    <script>
        $(document).ready(function() {
            let utilityIndex = 0;

            //append a utility row
            function appendUtilityRow(container, utilityTypes, index = null, utilityTypeId = '', usageValue = '') {
                const utilityOptions = `
                    @foreach ($utilityTypes as $utilityType)
                        <option value="{{ $utilityType->id }}" ${
                            utilityTypeId == '{{ $utilityType->id }}' ? 'selected' : ''
                        }>{{ $utilityType->type }}</option>
                    @endforeach
                `;

                const newUtilityRow = `
                    <div class="row utility-item mb-3">
                        <div class="col-sm-6">
                            <label class="form-label">@lang('Utility Type')</label>
                            <select name="utility_type_id[]" class="form-select" required>
                                ${utilityOptions}
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label">@lang('Usage')</label>
                            <input type="text" class="form-control usage-input" name="usage[]" value="${usageValue}" required>
                        </div>
                        <div class="col-sm-2 mt-4">
                            <button type="button" class="btn btn-danger btn-sm remove-utility">@lang('Remove')</button>
                        </div>
                    </div>
                `;
                container.append(newUtilityRow);
            }

            // Add utility row
            $(document).on('click', '#add-utility', function() {
                const parentModal = $(this).closest('.modal');
                const container = parentModal.find('#utility-container');
                utilityIndex++;
                appendUtilityRow(container, @json($utilityTypes), utilityIndex);
            });

            // Remove utility row
            $(document).on('click', '.remove-utility', function() {
                $(this).closest('.utility-item').remove();
            });

            $('.modal').on('show.bs.modal', function() {
                const parentModal = $(this);
                const container = parentModal.find('#utility-container');
                const utilities = container.data(
                'utilities');
                utilityIndex = utilities?.length || 0;

                if (utilities) {
                    container.empty();
                    utilities.forEach((utility, index) => {
                        appendUtilityRow(
                            container,
                            @json($utilityTypes),
                            index,
                            utility.utility_type_id,
                            utility.usage
                        );
                    });
                }
            });
        });
    </script>
@endsection
