<div class="modal fade" id="delete-category_type-{{ $type->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header border-danger">
                <h3 class="h5 modal-title text-danger text-start">
                    <i class="fa-solid fa-trash"></i> Delete Type
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @php
                $exist = false;
                if ($type->target_type === 'hotel') {
                    $exist = $type->typeRooms->count() > 0;
                } elseif ($type->target_type === 'restaurant') {
                    $exist = $type->restaurantTables->count() > 0;
                } else {
                    $exist = $type->typeRooms->count() > 0;
                    if (!$exist) {
                        $exist = $type->restaurantTables->count() > 0;
                    }
                }
            @endphp
            @if ($exist)
                <div class="modal-body text-start">
                    <p>
                        <span class="fw-bold text-danger">{{ $type->name }}</span> : <br>
                        This category cannot be deleted as it is currently in use.
                    </p>
                </div>
                <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            @else
                <div class="modal-body text-start">
                    <p>Are you sure you want to delete the <span class="fw-bold text-danger">{{ $type->name }}</span> type?</p>
                </div>

                <div class="modal-footer border-0">
                    <form action="{{ route('admin.category-type.destroy', $type->id) }}" method="post">
                        @csrf
                        @method('DELETE')

                        <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger btn-sm px-4">Delete</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>