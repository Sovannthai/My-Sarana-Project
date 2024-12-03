<!-- Modal -->
<div class="modal fade" id="edit_room-{{ $room->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('rooms.update', ['room' => $room->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="room_number">@lang('Room Number')</label>
                            <input type="text" name="room_number" id="room_number"
                                class="form-control @error('room_number') is-invalid @enderror"
                                value="{{ $room->room_number }}">
                            @error('room_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="size">@lang('Size')</label>
                            <input type="text" name="size" id="size" class="form-control"
                                value="{{ $room->size }}">
                        </div>

                        <div class="col-sm-6">
                            <label for="floor">@lang('Floor')</label>
                            <input type="number" name="floor" id="floor" class="form-control"
                                value="{{ $room->floor }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="amenity_id">@lang('Amenity')</label>
                            <select name="amenity_id[]" id="amenity_id" class="form-control select2" multiple>
                                <option value="" disabled>@lang('Select amenities')</option>
                                @foreach ($amenities as $amenity)
                                    <option value="{{ $amenity->id }}"
                                        @if (in_array($amenity->id, old('amenity_id', $room->amenities->pluck('id')->toArray() ?? []))) selected @endif>
                                        {{ $amenity->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('amenity_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="status">@lang('Status')</label>
                            <select name="status" id="" class="form-control select2">
                                <option value="" selected>Select</option>
                                {{-- <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available
                                </option>
                                <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied
                                </option> --}}
                                <option value="maintenance"{{ $room->status == 'maintenance' ? 'selected' : '' }}>
                                    Maintenance</option>
                            </select>
                        </div>
                        <div class="col-sm-12">
                            <label for="description">@lang('Description')</label>
                            <textarea name="description" id="description" class="form-control">{{ $room->description }}</textarea>
                        </div>
                        <div class="mt-2">
                            <button type="submit"
                                class="btn btn-outline-primary btn-sm text-uppercase float-right ml-2">
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
