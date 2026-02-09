<div class="modal fade" id="updateRoomtypeModal-{{ $room_type->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h3><i class="fa-solid fa-bed me-2"></i>Update Room Type</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('hotel.updateRoomType', $room_type->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Room Type</label>
                            <input type="text" name="room_type" id="room_type" value="{{ $room_type->type->name }}" class="form-control" style="background-color: lightgray;" readonly>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Total Rooms <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="e.g. 10" value="{{ $room_type->total_rooms }}" name="total_rooms" id="total_rooms">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fa-solid fa-pen me-1"></i>Update
                        </button>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark me-1"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>