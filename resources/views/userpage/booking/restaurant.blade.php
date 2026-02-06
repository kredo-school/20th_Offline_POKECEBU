<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restaurant Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: none; }
    </style>
</head>

<body>
    <div class="container my-5" style="max-width: 600px; margin:auto;">
        
        {{-- 成功メッセージの表示 --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-4" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- バリデーションエラーの表示 --}}
        @if ($errors->any())
            <div class="alert alert-danger rounded-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="reservationForm" action="{{ route('restaurant.reserve') }}" method="POST">
            @csrf
            
            {{-- どのレストランか特定するための隠し項目 --}}
            <input type="hidden" name="restaurant_id" value="{{ $restaurant->id }}">

            <h2 class="fw-bold mb-4 text-center">{{ $restaurant->name ?? 'Information Not Available' }}</h2>

            <div class="mb-4 text-center">
                @if($restaurant->image_path)
                    <img src="{{ asset('storage/' . $restaurant->image_path) }}" class="img-fluid rounded-4 shadow">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image" class="img-fluid rounded-4 shadow">
                @endif
            </div>

            <div class="card mb-4 shadow-sm rounded-4">
                <div class="card-header bg-white fw-bold border-bottom-0 pt-3">
                    <i class="fa-solid fa-user me-2 text-primary"></i>Guest Information
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label small text-muted">Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Full Name" value="{{ old('full_name') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small text-muted">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="gmail" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label small text-muted">Phone Number</label>
                            <input type="text" name="phone" class="form-control" placeholder="phone number" value="{{ old('phone') }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4 shadow-sm rounded-4">
                <div class="card-header bg-white fw-bold border-bottom-0 pt-3">
                    <i class="fa-solid fa-calendar-days me-2 text-primary"></i>Reservation Details
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label small text-muted">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ old('date') }}" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label small text-muted">Time</label>
                            <input type="time" name="time" class="form-control" value="{{ old('time') }}" required>
                        </div>
                        <div class="col-4">
                            <label class="form-label small text-muted">Guests</label>
                            <select name="guests" class="form-select" required>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}" {{ old('guests') == $i ? 'selected' : '' }}>{{ $i }} 名</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <p class="fw-semibold mt-3 text-end text-primary">
                        Average Price: ¥{{ number_format($restaurant->price ?? 0) }} / person
                    </p>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mb-5">
                <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" onclick="history.back()">Back</button>
                <button type="submit" class="btn btn-primary px-5 rounded-pill shadow-sm" id="reserveBtn">
                    <span id="btnText">Reserve Now</span>
                    <span class="spinner-border spinner-border-sm d-none" id="btnSpinner" role="status"></span>
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('reservationForm').addEventListener('submit', function() {
            document.getElementById('btnText').classList.add('d-none');
            document.getElementById('btnSpinner').classList.remove('d-none');
            document.getElementById('reserveBtn').disabled = true;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>