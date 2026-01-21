{{-- resources\views\userpage\mypage\add-for-restaurant.blade.php --}}
{{-- resources\views\userpage\mypage\add-for-restaurant.blade.php --}}
@extends('layouts.staff')

@section('content')

{{-- フォーム --}}
<div class="form-card">
    <h3 class="mb-4"><i class="fa-solid fa-utensils me-2"></i>Add Restaurant</h3>

    <form action="#" method="POST" onsubmit="return false;">
        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Restaurant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="e.g. Sushi Hana">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Cuisine Type <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="e.g. Japanese, Italian">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Location <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="e.g. Cebu IT Park">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Seating Capacity <span class="text-danger">*</span></label>
                <input type="number" class="form-control" placeholder="e.g. 50">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Opening Hours <span class="text-danger">*</span></label>
                <input type="text" class="form-control" placeholder="e.g. 10:00 AM - 10:00 PM">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Contact Number</label>
                <input type="text" class="form-control" placeholder="e.g. +63 912 345 6789">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label class="form-label">Description</label>
                <textarea class="form-control" rows="3" placeholder="e.g. Authentic Japanese dining experience"></textarea>
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