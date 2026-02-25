<div class="modal fade" id="rejectModal-{{ $restaurant->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            @if (!is_null($restaurant->approval_id))
                <?php $id = $restaurant->approval_id; ?>
            @else
                <?php $id = $restaurant->id; ?>
            @endif

            <div class="modal-body">
                <form method="post" action="{{ route('admin.rejectRestaurant', $id) }}">
                    @csrf
                    <p>
                        Are you sure you want to reject<br>
                        <strong>
                            {{ $restaurant->type === 'tmp' ? $restaurant->name : optional($restaurant->user)->name }}
                        </strong>?
                    </p>
                    
                    <a href="{{ route('admin.showPendingRestaurant', $id) }}">View details</a>
                    
                    <div>
                        <textarea name="reject_reason" placeholder="Reasons for reject" class="form-control mt-2 mb-3"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger ms-2">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
