<div class="modal fade" id="deleteRoomtypeModal-{{ $room_type->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Room Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                @if ($all_rooms->where('type_id', $room_type->type_id)->whereIn('status_id', [2, 3])->count() > 0)
                    <div>
                        <p class="mb-4">
                            <p><strong>This room type cannot be deleted at this time.</strong></p>
                            Room Type: {{ $room_type->type->name }}<br>
                            Total Rooms: {{ $room_type->total_rooms }}<br>
                        </p>

                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                        </div>
                    </div>
                @else
                    <div>
                        <p>
                            <p><strong>Are you sure you want to delete?</strong></p>

                            Room Type: {{ $room_type->type->name }}<br>
                            Total Rooms: {{ $room_type->total_rooms }}<br>
                        </p>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                            <form method="POST" action="{{ route('hotel.destroyRoomType', $room_type->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-2">Delete</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>