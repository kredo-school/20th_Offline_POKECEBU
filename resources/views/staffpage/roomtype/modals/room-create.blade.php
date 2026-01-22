<div class="modal fade" id="createRoomModal-" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Room</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    @method('PATCH')

                    <div class="mb-2">
                        <label for="" class="form-label">Room Number</label>
                        <input type="text" name="" id="" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label">Room Type</label>
                        <select name="" id="" class="form-select">
                            <!-- TODO: foreach -->
                            <option value="">Single</option>
                            <option value="">Suite</option>
                        </select>
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label">Floor Number</label>
                        <input type="number" name="" id="" class="form-control">
                    </div>

                    <div class="mb-2">
                        <label for="" class="form-label">Max Guests</label>
                        <input type="number" name="" id="" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Charges</label>
                        <input type="number" name="" id="" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label for="" class="form-label">Equipment</label>
                        <div>
                            <!-- foreach -->
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category[]" id="" class="" value="">
                                <label for="category" class="">Wifi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category[]" id="" class="" value="">
                                <label for="category" class="">TV</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category[]" id="" class="" value="">
                                <label for="category" class="">Air conditioner</label>
                            </div>
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