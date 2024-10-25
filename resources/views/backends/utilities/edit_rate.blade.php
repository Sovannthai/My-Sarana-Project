<!-- Edit Utility Rate Modal -->
<div class="modal fade" id="editUtilityModal" tabindex="-1" aria-labelledby="editUtilityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUtilityModalLabel">@lang('Edit Utility Rate')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editUtilityForm" method="POST" action="{{ route('utilities.updateRate', ':id') }}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editRateId" name="id">
                    <div class="mb-3">
                        <label for="editRatePerUnit" class="form-label">@lang('Rate per Unit')</label>
                        <input type="number" class="form-control" id="editRatePerUnit" name="rate_per_unit" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark btn-sm text-uppercase" data-bs-dismiss="modal">@lang('Close')</button>
                    <button type="submit" class="float-right btn btn-primary btn-sm"><i class="fas fa-save"></i> @lang('Submit')</button>
                </div>
            </form>
        </div>
    </div>
</div>
