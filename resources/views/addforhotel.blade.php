<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Add Room (Staff)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background-color: #f4f7fa;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-card {
      max-width: 600px;
      margin: 60px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    .form-label {
      font-weight: 600;
    }
    .btn-add {
      background-color: #3b82f6;
      color: #fff;
    }
    .btn-add:hover {
      background-color: #2563eb;
    }
    .btn-cancel {
      border: 1px solid #3b82f6;
      color: #3b82f6;
    }
    .btn-cancel:hover {
      background-color: #e0e7ff;
    }
  </style>
</head>
<body>

  <div class="form-card">
    <h3 class="mb-4"><i class="fa-solid fa-bed me-2"></i>Add Room</h3>

    <form action="#" method="POST" onsubmit="return false;">
      <div class="row mb-3">
        <div class="col-12">
          <label class="form-label">Room Type <span class="text-danger">*</span></label>
          <input type="text" class="form-control" placeholder="e.g. Standard Twin">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12">
          <label class="form-label">Room Category <span class="text-danger">*</span></label>
          <input type="text" class="form-control" placeholder="e.g. Non-smoking">
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12">
          <label class="form-label">Total Rooms <span class="text-danger">*</span></label>
          <input type="number" class="form-control" placeholder="e.g. 10">
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12 mb-3">
          <button type="submit" class="btn btn-add w-100">
            <i class="fa-solid fa-plus-circle me-1"></i>Add
          </button>
        </div>
        <div class="col-12 mb-3">
          <button type="button" class="btn btn-cancel w-100">
            <i class="fa-solid fa-xmark me-1"></i>Cancel
          </button>
        </div>
      </div>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>