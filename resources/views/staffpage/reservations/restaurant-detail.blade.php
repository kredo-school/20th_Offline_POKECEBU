  @extends('layouts.staff')

  @section('title', 'reservations.resraurant.detail')

  @section('content')

      <div class="container">
          {{-- Header --}}
          <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="d-flex align-items-center gap-3">
                  <h3 class="page-title"><i class="fa-regular fa-calendar-check"></i>  Restaurant Gest Details</h3>
              </div>
              <div class="d-flex gap-2">
                  <span class="badge date-badge">{{ $reservation->start_at->format('Y-m-d') }}</span>
                  <button class="but btn-cancel">Cancel Reservation</button>
              </div>
          </div>
          <div class="row">
              {{-- Main Card --}}
              <div class="col-md-8">
                  <div class="card shadow-sm main-card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                          <div>
                              <strong>Reservation ID:</strong>19840514
                              <span class="text-muted ms-2">| Start Time 18:00</span>
                          </div>
                          
                      </div>
                      <table class="table table-bordered table-striped mb-0">
                          <thead>
                              <tr class="table-head table-primary text-uppercase">
                                  <th style="width:40%">Item</th>
                                  <th>Detals</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>

                                  {{-- detail --}}
                                  <td><i class="table-icon fa-solid fa-user-tie"></i> Guest Name</td>
                                  
                                  <td>{{ $reservation->user->name}}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-phone"></i> Phone Number</td>
                                  <td>{{ optional($reservation->user->detail)->phone ?? '-'}}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-clipboard-list"></i> Reservation ID</td>
                                  <td> {{ $reservation->reservation_id }}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-calendar-days"></i> Day & Time</td>
                                  <td> {{ $reservation->start_at ->format('Y-m-d') }}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-users"></i></i> Number of Guests</td>
                                  <td> {{ $reservation->guests }}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-file-pen"></i></i> Status</td>
                                  <td>Confirmed</td>
                              </tr>

                              {{-- phpの閉じタグを入れる　メモ3 --}}


                          </tbody>
                      </table>
                      <div class="card-footer d-flex justify-content-between">
                          <button class="btn btn-print">Print Confirmation</button>
                          <button class="btn btn-send">Send Confirmation</button>
                      </div>


                  </div>
              </div>
              {{-- Notes Panel --}}
              <div class="col-md-4">
                  <div class="card shadow-sm notes-card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                          <h5 class="mb-0">Notes</h5>
                      </div>
                      <ul class="list-group list-group-flush">
                          <li class="list-group-item">2 Adults, 2Children</li>
                          <li class="list-group-item">Two high chairs required</li>
                          <li class="list-group-item">Birthday cake required</li>
                      </ul>
                      <div class="card-footer d-flex justify-content-between">
                          <button class="btn btn-add">+ Add Note</button>
                          <button class="btn btn-edit">Edit</button>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  @endsection


  {{-- CSS --}}
<style>
  .page-title {
    font-weight: 600;
    color: #3b5b6b;
  }

  .table-icon {
    color: #3b5b6b;
  }

  .main-card {
    border-radius: 16px;
    overflow: hidden;
  }

  .notes-card {
    border-radius: 16px;
    background: #fff6ee;
  }

  .badge.date-badge {
    background: #b7e1da;
    color: #234;
    padding: 8px 12px;
    border-radius: 12px;
  }

 
  .btn-cancel {
    background: #fdbf79;
    color: #fff;
    border-radius: 12px;
    border: none;
  }

  .btn-print {
    background: #8dbcda;
    color: #fff;
    border-radius: 12px;
  }

  .btn-send {
    background: #96ccb9;
    color: #fff;
    border-radius: 12px;
  }

  .btn-add {
    background: #b7e1da;
    color: #fff;
    border-radius: 12px;
  }

  .btn-edit {
    background: #6fa9de;
    color: #fff;
    border-radius: 12px;
  }

  </style>
 
  
