<div class="modal fade" id="rejectModal-{{ $restaurant->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg text-start" style="border-radius: 24px; white-space: normal !important;">

            <div class="modal-header border-bottom-0 pb-0 mt-2">
                <h5 class="modal-title fw-bold text-dark px-3">
                    <i class="fa-solid fa-triangle-exclamation text-danger me-2"></i>Reject Restaurant
                </h5>
                <button type="button" class="btn-close me-2" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            @php
                $id = !is_null($restaurant->approval_id) ? $restaurant->approval_id : $restaurant->id;
            @endphp

            <div class="modal-body py-4 px-4">
                <form method="post" action="{{ route('admin.rejectRestaurant', $id) }}">
                    @csrf
                    
                    <p class="text-secondary mb-3">
                        Are you sure you want to reject this restaurant application? Please specify the reason below.
                    </p>

                    <div class="p-3 bg-light rounded-3 mb-3">
                        <div class="small text-muted mb-1">Target Restaurant</div>
                        <strong class="text-dark fs-5">
                            {{ $restaurant->type === 'tmp' ? $restaurant->name : optional($restaurant->user)->name }}
                        </strong>
                        <div class="mt-2 text-center">
                            <a href="{{ route('admin.showPendingRestaurant', $id) }}" class="small text-decoration-none fw-bold">
                                <i class="fa-solid fa-file-circle-exclamation me-1"></i> Review full application
                            </a>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted">Reason for Rejection</label>
                        <textarea name="reject_reason" 
                                  placeholder="Explain why this restaurant was rejected (e.g., missing documents, incorrect menu)..." 
                                  class="form-control border-1 shadow-sm p-3" 
                                  rows="3"
                                  style="border-radius: 12px; resize: none;" required></textarea>
                    </div>

                    <div class="modal-footer border-top-0 pt-0 pb-2 px-0 d-flex justify-content-center">
                        <button type="button" class="btn btn-light fw-bold px-4 py-2 me-2" data-bs-dismiss="modal" 
                                style="border-radius: 12px; border: 1px solid #e2e8f0;">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-danger fw-bold px-4 py-2 shadow-sm" 
                                style="border-radius: 12px; background-color: #ef4444;">
                            Confirm Rejection
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>