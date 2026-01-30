<div class="modal fade" id="createFaqModal-" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('faq.store') }}" method="post">
                    @csrf
                    <div class="mb-2">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select">
                            @foreach ($all_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-end"><a href="" data-bs-toggle="modal" data-bs-target="#createFaqCategoryModal-">Add Category</a></div>
                    </div>
                    @error('category')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="question" class="form-label">Question</label>
                        <textarea name="question" rows="3" id="question" class="form-control"></textarea>
                    </div>
                    @error('question')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="answer" class="form-label">Answer</label>
                        <textarea name="answer" rows="3" id="answer" class="form-control"></textarea>
                    </div>
                    @error('answer')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="order_no" class="form-label">Order No</label>
                        <input type="number" name="order_no" id="order_no" class="form-control">
                    </div>
                    @error('order_no')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary ms-2">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('adminpage.faqs.modals.faq-category-create')