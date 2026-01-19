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

</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm rounded-4">
                <div class="card-header fw-semibold">
                    Personal Information
                </div>

                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small">First Name</label>
                            <input type="text" class="form-control" value="{{ $user->first_name ?? '田原' }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Last Name</label>
                            <input type="text" class="form-control" value="{{ $user->last_name ?? '志穏' }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label text-muted small">Email</label>
                            <input type="text" class="form-control"
                                value="{{ $user->email ?? 'shi****928@gmail.com' }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label text-muted small">Phone</label>
                            <input type="text" class="form-control"
                                value="{{ $user->phonenumber ?? '070-XXXX-XXXX' }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label text-muted small">Date of Birth</label>
                            <input type="text" class="form-control" value="{{ $user->birthday ?? '誕生日' }}">
                        </div>
                    </div>


                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="button" class="btn btn-outline-secondary px-4" onclick="history.back()">
                            Back
                        </button>

                        <button class="btn btn-primary px-4">
                            Save
                        </button>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

</html>
