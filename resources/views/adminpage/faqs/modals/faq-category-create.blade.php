<div class="modal fade" id="createFaqCategoryModal-" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add FAQ Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.faq.storeCategory') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <label for="category" class="form-label">Category Name</label>
                        <input type="text" name="category" id="category" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="order_no" class="form-label">Order No</label>
                        <input type="number" name="order_no" id="order_no" class="form-control">
                    </div>

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-2">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>