<div class="modal fade" id="deleteTabletypeModal-{{ $table_type->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Delete Table Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                @if ($all_tables->where('type_id', $table_type->type_id)->whereIn('status_id', [2, 3])->count() > 0)
                    <div>
                        <p class="mb-4">
                            <p><strong>This table type cannot be deleted at this time.</strong></p>
                            Table Type: {{ $table_type->type->name }}<br>
                            Total Tables: {{ $table_type->total_tables }}<br>
                        </p>

                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Back</button>
                        </div>
                    </div>
                @else
                    <div>
                        <p>
                            <p><strong>Are you sure you want to delete?</strong></p>

                            Table Type: {{ $table_type->type->name }}<br>
                            Total Tables: {{ $table_type->total_tables }}<br>
                        </p>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                            <form method="POST" action="{{ route('restaurant.destroyTableType', $table_type->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger ms-2">Delete</button>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>