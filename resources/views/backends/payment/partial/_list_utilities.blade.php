@foreach ($payment_using_for_modals as $payment)
<div class="modal fade utility_list_modal" id="utility_list_modal-{{ $payment->id }}" data-bs-backdrop="static"
    data-bs-keyboard="false" tabindex="-1" aria-labelledby="utility_list_modalLabel" aria-hidden="true">
    {{-- Modal Utility List --}}
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang('Utility Payment')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="float-right mb-3">
                    <a href="#" class="btn btn-primary btn-sm btn-modal btn-add"
                        data-href="{{ route('createUitilityPayment', ['id' => $payment->id]) }}" data-toggle="modal"
                        data-container=".createPaymentModal">@lang('Add Payment')</a>
                </div>
                <table id="basic-datatables-{{ $payment->id }}" class="table table-bordered"
                    style="width:100%">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">@lang('Utility')</th>
                            <th scope="col">@lang('Usage')</th>
                            <th scope="col">@lang('Rate')($)</th>
                            <th scope="col">@lang('Subtotal')</th>
                            <th scope="col">@lang('Total Amount')</th>
                            <th scope="col">@lang('Month Paid')</th>
                            <th scope="col">@lang('Year Paid')</th>
                            <th scope="col">@lang('Action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $months = [
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                        ];
                        $groupedUtilities = $payment->paymentutilities->groupBy(function ($utility) {
                        return $utility->month_paid . '-' . $utility->year_paid;
                        });
                        @endphp
                        @forelse ($groupedUtilities as $key => $utilities)
                        {{-- @dd($utilities); --}}
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>
                                <ul>
                                    @foreach ($utilities as $utility)
                                    <li>{{ $utility->utility->type }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($utilities as $utility)
                                    <li>{{ number_format($utility->usage, 2) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($utilities as $utility)
                                    <li>{{ number_format($utility->rate_per_unit, 2) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($utilities as $utility)
                                    <li>$ {{ number_format($utility->total_amount, 2) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <?php
                                $totalAmount = 0;
                                foreach ($utilities as $utility) {
                                    $totalAmount += $utility->total_amount;
                                }
                            ?>
                            <td>$ {{ number_format($totalAmount, 2) }}</li>
                            </td>
                            <td>{{ $months[$utilities->first()->month_paid] ?? '-' }}</td>
                            <td>{{ $utilities->first()->year_paid }}</td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        @lang('Action')
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li class="mb-1">
                                            <a class="dropdown-item"
                                                href="{{ route('utility-invoice.download', @$payment->userContract->user->id) }}">
                                                <i class="fas fa-download"></i> @lang('Download Invoice')
                                            </a>
                                        </li>
                                        <li class="mb-1">
                                            <a class="dropdown-item" href="#">
                                                <i class="fas fa-file-alt"></i> @lang('Print Invoice')
                                            </a>
                                        </li>
                                        <li>
                                            <form
                                                action="{{ route('delete-advance-utility-payment', ['id'=> $payment->id]) }}"
                                                method="POST" class="delete-utility-form d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button"
                                                    class="btn btn-outline-danger delete-button text-uppercase dropdown-item"
                                                    data-payment-id="{{ $payment->id }}">
                                                    <i class="fa fa-trash"> @lang('Delete')</i>
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">@lang('No data available')</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on("click", ".btn-modal", function(e) {
            e.preventDefault();
            $(".modal.show").modal("hide");

            var container = $(this).data("container");
            var href = $(this).data("href");
            setTimeout(function() {
                $.ajax({
                    url: href,
                    dataType: "html",
                    success: function(result) {
                        $(container).html(result).modal("show");
                    },
                    error: function(xhr) {
                        console.error("Error loading modal content:", xhr);
                    },
                });
            }, 300);
        });
</script>
<script>
    $(document).ready(function() {
        $('.delete-button').on('click', function() {
            let paymentId = $(this).data('payment-id');
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('delete-advance-utility-payment', '') }}/" + paymentId,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            _method: "DELETE"
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                toastr.success(response.message);
                                $(`button[data-payment-id="${paymentId}"]`).closest('tr').remove();
                            } else {
                                toastr.error(response.message);
                            }
                        },
                        error: function(xhr) {
                            toastr.error('Something went wrong. Please try again.');
                        }
                    });
                }
            });
        });
    });
</script>
@endforeach
