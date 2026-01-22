<div class="container-fluid">
    <div class="row justify-content-center mb-4">
        <div class="card col-7">
            <div class="card-body">
                <div class="mb-2">
                    <h3>Rooms Overview</h3>
                </div>

                <div class="mb-2 text-end">
                    <button type="button" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add Room Type
                    </button>
                </div>

                <table class="table align-middle bg-white text-secondary">
                    <thead class="small table-warning text-secondary">
                        <tr>
                            <th>#</th>
                            <th>Room Type</th>
                            <th>Total Rooms</th>
                            <th>Reserved</th>
                            <th>Available</th>
                            <th>Temporarily Unavailable</th>
                            <th>Unavailable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- TODO : get data from db(foreach) -->
                        <tr>
                            <td>1</td>
                            <td>Suite</td>
                            <td>10</td>
                            <td>6</td>
                            <td>3</td>
                            <td>1</td>
                            <td>0</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Single</td>
                            <td>10</td>
                            <td>8</td>
                            <td>0</td>
                            <td>0</td>
                            <td>2</td>
                        </tr>
                    </tbody>
                    <tbody class="table-secondary">
                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td>20</td>
                            <td>14</td>
                            <td>3</td>
                            <td>1</td>
                            <td>2</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="mt-4">
        <div class="mb-3">
            <h2>Room Management</h2>
        </div>
        <div class="mb-2 text-end text-white">
                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#createRoomModal-">
                        <i class="fa-solid fa-plus"></i> Add Room
                    </button>
                </div>
        <table class="table table-hover align-middle bg-white text-secondary">
            <thead class="small table-secondary text-secondary">
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Floor Number</th>
                <th>Max Guests</th>
                <th>Charges</th>
                <th>Equipment</th>
                <th>Status</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td>101</td>
                    <td>Single</td>
                    <td>1</td>
                    <td>1</td>
                    <td>¥5,000</td>
                    <td>
                        <div class="badge border bg-white bg-opacity-50 text-dark">Wifi</div>
                        <div class="badge border bg-white bg-opacity-50 text-dark">TV</div>
                    </td>
                    <td >
                        <div class="badge border bg-success bg-opacity-50">Available</div>
                        <button class="btn" data-bs-toggle="modal" data-bs-target="#updateStatusModal-">
                            <i class="fa-solid fa-arrows-rotate"></i>
                        </button>
                    </td>
                    <td class="text-end">
                        <a href="" class="btn btn-sm btn-outline-warning" data-bs-toggle="modal" data-bs-target="#updateRoomModal-"><i class="fa-solid fa-pen"></i></a>
                        <a href="" class="btn btn-sm btn-outline-danger ms-1" data-bs-toggle="modal" data-bs-target="#deleteRoomModal-"><i class="fa-solid fa-trash"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
        @include('staffpage.roomtype.modals.status-update')
        @include('staffpage.roomtype.modals.room-create')
        @include('staffpage.roomtype.modals.room-update')
        @include('staffpage.roomtype.modals.room-delete')
    </div>
</div>