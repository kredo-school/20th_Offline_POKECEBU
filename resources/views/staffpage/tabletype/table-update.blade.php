@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">

        {{-- エラーメッセージ --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- 成功メッセージ --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-2">
            <a href="{{ route('restaurant.overview', Auth::user()->id) }}">◀︎ Table overview</a>
        </div>

        <div class="col-md-10 p-4">
            <div class="bg-light"><h2 class="mb-1">Update Table</h2></div>

            <form action="{{ route('restaurant.updateTable', $table->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="table_num" class="form-label">Table Number</label>
                        <input type="text" name="table_num" id="table_num" class="form-control"
                               value="{{ old('table_num', $table->table_number) }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="type_id" class="form-label">Table Type</label>
                        <select name="type_id" id="type_id" class="form-select">
                            @foreach ($all_table_types as $table_type)
                                <option value="{{ $table_type->type_id }}" 
                                    {{ old('type_id', $table->type_id) == $table_type->type_id ? 'selected' : '' }}>
                                    {{ $table_type->type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="guests" class="form-label">Max Guests</label>
                        <input type="number" name="guests" id="guests" class="form-control"
                               value="{{ old('guests', $table->max_guests) }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="charges" class="form-label">Charges</label>
                        <div class="input-group">
                            <div class="input-group-text bg-light">₱</div>
                            <input type="number" name="charges" id="charges" class="form-control"
                                   value="{{ old('charges', $table->charges) }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Others</label>
                    <div class="category-box">
                        @foreach ($all_categories as $category)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category[]" id="category{{ $category->id }}"
                                       class="form-check-input shadow-none"
                                       value="{{ $category->id }}"
                                       {{ in_array($category->id, old('category', $table->categories->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="category{{ $category->id }}" class="form-check-label category-badge-label">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="detail" class="form-label">Description of this table</label>
                    <textarea name="detail" id="detail" class="form-control" rows="10">{{ old('detail', $table->detail) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Existing Images</label>
                    <div class="d-flex flex-wrap gap-2">
                        @if ($table->images->isEmpty())
                            <span class="text-muted small ms-3">No Images</span>
                        @else
                            @foreach ($table->images as $image)
                                <div class="position-relative existing-image" data-id="{{ $image->id }}" style="display:inline-block;">
                                    <img src="{{ $image->image }}" alt="Table Image"
                                         style="width:100px; height:auto; border:1px solid #ccc; border-radius:4px;">
                                    
                                    <button type="button" class="btn btn-sm btn-danger p-1 remove-image-btn"
                                            style="position:absolute; top:2px; right:2px; font-size:0.7rem;">×</button>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div id="delete-images-container"></div>

                <div class="mb-4">
                    <label class="form-label">Add New Images</label>
                    <input type="file" name="images[]" multiple class="form-control" accept="image/jpeg,image/png,image/gif">
                    <small class="text-muted">You can select multiple images. Max size 1MB each.</small>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-warning ms-2">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- JSで既存画像を非表示 + hidden input 追加 --}}
<script>
    document.querySelectorAll('.remove-image-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const div = this.closest('.existing-image');
            const imageId = div.dataset.id;

            // 非表示にする
            div.style.display = 'none';

            // hidden input 追加
            const container = document.getElementById('delete-images-container');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_images[]';
            input.value = imageId;
            container.appendChild(input);
        });
    });
</script>
@endsection