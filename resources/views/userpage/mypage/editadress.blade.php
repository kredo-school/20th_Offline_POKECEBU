<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Title</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>
<body>
   <!-- Content Here --> 
    
    <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm rounded-4">
                <div class="card-header fw-semibold">
                    Address Information
                </div>

                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label text-muted small">Street Address</label>
                        <input type="text" class="form-control"
                            value="{{ $user->street_address ?? 'じゅうしょ' }}">
                    </div>

                    <div class="row mb-3">
                        <div class="col-4">
                            <label class="form-label text-muted small">City</label>
                            <input type="text" class="form-control"
                                value="{{ $user->city ?? 'City' }}">
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted small">State / Province</label>
                            <input type="text" class="form-control"
                                value="{{ $user->state ?? 'State' }}">
                        </div>
                        <div class="col-4">
                            <label class="form-label text-muted small">Postal Code</label>
                            <input type="text" class="form-control"
                                value="{{ $user->postal_code ?? '000-0000' }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Country</label>
                        <input type="text" class="form-control"
                            value="{{ $user->country ?? 'Japan' }}">
                    </div>

                    <div class="d-flex justify-content-end mt-4 gap-2">
                        <button type="button"
                            class="btn btn-outline-secondary px-4"
                            onclick="history.back()">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>