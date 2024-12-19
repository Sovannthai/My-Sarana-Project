<!-- Modal -->
<div class="modal fade" id="addExpenseTransactionModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addExpenseTransactionLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseTransactionLabel">@lang('Create Expense Transaction')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expense_transactions.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="category_id">@lang('Category')</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">@lang('Select Category')</option>
                                @foreach ($expenseCategories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
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
                                placeholder="@lang('Enter transaction amount')">
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-2">
                            <label for="date">@lang('Date')</label>
                            <input type="date" name="date" id="date"
                                class="form-control @error('date') is-invalid @enderror">
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6 mt-2">
                            <label for="note">@lang('Note')</label>
                            <textarea name="note" id="note" class="form-control" placeholder="@lang('Enter optional note')"></textarea>
                            @error('note')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mt-2">
                            <button type="submit"
                                class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                <i class="fas fa-save"></i> @lang('Submit')
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
