<div class="modal fade" id="updateTableModal-{{ $table->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Table</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- もしステータスが使用中または予約済みであれば、編集は不可 -->
                @if ($table->status_id == 2 || $table->status_id == 3)
                    <p class="mb-4">
                        <p><strong>This table's status cannot be changed at this time.</strong></p>

                        Table Number: {{ $table->table_number }}<br>
                        Table Type: {{ $table->type->name }}<br>
                        Max Guests: {{ $table->max_guests }}<br>
                        Charges: {{ $table->charges }}<br>
                    </p>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                    </div>
                @else
                    <form action="{{ route('restaurant.updateTable', $table->id) }}" method="post">
                        @csrf
                        @method('PATCH')
                        <div class="mb-2">
                            <label for="table_num" class="form-label">Table Number</label>
                            <input type="text" name="table_num" id="table_num" value="{{ $table->table_number }}"
                                class="form-control">
                        </div>

                        <div class="mb-2">
                            <label for="type_id" class="form-label">Table Type</label>
                            <select name="type_id" id="type_id" class="form-select">
                                @foreach ($all_table_types as $table_type)
                                    @if ($table_type->type_id == $table->type_id)
                                        <option value="{{$table_type->type_id}}" selected>{{ $table_type->type->name }}</option>
                                    @else
                                        <option value="{{$table_type->type_id}}">{{ $table_type->type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-2">
                            <label for="guests" class="form-label">Max Guests</label>
                            <input type="number" name="guests" id="guests" value="{{ $table->max_guests }}"
                                class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="charges" class="form-label">Charges</label>
                            <div class="input-group">
                                <div class="input-group-text bg-light">¥</div>
                                <input type="number" name="charges" id="charges" value="{{ $table->charges }}"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="" class="form-label">Others</label>
                            <div class="category-box">
                                @foreach ($all_categories as $category)
                                    <div class="form-check form-check-inline">
                                    <input type="checkbox" name="category[]" id="category{{ $category->id }}" class="form-check-input shadow-none"
                                         value="{{ $category->id }}" {{ $table->categories->contains($category->id) ? 'checked' : '' }}>
                                    <label for="category{{ $category->id }}" class="form-check-label category-badge-label">
                                        {{ $category->name }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-warning ms-2">Update</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>