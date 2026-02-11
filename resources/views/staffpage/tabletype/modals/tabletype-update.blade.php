<div class="modal fade" id="updateTabletypeModal-{{ $table_type->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h3><i class="fa-solid fa-bed me-2"></i>Update Table Type</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            
            <div class="modal-body">
                <form action="{{ route('restaurant.updateTableType', $table_type->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Table Type</label>
                            <input type="text" name="table_type" id="table_type" value="{{ $table_type->type->name }}" class="form-control" style="background-color: lightgray;" readonly>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Total Tables <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" placeholder="e.g. 10" value="{{ $table_type->total_tables }}" name="total_tables" id="total_tables">
                        </div>
                    </div>

                    <div class="mb-3">
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fa-solid fa-pen me-1"></i>Update
                        </button>
                    </div>
                    <div class="mb-3">
                        <button type="button" class="btn btn-outline-secondary w-100" data-bs-dismiss="modal">
                            <i class="fa-solid fa-xmark me-1"></i>Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>