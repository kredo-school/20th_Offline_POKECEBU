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
            background-color: #f0f4ff;
            /* 薄い青 */
            color: #0d6efd;
            /* Bootstrapのprimary色 */
        }
    </style>

</head>

<body>
    <!-- Content Here -->
    <div class="container mt-5">
        <div class="mb-4">
            <h2>My Account</h2>
            <p class="text-muted">文章かんがえる。</p>
        </div>

        <div class="row">
            {{-- 左側のめにゅー --}}
            <div class="col-3 d-flex flex-column mb-4">
                <a href="{{ route('mypage') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Profile</a>
                <a href="{{ route('bookings') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">My Booking</a>
                <a href="{{ route('favorites') }}"
                    class="text-decoration-none text-dark px-3 py-2 rounded menu-item mb-1">Favorite</a>

            </div>
            {{-- プロフィール --}}
            <div class="col-9">
                <div class="card mb-4">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="d-flex align-items-center mb-3 col-3">
                                <!-- 写真 -->
                                <img src="https://via.placeholder.com/80" alt="User Photo" class="rounded-circle me-3">
                            </div>
                            <!-- 名前とEmail -->
                            <div class="col-9">
                                <!-- 名前とEmailと電話番号 -->
                                <h5 class="mb-1">{{ $user->first_name ?? '苗字' }} {{ $user->last_name ?? 'なまえ' }}</h5>
                                <p class="mb-0 text-muted">{{ $user->email }}</p>
                                <p class="mb-0 text-muted">{{ $user->phonenumber ?? '電話番号' }}</p>


                                <!-- Edit Profile ボタン -->
                                <a href="{{ route('mypage.editprofile') }}" class="btn btn-primary mt-2">Edit
                                    Profile</a>

                            </div>


                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Perdonal Information</span>
                        <a href="{{ route('mypage.edit') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">First Name</label>
                                <input type="text" class="form-control" value="{{ $user->first_name ?? '田原' }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Last Name</label>
                                <input type="text" class="form-control" value="{{ $user->last_name ?? '志穏' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Email</label>
                                <input type="text" class="form-control"
                                    value="{{ $user->email ?? 'shi****928@gmail.com' }}">
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted">Phone</label>
                                <input type="text" class="form-control"
                                    value="{{ $user->phonenumber ?? '070-XXXX-XXXX' }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted">Date of Birth</label>
                                <input type="text" class="form-control" value="{{ $user->birthday ?? '誕生日' }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Address Information</span>
                        <a href="{{ route('mypage.editadress') }}" class="btn btn-primary btn-sm">Edit Profile</a>
                    </div>


                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="row mb-3">
                                    <label class="form-label text-muted">Street Adress</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->street_adress ?? 'じゅうしょ' }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="" class="form-label text-muted">City</label>
                                    <input type="text" class="form-control" value="{{ $user->city ?? 'じゅうしょ' }}"
                                        readonly>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label text-muted">State/Province</label>
                                    <input type="text" class="form-control" value="{{ $user->city ?? 'じゅうしょ' }}"
                                        readonly>
                                </div>
                                <div class="col-4">
                                    <label for="" class="form-label text-muted">Postal Code</label>
                                    <input type="text" class="form-control" value="{{ $user->city ?? 'じゅうしょ' }}"
                                        readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="" class="form-label text-muted">Country</label>
                                    <input type="text" class="form-control" value="{{ $user->city ?? 'じゅうしょ' }}"
                                        readonly>
                                </div>
                            </div>





                        </div>
                    </div>


                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
                        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
                    </script>
</body>

</html>
