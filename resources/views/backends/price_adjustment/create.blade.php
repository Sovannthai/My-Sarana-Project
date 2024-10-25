  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Create Price</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('price_adjustments.store') }}" method="POST">
                      @csrf
                      <div class="row">
                          <div class="col-sm-6">
                              <label for="room_id">Room</label>
                              <select name="room_id" id="room_id" class="form-control select2">
                                  @foreach ($availableRooms as $room)
                                      <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-sm-6">
                              <label for="amount">Amount</label>
                              <input type="number" name="amount" id="amount" class="form-control" step="0.01">
                          </div>
                          <div class="col-sm-6">
                              <label for="startdate">Start Date</label>
                              <input type="date" name="startdate" id="startdate" class="form-control">
                          </div>
                          <div class="col-sm-6">
                              <label for="enddate">End Date</label>
                              <input type="date" name="enddate" id="enddate" class="form-control">
                          </div>
                          <div class="mt-2">
                              <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">Submit</button>
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
