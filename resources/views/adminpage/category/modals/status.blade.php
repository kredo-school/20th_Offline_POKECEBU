{{-- Edit --}}
{{-- <div class="modal fade" id="edit-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning">
                    <i class="fa-solid fa-pen"></i> Edit Category
                </h3>
            </div>
            <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name-{{ $category->id }}" class="form-label text-secondary small">Category Name</label>
                        <input type="text" name="name" id="name-{{ $category->id }}" value="{{ old('name', $category->name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="type-{{ $category->id }}" class="form-label text-secondary small">Category Type</label>
                        <select name="type" id="type-{{ $category->id }}" class="form-select" required>
                            <option value="restaurant" {{ old('type', $category->type) == 'restaurant' ? 'selected' : '' }}>Restaurant</option>
                            <option value="hotel" {{ old('type', $category->type) == 'hotel' ? 'selected' : '' }}>Hotel</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-warning btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div> --}}

{{-- Delete --}}
{{-- <div class="modal fade" id="delete-category-{{ $category->id }}">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger">
                    <i class="fa-solid fa-trash"></i> Delete Category
                </h3>
            </div>
            <div class="modal-body text-start">
                <p>Are you sure you want to delete <span class="fw-bold">{{ $category->name }}</span> category?</p>
                <p class="mb-0 small text-muted">This action will affect all the posts under this category. Posts without a category will fall under Uncategorized.</p>
            </div>
            <div class="modal-footer border-0">
                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}