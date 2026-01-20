<div class="modal fade" id="approveModal-" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p>
                    Are you sure you want to approve<br>
                    <strong>Hotel's name</strong>?
                </p>
                <a href="">View details</a>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <form method="POST" action="">
                    @csrf
                    <button type="submit" class="btn btn-primary">Approve</button>
                </form>
            </div>
        </div>
    </div>
</div>
