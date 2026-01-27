{{-- resources\views\add-for-hotel.blade.php --}}
@extends('layouts.staff')

@section('content')


{{-- フォーム --}}
    <div class="form-card">
        <h3 class="mb-4"><i class="fa-solid fa-bed me-2"></i>Add Room</h3>

        <form action="#" method="POST" onsubmit="return false;">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select name="room_type" id="room_type" class="form-select">
                        <option value="" hidden>Select Room Type</option>
                        <option value="vip">VIP</option>
                        <option value="single">Single</option>
                        <option value="double">Double</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-12">
                    <label class="form-label">Total Rooms <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" placeholder="e.g. 10">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 mb-3">
                    <button type="submit" class="btn btn-add w-100">
                        <i class="fa-solid fa-plus-circle me-1"></i>Add
                    </button>
                </div>
                <div class="col-12 mb-3">
                    <button type="button" class="btn btn-outline-secondary w-100">
                        <i class="fa-solid fa-xmark me-1"></i>Cancel
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection


