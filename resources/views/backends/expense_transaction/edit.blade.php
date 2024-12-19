<!-- Modal -->
<div class="modal fade" id="editExpenseTransaction-{{ $transaction->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editExpenseTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseTransactionLabel">@lang('Update Expense Transaction')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expense_transactions.update', ['expense_transaction' => $transaction->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="category_id">@lang('Category')</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                @foreach ($expenseCategories as $category)
                                    <option value="{{ $category->id }}" {{ $transaction->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="amount">@lang('Amount')</label>
                            <input type="number" name="amount" id="amount"
                                class="form-control @error('amount') is-invalid @enderror"
                                value="{{ $transaction->amount }}" placeholder="@lang('Enter transaction amount')">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-2">
                            <label for="date">@lang('Date')</label>
                            <input type="date" name="date" id="date"
                                class="form-control @error('date') is-invalid @enderror" value="{{ $transaction->date }}">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-2">
                            <label for="note">@lang('Note')</label>
                            <textarea name="note" id="note" class="form-control" placeholder="@lang('Enter optional note')">{{ $transaction->note }}</textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <button type="submit"
                                class="btn btn-outline-primary btn-sm text-uppercase float-right ml-2">
                                <i class="fas fa-save"></i> @lang('Update')
                            </button>
                            <a href="" type="button" data-bs-dismiss="modal"
                                class="float-right btn btn-dark btn-sm">
                                @lang('Cancel')
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
