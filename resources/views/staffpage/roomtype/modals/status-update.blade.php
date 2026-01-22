<div class="modal fade" id="updateStatusModal-" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-5">
                        <div class="col-5">
                            <label class="form-label" for="Current">Current</label>
                            <input type="text" name="" id="" value="Available" class="form-control" style="background-color: lightgray;" readonly>
                        </div>
                        <div class="col-1">→</div>
                        <div class="col-5">
                            <label class="form-label" for="Update">Update</label>
                            <select class="form-select" name="" id="">
                                <!-- TODO: get the data from db (foreach)-->
                                <option value="Available">Available</option>
                                <option value="In use">In use</option>
                                <option value="Cleaning">Cleaning</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="text-end">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>    
                        <button type="submit" class="btn btn-success ms-2">Update</button>
                    </div>            
                </form>
            </div>
        </div>
    </div>
</div>
