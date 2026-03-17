<div class="modal fade" id="reviewModal{{ $target->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST"
                action="{{ $review ? route('user.reviews.update', $review->id) : route('user.reviews.store') }}">
                @csrf
                @if ($review)
                    @method('PUT')
                @endif

                <input type="hidden" name="target_type" value="{{ $type }}">
                <input type="hidden" name="target_id" value="{{ $target->id }}">
                <div class="modal-header">
                    <h5>{{ $review ? 'Edit Review' : 'Write a Review' }}</h5>
                </div>
                <div class="modal-body">

                    {{-- 星評価 --}}
                    <label for="">Review(0.0〜5.0)</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1"
                        class="form-control" value="{{ $review->rating ?? '' }}" required>

                    {{-- コメント --}}
                    <label class="mt-3" for="">Comment</label>
                    <textarea class="form-control" name="comment" id="comment">{{ $review->comment ?? '' }}</textarea>
                </div>

                <div class="modal-footer">
                    @if ($review)
                        <form method="POST" action="{{ route('user.reviews.destroy', $review->id) }}" class="mt-2">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                Delete
                            </button>
                        </form>
                    @endif
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">{{ $review ? 'Update' : 'Submit' }}</button>
                </div>

            </form>


        </div>
    </div>
</div>
