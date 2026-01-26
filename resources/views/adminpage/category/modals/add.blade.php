{{-- Add --}}
<div class="modal fade" id="add-category">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-solid fa-plus"></i> Add Category
                </h3>
            </div>
            <form action="" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label text-secondary small">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Italian, Luxury Hotel" required autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="type" class="form-label text-secondary small">Category Type</label>
                        <select name="type" id="type" class="form-select" required>
                            <option value="" hidden>Select Type</option>
                            <option value="restaurant">Restaurant</option>
                            <option value="hotel">Hotel</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-sm">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
