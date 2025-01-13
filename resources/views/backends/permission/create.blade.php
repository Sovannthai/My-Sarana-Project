<div class="modal fade" id="create_permission" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">@lang('Create Permission')</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="form-material form-horizontal" action="{{ route('permission.store') }}" method="POST">
                    @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name">@lang('Permission')</label>
                                    <div class="input-group mb-3">
                                        <input type="text" id="name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="@lang('Type name permission')">
                                        @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="mt-2">
                        <button type="submit"
                            class="btn btn-outline btn-primary btn-sm text-uppercase float-right mb-2 ml-2"> <i
                                class="fas fa-save"></i> {{ __('Submit') }}</button>
                        <a href="" class="float-right btn btn-dark btn-sm "
                            data-value="veiw" data-bs-dismiss="modal">
                            @lang('Close')
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
