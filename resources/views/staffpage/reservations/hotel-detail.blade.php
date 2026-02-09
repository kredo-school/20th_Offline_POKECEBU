  @extends('layouts.staff')

  @section('title', 'reservations.hotel.detail')

  @section('content')

      <div class="container">
          {{-- Header --}}
          <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="d-flex align-items-center gap-3">
                  <h3 class="page-title"><i class="fa-regular fa-calendar-check"></i>  Gest Details</h3>
              </div>
              <div class="d-flex gap-2">
                  <span class="badge date-badge">2030-5-13
                    {{-- {{ $reservetion->start_at->format('Y-m-d') }} --}}
                     to 2030-5-14
                     {{-- {{ $reservation->end_at->format('Y-m-d') }} --}}
                    </span>
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
                              <span class="text-muted ms-2">| Chack-in 1 days</span>
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
                                  {{-- 内容を入れる　メモ２ --}}
                                  <td>Mark Zuckerberg
                                    {{-- {{ $reservation->user->username }} --}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-regular fa-envelope"></i> Email</td>
                                  <td>Meta-love.gmail.com
                                    {{-- {{ $reservation->user->email }} --}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-phone"></i> Phone Number</td>
                                  <td>123-456-7890
                                    {{-- {{ $reservation->user->detail->phone }} --}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-clipboard-list"></i> Reservation ID</td>
                                  <td>19840514
                                    {{-- {{ $reservation->reservation_id }} --}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-calendar-days"></i> Stay Period</td>
                                  <td>2030-5-13
                                    {{-- {{ $reservetion->start_at ->format('Y-m-d') }} --}}
                                     to 2030-5-14
                                     {{-- {{ $reservetion->end_at->format('Y-m-d') }} --}}
                                    </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-bed"></i> Room & Guests</td>
                                  <td>tottemo sugoi room
                                    {{-- {{ $reservation->room_id }} --}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-users"></i> Number of Gest</td>
                                  <td>2
                                    {{-- {{ $reservation->gests }} --}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-money-check-dollar"></i> Total Price</td>
                                  <td>$999,999,999</td>
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
                          <li class="list-group-item">Guest is VIP, provide welcome basket</li>
                          <li class="list-group-item">Late check-out requested at 1 PM</li>
                          <li class="list-group-item">Arrange airport transfer</li>
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
    outline: none;
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
 
  
