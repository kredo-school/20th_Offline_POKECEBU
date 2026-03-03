@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="mb-2"><a href="{{ route('restaurant.tableOverview') }}">◀︎ Table overview</a></div>

        <div class="col-md-10 p-4">
            <div class="bg-light"><h2 class="mb-1">View Details</h2></div>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="table_num" class="form-label">Table Number</label>
                    <input type="text" name="table_num" id="table_num" class="form-control" value="{{ $table->table_number }}" readonly>
                </div>

                <div class="col-md-6 mb-2">
                    <label for="type_id" class="form-label">Table Type</label>
                    <input type="text" name="type_id" id="type_id" class="form-control" value="{{ $table->type->name }}" readonly>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="guests" class="form-label">Max Guests</label>
                    <input type="number" name="guests" id="guests" class="form-control" value="{{ $table->max_guests }}" readonly>
                </div>
                <div class="col-md-6 mb-2">
                    <label for="charges" class="form-label">Charges</label>
                    <div class="input-group">
                        <div class="input-group-text bg-light">₱</div>
                        <input type="number" name="charges" id="charges" class="form-control" value="{{ $table->charges }}" readonly>
                    </div>
                </div>
            </div>
                    
            <div class="row">
                <div class="col-md-6 mb-2">
                    <label for="guests" class="form-label">Status</label>
                    <input type="text" name="type_id" id="type_id" class="form-control" value="{{ $table->status->name }}" readonly>
                </div>
            </div>

            <div class="mb-3">
                <label for="" class="form-label">Amenities</label>
                <div class="category-box">
                    @if ($table->categories->isEmpty())
                        <span class="text-muted small ms-3">No amenity</span>
                    @else
                        @foreach ($table->categories as $category)
                            <span class="badge border bg-light text-dark me-1 mb-1">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label for="detail" class="form-label">Description of this table</label>
                <textarea name="detail" id="detail" class="form-control" rows="10">{{ $table->detail }}</textarea>
            </div>

            <div class="mb-4">
                <label class="form-label">Existing Images</label>
                <div class="d-flex flex-wrap gap-2">
                    @if ($table->images->isEmpty())
                        <span class="text-muted small ms-3">No image</span>
                    @else
                        @foreach ($table->images as $image)
                            <div class="position-relative existing-image" data-id="{{ $image->id }}" style="display:inline-block;">
                                <img src="{{ $image->image }}" alt="Table Image"
                                     style="width:100px; height:auto; border:1px solid #ccc; border-radius:4px;">
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

