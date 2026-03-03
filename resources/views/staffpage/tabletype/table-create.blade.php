@extends('layouts.staff')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        {{-- エラーメッセージを表示するコード --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-2"><a href="{{ route('restaurant.tableOverview') }}">◀︎ Table overview</a></div>

        <div class="col-md-10 p-4">
            <div class="bg-light"><h2 class="mb-1">Add Table</h2></div>
            <form action="{{ route('restaurant.storeTable') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="table_num" class="form-label">Table Number</label>
                        <input type="text" name="table_num" id="table_num" class="form-control" value="{{ old('table_num') }}">
                    </div>

                    <div class="col-md-6 mb-2">
                        <label for="type_id" class="form-label">Table Type</label>
                        <select name="type_id" id="type_id" class="form-select">
                            <option value="" hidden>Select Table Type</option>
                                @foreach ($all_table_types as $table_type)
                                    <option value="{{ $table_type->type_id }}"
                                        {{ old('type_id') == $table_type->type_id ? 'selected' : '' }}>
                                        {{ $table_type->type->name }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label for="guests" class="form-label">Max Guests</label>
                        <input type="number" name="guests" id="guests" class="form-control" value="{{ old('guests') }}">
                    </div>
                    <div class="col-md-6 mb-2">
                        <label for="charges" class="form-label">Charges</label>
                        <div class="input-group">
                            <div class="input-group-text bg-light">₱</div>
                            <input type="number" name="charges" id="charges" class="form-control" value="{{ old('charges') }}">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">Others</label>
                    <div class="category-box">
                        @foreach ($all_categories as $category)
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="category[]" id="category{{ $category->id }}" 
                                    class="form-check-input shadow-none"
                                    value="{{ $category->id }}"
                                    {{ in_array($category->id, old('category', [])) ? 'checked' : '' }}>
                                <label for="category{{ $category->id }}" class="form-check-label category-badge-label">
                                    {{ $category->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <label for="detail" class="form-label">Description of this table</label>
                    <textarea name="detail" id="detail" class="form-control" rows="10">{{ old('detail') }}</textarea>
                </div>

                <div class="mb-4">
                    <label for="images" class="form-label">Table Images</label>
                    <input type="file"
                           name="images[]"
                           id="images"
                           class="form-control"
                           multiple
                           accept="image/*">

                    <div class="form-text">
                        You can select multiple images. Max size 1MB each.
                    </div>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary ms-2">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

