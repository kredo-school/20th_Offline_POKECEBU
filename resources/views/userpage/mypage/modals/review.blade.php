<div class="modal fade" id="reviewModal-{{ $type }}-{{ $reservation->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reviewForm-{{ $type }}-{{ $reservation->id }}" method="POST"
                action="{{ $review ? route('user.reviews.update', $review->id) : route('user.reviews.store') }}">
                @csrf
                @if ($review)
                    @method('PUT')
                @endif

                @if ($type === 'hotel')
                    <input type="hidden" name="hotel_reservation_id" value="{{ $reservation->id }}">
                @else
                    <input type="hidden" name="restaurant_reservation_id" value="{{ $reservation->id }}">
                @endif
                <div class="modal-header">
                    <h5 class="modal-title">
                        {{ $review ? 'Edit Review' : 'Write Review' }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">

                    {{-- 星評価 --}}
                    <label for="">Raiting(0.0〜5.0)</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1"
                        class="form-control" value="{{ $review->rating ?? '' }}" required>

                    {{-- コメント --}}
                    <label class="mt-3" for="">Comment</label>
                    <textarea class="form-control" name="comment" id="comment{{ $reservation->id }}">{{ $review->comment ?? '' }}</textarea>
                </div>
            </form>

            <div class="modal-footer">
                @if ($review)
                    <form method="POST" action="{{ route('user.reviews.destroy', $review->id) }}" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Are you sure you want to delete this review?')">
                            Delete
                        </button>
                    </form>
                @endif
                
                <button class="btn btn-primary" type="submit"
                    form="reviewForm-{{ $type }}-{{ $reservation->id }}">{{ $review ? 'Update' : 'Submit' }}</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>



        </div>
    </div>
</div>
