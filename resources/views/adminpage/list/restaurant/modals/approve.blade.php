<div class="modal fade" id="approveModal-{{ $restaurant->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            @if (!is_null($restaurant->approval_id))
                <div class="modal-body">
                    <p>
                        Are you sure you want to approve<br>
                        <strong>
                            {{ $restaurant->type === 'tmp' ? $restaurant->name : optional($restaurant->user)->name }}
                        </strong>?
                    </p>

                    <a href="{{ route('admin.showPendingRestaurant', $restaurant->approval_id) }}">View details</a>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>

                    <form method="post" action="{{ route('admin.approveRestaurant', $restaurant->approval_id) }}">
                        @csrf
                        <button type="submit" class="btn btn-primary ms-2">Approve</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
