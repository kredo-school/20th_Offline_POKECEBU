<div class="modal fade" id="approveModal-{{ $restaurant->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 24px; white-space: normal !important;">

            <div class="modal-header border-bottom-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold text-dark px-3">
                    <i class="fa-solid fa-utensils text-primary me-2"></i>Approve Restaurant
                </h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            @if (!is_null($restaurant->approval_id))
                <div class="modal-body py-4 px-4">
                    <p class="text-secondary mb-3">
                        Are you sure you want to approve this restaurant? Once approved, the staff can start managing their menu and reservations.
                    </p>
                    
                    <div class="p-3 bg-light rounded-3 mb-3">
                        <div class="small text-muted mb-1">Restaurant Name</div>
                        <strong class="text-dark fs-5">
                            {{ $restaurant->type === 'tmp' ? $restaurant->name : optional($restaurant->user)->name }}
                        </strong>
                        <div class="mt-2 text-center">
                            <a href="{{ route('admin.showPendingRestaurant', $restaurant->approval_id) }}" class="btn btn-link btn-sm text-decoration-none text-primary fw-bold">
                                <i class="fa-solid fa-file-invoice me-1"></i> View application details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pt-0 pb-4 px-4 justify-content-center">
                    <button type="button" class="btn btn-light fw-bold px-4 py-2 me-2" data-bs-dismiss="modal" 
                            style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        Cancel
                    </button>

                    <form method="post" action="{{ route('admin.approveRestaurant', $restaurant->approval_id) }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-primary fw-bold px-4 py-2 shadow-sm" 
                                style="border-radius: 12px; background: #4f46e5;">
                            Confirm Approval
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>