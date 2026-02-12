<div class="modal fade" id="add-category" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-solid fa-plus"></i> Add Type
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.category-type.store') }}" method="post">
                @csrf

                <div class="modal-body">
                    <div class="d-flex gap-3 mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="target_type" id="hotel" value="hotel">
                            <label class="form-check-label" for="hotel">Hotel</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="target_type" id="restaurant" value="restaurant">
                            <label class="form-check-label" for="restaurant">Restaurant</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="target_type" id="all" value="all">
                            <label class="form-check-label" for="all">All</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-secondary small">Type Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="e.g. Single room / Party table" required>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>