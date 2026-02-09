<div class="modal fade" id="createRoomtypeModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h3><i class="fa-solid fa-bed me-2"></i>Add Room Type</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('hotel.storeRoomType', Auth::user()->id) }}" method="post">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Room Type <span class="text-danger">*</span></label>
                            <select name="room_type" id="room_type" class="form-select">
                                <option value="" hidden>Select Room Type</option>
                                @foreach ($all_types as $type)
                                    <option value="{{$type->id}}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Total Rooms <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="e.g. 10" name="total_rooms"
                                id="total_rooms">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-add w-100">
                            <i class="fa-solid fa-plus-circle me-1"></i>Add
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