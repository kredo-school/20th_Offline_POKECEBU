{{-- Delete Category Modal --}}
<div class="modal fade" id="delete-category-{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger text-start">
                    <i class="fa-solid fa-trash"></i> Delete Category
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-body text-start">
                <p>Are you sure you want to delete the <span class="fw-bold text-danger">{{ $category->name }}</span> category?</p>
                <div class="alert alert-warning small">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    This action will remove all room/table associations for this category.
                </div>
            </div>

            <div class="modal-footer border-0">
                <form action="{{ route('admin.category.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger btn-sm px-4">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>