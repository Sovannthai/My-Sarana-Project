  <!-- Modal -->
  <div class="modal fade" id="edit_amenity-{{ $amenity->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Edit Amenity</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('amenities.update', ['amenity' => $amenity->id]) }}" method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                          <div class="col-sm-6">
                              <label for="name">@lang('Name')</label>
                              <input type="text" name="name" id="name" value="{{ $amenity->name }}"
                                  class="form-control @error('name') is-invalid @enderror"
                                  placeholder="@lang('Enter amenity name')" required>
                          </div>
                          <div class="col-sm-6">
                              <label for="additional_price">@lang('Additional Price')</label>
                              <input type="number" step="0.01" name="additional_price" id="additional_price"
                                  value="{{ $amenity->additional_price }}"
                                  class="form-control @error('additional_price') is-invalid @enderror"
                                  placeholder="@lang('Enter additional price')" required>
                          </div>
                          <div class="col-sm-12">
                              <label for="description">@lang('Description')</label>
                              <textarea name="description" rows="5" id="description" class="form-control" placeholder="@lang('Enter amenity description')">{{ $amenity->description }}</textarea>
                          </div>
                          <div class="mt-2">
                              <button type="submit"
                                  class="btn btn-outline-primary btn-sm text-uppercase float-right mb-2 ml-2">
                                  <i class="fas fa-save"></i> @lang('Update')
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
