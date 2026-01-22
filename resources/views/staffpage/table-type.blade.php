@extends('layouts.staff')

@section('content')
<div class="container-fluid">
  <div class="row">
    {{-- サイドバー --}}
    <div class="col-md-3 col-lg-2 bg-light border-end min-vh-100 py-4">
      <h5 class="px-3 mb-4"><i class="fa-solid fa-gear me-2"></i>Settings</h5>
      <ul class="nav flex-column px-3">
        <li class="nav-item mb-2">
          <a class="nav-link" href="#">
            <i class="fa-solid fa-hotel me-2"></i>Hotels
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="btn btn-outline-secondary" href="#">
            <i class="fa-solid fa-utensils me-2"></i>Restaurants
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="#">
            <i class="fa-solid fa-calendar-check me-2"></i>Reservations
          </a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="#">
            <i class="fa-solid fa-sliders me-2"></i>Settings
          </a>
        </li>
      </ul>
    </div>

    {{-- メインコンテンツ --}}
    <div class="col-md-9 col-lg-10 py-4">
      <div class="d-flex justify-content-between align-items-center mb-4">
        <h3><i class="fa-solid fa-chair me-2"></i>Table Types Overview</h3>
        {{-- <a href="#" class="btn" style="background-color: #ff7f50; color: white;"> --}}
        <a href="#" class="btn btn-primary" >
          <i class="fa-solid fa-plus me-1"></i>Add Table Type
        </a>
      </div>

      {{-- 検索バー --}}
      <form class="input-group mb-3" method="GET" action="#">
        <input type="text" name="search" class="form-control" placeholder="Search table type...">
        <button class="btn btn-outline-secondary" type="submit">
          <i class="fa-solid fa-magnifying-glass"></i>
        </button>
      </form>

      {{-- テーブル --}}
      <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
          <thead class="table-light">
            <tr>
              <th>#</th>
              <th>Table Type</th>
              <th>Total Tables</th>
              <th>Reserved</th>
              <th>Available</th>
              <th>Unavailable</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Standard 4-Seater</td>
              <td>15</td>
              <td>
                <a href="#" class="btn btn-sm text-white btn-warning">
                  8
                </a>
              </td>
              <td>
                <a href="#" class="btn btn-sm btn-success">
                  6
                </a>
              </td>
              <td>
                <a href="#" class="btn btn-sm btn-danger">
                  1
                </a>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>Outdoor 2-Seater</td>
              <td>10</td>
              <td>
                <a href="#" class="btn btn-sm text-white btn-warning">
                  5
                </a>
              </td>
              <td>4</td>
              <td>1</td>
            </tr>
            <tr>
              <td>3</td>
              <td>Private Room</td>
              <td>5</td>
              <td>
                <a href="#" class="btn btn-sm text-white btn-warning">
                  3
                </a>
              </td>
              <td>1</td>
              <td>1</td>
            </tr>
            <tr class="table-secondary fw-bold">
              <td colspan="2">Total</td>
              <td>30</td>
              <td>16</td>
              <td>11</td>
              <td>3</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection