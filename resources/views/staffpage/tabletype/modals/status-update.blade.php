<div class="modal fade" id="updateStatusModal-{{ $table->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Update Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('restaurant.updateStatus', $table->id) }}" method="post">
                    @csrf
                    @method('PATCH')
                    <div class="row mb-5">
                        <div class="col-5">
                            <label class="form-label" for="Current">Current</label>
                            <input type="text" name="" id="" value="{{$table->status->name}}" class="form-control" style="background-color: lightgray;" readonly>
                        </div>
                        <div class="col-1">→</div>
                        <div class="col-5">
                            <label class="form-label" for="Update">Update</label>
                            <select class="form-select" name="status" id="status">
                                @foreach ($all_statuses as $status)
                                    <option value="{{$status->id}}">{{ $status->name }}</option>
                                @endforeach
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
