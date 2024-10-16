  <!-- Modal -->
  <div class="modal fade" id="edit_utilities-{{ $utility_type->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
      aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="staticBackdropLabel">Create Utility Type</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form action="{{ route('utilities.updateType', ['id' => $utility_type->id]) }}"
                      method="POST">
                      @csrf
                      @method('PUT')
                      <div class="row">
                          <div class="col-sm-12">
                              <label for="type">@lang('Utility Type')</label>
                              <input type="text" name="type" id="type"
                                  class="form-control @error('type') is-invalid @enderror"
                                  value="{{ $utility_type->type }}" required>
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
