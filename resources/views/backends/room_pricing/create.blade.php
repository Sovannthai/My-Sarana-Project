  <!-- Modal -->
  <div class="modal fade" id="create-pricing" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Add Pricing</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('room-prices.store') }}" method="POST">
                      @csrf
                      <div class="row">

                          <div class="col-sm-6">
                              <label for="room_id">@lang('Room')</label>
                              <select name="room_id" id="" class="form-control select2" required>
                                  @foreach ($rooms as $room)
                                      <option value="{{ $room->id }}" selected>{{ $room->room_number }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-sm-6">
                              <label for="base_price">@lang('Base Price')</label>
                              <input type="number" step="any" name="base_price" id="base_price" class="form-control" required>
                          </div>

                          <div class="col-sm-12 ">
                              <label for="effective_date">@lang('Effective Date')</label>
                              <input type="date" name="effective_date" id="effective_date" class="form-control" required>
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