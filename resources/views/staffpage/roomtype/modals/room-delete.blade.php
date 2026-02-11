<div class="modal fade" id="deleteRoomModal-{{ $room->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- もしステータスが使用中または予約済みであれば、編集は不可 -->
                @if ($room->status_id == 2 || $room->status_id == 3)
                    <div>
                        <p class="mb-4">
                            <p><strong>This room's status cannot be deleted at this time.</strong></p>

                            Room Number: {{ $room->room_number }}<br>
                            Room Type: {{ $room->type->name }}<br>
                            Floor Number: {{ $room->floor_number }}<br>
                            Max Guests: {{ $room->max_guests }}<br>
                            Charges: {{ $room->charges }}<br>
                        </p>

                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                        </div>
                    </div>
                @else
                    <div>
                        <p>
                            <p><strong>Are you sure you want to delete?</strong></p>

                            Room Number: {{ $room->room_number }}<br>
                            Room Type: {{ $room->type->name }}<br>
                            Floor Number: {{ $room->floor_number }}<br>
                            Max Guests: {{ $room->max_guests }}<br>
                            Charges: {{ $room->charges }}<br>
                        </p>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                            <form method="POST" action="{{ route('hotel.destroyRoom', $room->id) }}">
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