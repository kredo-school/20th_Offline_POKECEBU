{{-- Edit Category Modal --}}
<div class="modal fade" id="edit-category-{{ $category->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-warning">
            <div class="modal-header border-warning">
                <h3 class="h5 modal-title text-warning text-start">
                    <i class="fa-solid fa-pen"></i> Edit Category
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.category.update', $category->id) }}" method="post">
                @csrf
                @method('PUT') {{-- Route::put に合わせる --}}
                <div class="modal-body text-start">
                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label for="name-{{ $category->id }}" class="form-label text-secondary small">Category
                            Name</label>
                        <input type="text" name="name" id="name-{{ $category->id }}"
                            value="{{ old('name', $category->name) }}" class="form-control" required>
                    </div>

                    {{-- Target Type (変更可能) --}}
                    <div class="mb-3">
                        <label for="target_type-{{ $category->id }}" class="form-label text-secondary small">Category
                            Type</label>
                        <select name="target_type" id="target_type-{{ $category->id }}" class="form-select" required>
                            <option value="hotel"
                                {{ old('target_type', $category->target_type) == 'hotel' ? 'selected' : '' }}>Hotel
                            </option>
                            <option value="restaurant"
                                {{ old('target_type', $category->target_type) == 'restaurant' ? 'selected' : '' }}>
                                Restaurant</option>
                        </select>
                        <small class="text-danger mt-1 d-block" style="font-size: 0.75rem;">
                            <i class="fa-solid fa-exclamation-triangle"></i> Warning: Changing the type will clear
                            previous assignments.
                        </small>
                    </div>

                    {{-- 紐づくアイテムの編集 --}}
                    {{-- <div class="mb-3">
                        <label class="form-label text-secondary small">Assign Items</label>
                        <div style="max-height: 200px; overflow-y: auto;" class="border p-2 rounded">
                            @if ($category->target_type === 'hotel')
                                @foreach ($rooms as $room)
                                    <div class="form-check text-start">
                                        <input class="form-check-input" type="checkbox" name="room_ids[]" 
                                            value="{{ $room->id }}" id="edit-room-{{ $category->id }}-{{ $room->id }}"
                                            {{ $category->categoryRooms->contains('room_id', $room->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-room-{{ $category->id }}-{{ $room->id }}">
                                            {{ $room->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($tables as $table)
                                    <div class="form-check text-start">
                                        <input class="form-check-input" type="checkbox" name="table_ids[]" 
                                            value="{{ $table->id }}" id="edit-table-{{ $category->id }}-{{ $table->id }}"
                                            {{ $category->categoryTables->contains('table_id', $table->id) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edit-table-{{ $category->id }}-{{ $table->id }}">
                                            {{ $table->name }}
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div> --}}
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
