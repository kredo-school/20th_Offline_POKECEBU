<div class="modal fade" id="approveModal-{{ $hotel->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 20px; white-space: normal !important;">

            <div class="modal-header border-bottom-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold text-dark px-3">
                    <i class="fa-solid fa-circle-check text-primary me-2"></i>Approve Hotel
                </h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            @if (!is_null($hotel->approval_id))
                <div class="modal-body py-4 px-4">
                    <div class="w-100">
                        <p class="text-secondary mb-3">
                            Are you sure you want to approve this hotel? This will grant the user access to the dashboard.
                        </p>
                        
                        <div class="p-3 bg-light rounded-3 mb-3">
                            <div class="small text-muted mb-1">Hotel Name</div>
                            <strong class="text-dark fs-5 d-block" style="white-space: normal;">
                                {{ $hotel->type === 'tmp' ? $hotel->name : optional($hotel->user)->name }}
                            </strong>
                        </div>

                        <div class="text-center">
                            <a href="{{ route('admin.hotel.approval.show', $hotel->approval_id) }}" class="btn btn-link btn-sm text-decoration-none text-primary fw-bold">
                                <i class="fa-solid fa-file-lines me-1"></i> View application details
                            </a>
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-top-0 pt-0 pb-4 px-4 justify-content-center">
                    <button type="button" class="btn btn-light fw-bold px-4 py-2 me-2" data-bs-dismiss="modal" style="border-radius: 12px; border: 1px solid #e2e8f0;">
                        Cancel
                    </button>

                    <form method="post" action="{{ route('admin.hotel.approve', $hotel->approval_id) }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-primary fw-bold px-4 py-2 shadow-sm" style="border-radius: 12px; background: #4f46e5;">
                            Approve Now
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>