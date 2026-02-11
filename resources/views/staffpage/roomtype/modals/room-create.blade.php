<div class="modal fade" id="createRoomModal-" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('hotel.storeRoom', Auth::user()->id) }}" method="post">
                    @csrf

                    <div class="mb-2">
                        <label for="room_num" class="form-label">Room Number</label>
                        <input type="text" name="room_num" id="room_num" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="type_id" class="form-label">Room Type</label>
                        <select name="type_id" id="type_id" class="form-select">
                            <option value="" hidden>Select Room Type</option>
                            @foreach ($all_room_types as $room_type)
                                <option value="{{ $room_type->type_id }}">{{ $room_type->type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="floor_num" class="form-label">Floor Number</label>
                        <input type="number" name="floor_num" id="floor_num" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="guests" class="form-label">Max Guests</label>
                        <input type="number" name="guests" id="guests" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="charges" class="form-label">Charges</label>
                        <div class="input-group">
                            <div class="input-group-text bg-light">¥</div>
                            <input type="number" name="charges" id="charges" class="form-control">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="" class="form-label">Amenities</label>
                        <div class="category-box">
                        @foreach ($all_categories as $category)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category[]" id="category{{ $category->id }}" 
                                    class="form-check-input shadow-none" value="{{ $category->id }}">
                                <label for="category{{ $category->id }}" class="form-check-label category-badge-label">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-2">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>