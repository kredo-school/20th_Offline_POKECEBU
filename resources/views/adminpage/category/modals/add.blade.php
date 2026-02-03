{{-- Add Category Modal --}}
<div class="modal fade" id="add-category" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content border-primary">
            <div class="modal-header border-primary">
                <h3 class="h5 modal-title text-primary">
                    <i class="fa-solid fa-plus"></i> Add Category
                </h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('admin.category.store') }}" method="post">
                @csrf

                <div class="modal-body">

                    {{-- 種別切り替え --}}
                    <div class="btn-group w-100 mb-3" role="group">
                        <button type="button" class="btn btn-outline-primary active" id="modal-btn-hotel">
                            Hotel
                        </button>
                        <button type="button" class="btn btn-outline-primary" id="modal-btn-restaurant">
                            Restaurant
                        </button>
                    </div>

                    {{-- 自動送信用 --}}
                    <input type="hidden" name="target_type" id="modal-target-type" value="hotel">

                    {{-- Category Name --}}
                    <div class="mb-3">
                        <label class="form-label text-secondary small">Category Name</label>
                        <input type="text"
                               name="name"
                               id="modal-name"
                               class="form-control"
                               placeholder="e.g. Luxury Hotel"
                               required>
                    </div>

                    {{-- Pivot attach 用（Hotel/Restaurant選択） --}}
                    <div class="mb-3" id="modal-item-checkboxes">
                        <label class="form-label text-secondary small">Select Items</label>

                        {{-- Hotel Rooms --}}
                        <div id="hotel-items">
                            @foreach($rooms ?? [] as $room)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="room_ids[]"
                                           value="{{ $room->id }}" id="room-{{ $room->id }}">
                                    <label class="form-check-label" for="room-{{ $room->id }}">
                                        {{ $room->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        {{-- Restaurant Tables --}}
                        <div id="restaurant-items" class="d-none">
                            @foreach($tables ?? [] as $table)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="table_ids[]"
                                           value="{{ $table->id }}" id="table-{{ $table->id }}">
                                    <label class="form-check-label" for="table-{{ $table->id }}">
                                        {{ $table->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Add
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    const hotelBtn = document.getElementById('modal-btn-hotel');
    const restaurantBtn = document.getElementById('modal-btn-restaurant');
    const targetTypeInput = document.getElementById('modal-target-type');

    const hotelItems = document.getElementById('hotel-items');
    const restaurantItems = document.getElementById('restaurant-items');

    hotelBtn.addEventListener('click', () => {
        hotelBtn.classList.add('active');
        restaurantBtn.classList.remove('active');

        targetTypeInput.value = 'hotel';

        hotelItems.classList.remove('d-none');
        restaurantItems.classList.add('d-none');

        document.getElementById('modal-name').placeholder = 'e.g. Luxury Hotel';
    });

    restaurantBtn.addEventListener('click', () => {
        restaurantBtn.classList.add('active');
        hotelBtn.classList.remove('active');

        targetTypeInput.value = 'restaurant';

        restaurantItems.classList.remove('d-none');
        hotelItems.classList.add('d-none');

        document.getElementById('modal-name').placeholder = 'e.g. Italian, Sushi';
    });
</script>
