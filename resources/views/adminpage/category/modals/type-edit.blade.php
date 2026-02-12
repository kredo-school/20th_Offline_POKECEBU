<div class="modal fade" id="edit-category_type-{{ $type->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning text-start">
                    <i class="fa-solid fa-pen"></i> Edit Type
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.category-type.update', $type->id) }}" method="post">
                @csrf
                @method('PATCH') 
                <div class="modal-body text-start">
                    <div class="mb-3">
                        <label for="name-{{ $type->id }}" class="form-label text-secondary small">Type Name</label>
                        <input type="text" name="name" id="name-{{ $type->id }}"
                            value="{{ old('name', $type->name) }}" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="target_type-{{ $type->id }}" class="form-label text-secondary small">Type</label>
                        <input type="text" name="" id="" class="form-control text-capitalize" value="{{ $type->target_type }}" style="background-color: lightgray;" readonly>
                        <small class="text-danger mt-1" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-exclamation-triangle"></i> If you want to edit the type, please create a new one.
                        </small>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-warning btn-sm"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning btn-sm px-4 text-white">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>