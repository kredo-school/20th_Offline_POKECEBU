<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .menu-item {
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .menu-item:hover {
        background-color: #f0f4ff; /* 薄い青 */
        color: #0d6efd; /* Bootstrapのprimary色 */
    }
</style>

</head>
<<div class="container mt-5">
    <div class="mb-4">
        <h2>My Account</h2>
        <p class="text-muted">文章かんがえる。</p>
    </div>

    <div class="row">
        {{-- 左側のめにゅー --}}
        <div class="col-3 d-flex flex-column mb-4">
            <a href="{{ route('mypage') }}"
                class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Profile</a>
            <a href="{{ route('bookings') }}" class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">My
                Booking</a>
            <a href="{{ route('favorites') }}"
                class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>

        </div>
        <div class="col-9">
            <div class="card mb-4 w-100">
                <div class="card-body">
                    <!-- お気に入りタイプ選択 -->
                    <div class="mb-3">
                        <div class="btn-group w-100" role="group" aria-label="Favorite Type">
                            <input type="radio" class="btn-check" name="favoriteType" id="all"
                                autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="all">All ✓</label>

                            <input type="radio" class="btn-check" name="favoriteType" id="hotel"
                                autocomplete="off">
                            <label class="btn btn-outline-primary" for="hotel">Hotel
                                
                            </label>

                            <input type="radio" class="btn-check" name="favoriteType" id="restaurant"
                                autocomplete="off">
                            <label class="btn btn-outline-primary" for="restaurant">Restaurant</label>
                        </div>
                    </div>

                    <!-- お気に入りがまだない場合 -->
                    <div class="text-center py-5">
                        <i class="fas fa-heart fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">You have no favorites yet.</h5>
               
                    </div>

                </div>
            </div>
        </div>

</html>
