<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Create User Contract</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('user_contracts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="user_id">@lang('User')</label>
                            <select name="user_id" class="form-control select2">
                                @foreach ($availableUsers as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="room_id">@lang('Room')</label>
                            <select name="room_id" class="form-control select2">
                                @foreach ($availableRooms as $room)
                                    <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="start_date">@lang('Start Date')</label>
                            <input type="date" name="start_date" class="form-control" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="end_date">@lang('End Date')</label>
                            <input type="date" name="end_date" class="form-control" required>
                        </div>
                        {{-- <div class="col-sm-6">
                            <label for="monthly_rent">@lang('Monthly Rent')</label>
                            <input type="number" name="monthly_rent" class="form-control" min="0" step="0.01" required>
                        </div> --}}
                        <div class="col-sm-6">
                            <label for="contract_pdf">@lang('Contract PDF')</label>
                            <input type="file" name="contract_pdf" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right ml-2">
                            <i class="fas fa-save"></i> @lang('Submit')
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
