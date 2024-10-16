<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang('Add Utility Rate')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="utilityRateForm" action="#" method="POST">
                    @csrf <!-- Ensure CSRF token is included -->
                    <input type="hidden" name="utilityTypeId" value="" /> <!-- This will be dynamically set -->
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="rate_per_unit">@lang('Rate Per Unit')</label>
                            <input type="number" name="rate_per_unit" id="rate_per_unit" class="form-control"
                                placeholder="@lang('Enter rate per unit')" required>
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit"
                            class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                            <i class="fas fa-save"></i> @lang('Submit')
                        </button>
                        <button type="button" class="float-right btn btn-dark btn-sm" data-bs-dismiss="modal">
                            @lang('Cancel')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
