  <!-- Modal -->
  <div class="modal fade" id="edit_price-{{ $adjustment->id }}" data-bs-backdrop="static" data-bs-keyboard="false"
      tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Edit Price</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('price_adjustments.update', ['price_adjustment' => $adjustment->id]) }}"
                      method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                          <div class="col-sm-6">
                              <label for="room_id">Room</label>
                              <select name="room_id" id="room_id" class="form-control select2">
                                  @foreach ($availableRooms as $room)
                                      <option value="{{ $room->id }}"
                                          {{ $adjustment->room_id == $room->id ? 'selected' : '' }}>
                                          {{ $room->room_number }}
                                      </option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="col-sm-6">
                              <label for="amount">Amount</label>
                              <input type="number" name="amount" id="amount" class="form-control"
                                  value="{{ $adjustment->amount }}" step="0.01">
                          </div>
                          <div class="col-sm-6">
                              <label for="startdate">Start Date</label>
                              <input type="date" name="startdate" id="startdate" class="form-control"
                                  value="{{ $adjustment->startdate }}">
                          </div>
                          <div class="col-sm-6">
                              <label for="enddate">End Date</label>
                              <input type="date" name="enddate" id="enddate" class="form-control"
                                  value="{{ $adjustment->enddate }}">
                          </div>
                          <div class="mt-2">
                              <button type="submit" class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">Update</button>
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
