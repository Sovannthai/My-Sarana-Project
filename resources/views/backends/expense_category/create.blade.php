<!-- Modal -->
<div class="modal fade" id="addExpenseCategoryModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="addExpenseCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addExpenseCategoryLabel">@lang('Create Expense Category')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('expense_categories.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="title">@lang('Category Title')</label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror"
                                placeholder="@lang('Enter category title')">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="icon">@lang('Icon')</label>
                            <input type="text" name="icon" id="icon" class="form-control"
                                placeholder="@lang('Enter icon class (optional)')">
                            @error('icon')
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
