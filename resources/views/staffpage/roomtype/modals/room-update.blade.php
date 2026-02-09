<div class="modal fade" id="updateRoomModal-{{ $room->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- もしステータスが使用中または予約済みであれば、編集は不可 -->
                @if ($room->status_id == 2 || $room->status_id == 3)
                    <p class="mb-4">
                        <p><strong>This room's status cannot be changed at this time.</strong></p>

                        Room Number: {{ $room->room_number }}<br>
                        Room Type: {{ $room->type->name }}<br>
                        Floor Number: {{ $room->floor_number }}<br>
                        Max Guests: {{ $room->max_guests }}<br>
                        Charges: {{ $room->charges }}<br>
                    </p>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                    </div>
                @else
                    <form action="{{ route('hotel.updateRoom', $room->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="mb-2">
                            <label for="room_num" class="form-label">Room Number</label>
                            <input type="text" name="room_num" id="room_num" value="{{ $room->floor_number }}"
                                class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="type_id" class="form-label">Room Type</label>
                            <select name="type_id" id="type_id" class="form-select">
                                @foreach ($all_room_types as $room_type)
                                    @if ($room_type->type_id == $room->type_id)
                                        <option value="{{$room_type->type_id}}" selected>{{ $room_type->type->name }}</option>
                                    @else
                                        <option value="{{$room_type->type_id}}">{{ $room_type->type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="floor_num" class="form-label">Floor Number</label>
                            <input type="number" name="floor_num" id="floor_num" value="{{ $room->floor_number }}"
                                class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="guests" class="form-label">Max Guests</label>
                            <input type="number" name="guests" id="guests" value="{{ $room->max_guests }}"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="charges" class="form-label">Charges</label>
                            <div class="input-group">
                                <div class="input-group-text bg-light">¥</div>
                                <input type="number" name="charges" id="charges" value="{{ $room->charges }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Amenities</label>
                            <div class="category-box">
                                @foreach ($all_categories as $category)
                                    <div class="form-check form-check-inline">
                                    <input type="checkbox" name="category[]" id="category{{ $category->id }}" class="form-check-input shadow-none"
                                         value="{{ $category->id }}" {{ $room->categories->contains($category->id) ? 'checked' : '' }}>
                                    <label for="category{{ $category->id }}" class="form-check-label category-badge-label">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning ms-2">Update</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>