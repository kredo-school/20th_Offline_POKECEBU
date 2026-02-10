<div class="modal fade" id="updateFaqModal-{{ $faq->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('admin.faq.update', $faq->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="mb-2">
                        <label for="category" class="form-label">Category</label>
                        <select name="category" id="category" class="form-select">
                            @foreach ($all_categories as $category)
                                @if($category->id == $faq->faq_category_id)
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                @else
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    @error('category')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title" value="{{ $faq->title }}" class="form-control">
                    </div>
                    @error('title')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="question" class="form-label">Question</label>
                        <textarea name="question" rows="3" id="question" class="form-control">{{ $faq->question }}</textarea>
                    </div>
                    @error('question')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-2">
                        <label for="" class="form-label">Answer</label>
                        <textarea name="answer" rows="3" id="answer" class="form-control">{{ $faq->answer }}</textarea>
                    </div>
                    @error('answer')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="mb-3">
                        <label for="order_no" class="form-label">Order No</label>
                        <input type="number" name="order_no" id="order_no" value="{{ $faq->soft_order }}" class="form-control">
                    </div>
                    @error('order_no')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror

                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning ms-2">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
