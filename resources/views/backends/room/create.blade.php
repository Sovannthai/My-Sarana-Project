  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">@lang('Create Room')</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('rooms.store') }}" method="POST">
                      @csrf
                      <div class="row">
                          <div class="col-sm-6">
                              <label for="room_number">@lang('Room Number')</label>
                              <input type="text" name="room_number" id="room_number"
                                  class="form-control @error('room_number') is-invalid @enderror"
                                  placeholder="@lang('Enter room number')">
                              @error('room_number')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>

                          <div class="col-sm-6">
                              <label for="size">@lang('Size')</label>
                              <input type="text" name="size" id="size" class="form-control">
                          </div>

                          <div class="col-sm-6">
                              <label for="floor">@lang('Floor')</label>
                              <input type="number" name="floor" id="floor" class="form-control">
                          </div>

                          <div class="col-sm-6">
                            <label for="amenity_id">@lang('Amenity')</label>
                            <select name="amenity_id[]" id="amenity_id" class="form-control select2" multiple>
                                <option value="" disabled>@lang('Select amenities')</option>
                                @foreach ($amenities as $amenity)
                                    <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                @endforeach
                            </select>
                            @error('amenity_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                          <div class="col-sm-12">
                              <label for="description">@lang('Description')</label>
                              <textarea name="description" rows="5" id="description" class="form-control" placeholder="@lang('Enter room description')"></textarea>
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
