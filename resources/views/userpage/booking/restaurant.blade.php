<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restaurant Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container my-5">

    <!-- レストラン名 -->
    <h2 class="fw-bold mb-3">{{ $restaurant['name'] }}</h2>

    <!-- 写真 -->
    <div class="mb-4">
        <img src="{{ $restaurant['image'] }}" class="img-fluid rounded-4">
    </div>

    <!-- Guest Information -->
    <div class="card mb-4 shadow-sm rounded-4">
        <div class="card-header fw-semibold">
            Guest Information
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label small text-muted">Full Name</label>
                    <input type="text" class="form-control" placeholder="John Doe">
                </div>
                <div class="col-6">
                    <label class="form-label small text-muted">Email</label>
                    <input type="email" class="form-control" placeholder="example@email.com">
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <label class="form-label small text-muted">Phone</label>
                    <input type="text" class="form-control" placeholder="+81 000-0000-0000">
                </div>
            </div>
        </div>
    </div>

    <!-- Reservation Details -->
    <div class="card mb-4 shadow-sm rounded-4">
        <div class="card-header fw-semibold">
            Reservation Details
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-4">
                    <label class="form-label small text-muted">Date</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-4">
                    <label class="form-label small text-muted">Time</label>
                    <input type="time" class="form-control">
                </div>
                <div class="col-4">
                    <label class="form-label small text-muted">Guests</label>
                    <select class="form-select">
                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4+</option>
                    </select>
                </div>
            </div>

            <p class="fw-semibold mt-3">
                Average price per person: ¥{{ number_format($restaurant['price']) }}
            </p>
        </div>
    </div>



    <!-- Buttons -->
    <div class="d-flex justify-content-end gap-2">
        <button class="btn btn-outline-secondary px-4" onclick="history.back()">Back</button>
        <button class="btn btn-primary px-4">Reserve</button>
    </div>

</div>
</body>
</html>
