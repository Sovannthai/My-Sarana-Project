<div class="dropdown">
    <button class="btn btn-primary btn-sm dropdown-toggle" type="button"
        data-bs-toggle="dropdown" aria-expanded="false">
        Action
    </button>
    <ul class="dropdown-menu" style="font-size: 16px">
        <!-- View Invoice -->
        <li class="mb-1">
            <a class="dropdown-item btn-modal btn-add" href="#"
                data-href="{{ route('payment-details.show', ['id' => $payment->userContract->user->id]) }}"
                data-toggle="modal" data-container=".createPaymentModal">
                <i class="fas fa-eye"></i> @lang('View Invoice')
            </a>
        </li>

        <!-- Utilities Payment -->
        @if ($payment->type == 'advance')
            <li class="mb-1">
                <a class="dropdown-item btn-modal btn-add" href="#"
                    data-bs-toggle="modal" data-bs-target="#utility_list_modal-{{ $payment->id }}">
                    <i class="fas fa-file-alt"></i> @lang('Utilities Payment')
                </a>
            </li>
        @endif

        <!-- Print Invoice -->
        <li class="mb-1">
            <a class="dropdown-item" href="#" onclick="printInvoice({{ $payment->userContract->user->id }})">
                <i class="fas fa-file-alt"></i> @lang('Print Invoice')
            </a>
        </li>

        <!-- Download Invoice -->
        <li class="mb-1">
            <a class="dropdown-item" href="{{ route('invoice.download', $payment->userContract->user->id) }}">
                <i class="fas fa-download"></i> @lang('Download Invoice')
            </a>
        </li>

        <!-- Send Invoice to Telegram -->
        @if ($payment->userContract->user->telegram_id != null)
            <li class="mb-1">
                <form action="{{ route('send-invoice', ['userId' => $payment->userContract->user->id]) }}"
                    method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="dropdown-item">
                        <i class="fas fa-paper-plane"></i> @lang('Send Invoice To Telegram')
                    </button>
                </form>
            </li>
        @endif

        <!-- Delete Payment -->
        <li>
            <form action="{{ route('payments.destroy', ['payment' => $payment->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="dropdown-item text-danger btn delete-btn">
                    <i class="fa fa-trash"> @lang('Delete')</i>
                </button>
            </form>
        </li>
    </ul>
</div>
