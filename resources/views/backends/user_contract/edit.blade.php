<div class="modal fade" id="edit_contract-{{ $contract->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="editContractLabel-{{ $contract->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editContractLabel-{{ $contract->id }}">Edit User Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user_contracts.update', ['user_contract' => $contract->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <!-- User -->
                        <div class="col-sm-6">
                            <label for="user_id">@lang('User')</label>
                            <select name="user_id" class="form-control select2" required>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ $contract->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Room -->
                        <div class="col-sm-6">
                            <label for="room_id">@lang('Room')</label>
                            <select name="room_id" class="form-control select2" required>
                                @foreach ($rooms as $room)
                                    <option value="{{ $room->id }}"
                                        {{ $contract->room_id == $room->id ? 'selected' : '' }}>
                                        {{ $room->room_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Start Date -->
                        <div class="col-sm-6">
                            <label for="start_date">@lang('Start Date')</label>
                            <input type="date" name="start_date" class="form-control"
                                value="{{ $contract->start_date }}" required>
                        </div>

                        <!-- End Date -->
                        <div class="col-sm-6">
                            <label for="end_date">@lang('End Date')</label>
                            <input type="date" name="end_date" class="form-control"
                                value="{{ $contract->end_date }}" required>
                        </div>

                        <!-- Monthly Rent -->
                        <div class="col-sm-6">
                            <label for="monthly_rent">@lang('Monthly Rent')</label>
                            <input type="number" name="monthly_rent" class="form-control" min="0" step="0.01"
                                value="{{ $contract->monthly_rent }}" required>
                        </div>

                        <!-- Contract PDF -->
                        <div class="col-sm-6">
                            <label for="contract_pdf">@lang('Contract PDF')</label>
                            <input type="file" name="contract_pdf" class="form-control" accept=".pdf">
                            <small class="form-text text-muted">
                                Leave this blank if you don't want to update the PDF file.
                            </small>
                        </div>

                        <!-- Current PDF -->
                        @if ($contract->contract_pdf)
                            <div class="col-12 mt-2">
                                <p>@lang('Current Contract PDF'):</p>
                                <a href="{{ asset('storage/' . $contract->contract_pdf) }}" target="_blank"
                                    class="btn btn-sm btn-outline-primary">
                                    @lang('View PDF')
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Submit and Cancel Buttons -->
                    <div class="mt-2">
                        <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right">
                            <i class="fas fa-save"></i> @lang('Update')
                        </button>
                        <a href="" type="button" data-bs-dismiss="modal"
                            class="float-right btn btn-dark btn-sm">
                            @lang('Cancel')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
