  @extends('layouts.staff')

  @section('title', 'reservations.hotel.details')

  @section('content')

      <div class="container">
          {{-- Header --}}
          <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="d-flex align-items-center gap-3">
                  <h3 class="page-title"><i class="fa-regular fa-calendar-check"></i>  Guest Details</h3>
              </div>
              <div class="d-flex gap-2">
                  <span class="badge date-badge">
                    {{ $reservation->start_at->format('Y-m-d') }}
                     to 
                    {{ $reservation->end_at->format('Y-m-d') }}
                    </span>
                  <button class="but btn-cancel" type="button">Cancel Reservation</button>
              </div>
          </div>
          <div class="row">
              {{-- Main Card --}}
              <div class="col-md-8">
                  <div class="card shadow-sm main-card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                          <div>
                              <strong>Reservation ID:</strong>{{ $reservation->reservation_id }}
                              <span class="text-muted ms-2">| Check-in 
                                {{ $reservation->start_at->diffInDays(now()) }}
                                 days</span>
                          </div>
                          
                      </div>
                      <table class="table table-bordered table-striped mb-0">
                          <thead>
                              <tr class="table-head table-primary text-uppercase">
                                  <th style="width:40%">Item</th>
                                  <th>Details</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>

                                  {{-- detail --}}
                                  <td><i class="table-icon fa-solid fa-user-tie"></i> Guest Name</td>
                                   
                                  <td>
                                    {{ $reservation->user->name}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-regular fa-envelope"></i> Email</td>
                                  <td>
                                    {{ $reservation->user->email }}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-phone"></i> Phone Number</td>
                                  <td>
                                    {{ optional($reservation->user->detail)->phone ?? '-'}}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-clipboard-list"></i> Reservation ID</td>
                                  <td>
                                    {{ $reservation->reservation_id }}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-calendar-days"></i> Stay Period</td>
                                  <td>
                                    {{ $reservation->start_at ->format('Y-m-d') }}
                                     to 
                                     {{ $reservation->end_at->format('Y-m-d') }}
                                    </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-bed"></i> Room & Guests</td>
                                  <td>
                                    {{ $reservation->room->name }}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-users"></i> Number of Guest</td>
                                  <td>
                                    {{ $reservation->guests }}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-money-check-dollar"></i> Total Price</td>
                                  <td>${{ number_format($reservation->total_price) }}</td>
                              </tr>



                          </tbody>
                      </table>
                      <div class="card-footer d-flex justify-content-between">
                          <button class="btn btn-print" onclick="window.print()">Print Confirmation</button>
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
                      <div class="card-body" style="min-height: 120px">
                        {{ $reservation->note ?? '' }}
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

  /* 印刷機能 */
  @media print {
    /* 画面用のヘッダーやナビは非表示 */
    nav,
    .btn,
    .btn-cancel,
    .btn-print,
    .btn-send,
    .btn-add,
    .btn-edit {
      display: none !important;
    }
    /* 背景を白にする */
    body {
      background: #ffffff !important;
    }

    /* コンテンツを紙いっぱいに表示 */
    .container {
      max-width: 100% !important;
      margin: 0 !important;
      padding: 0 !important;
    }
    /* カードを印刷向けに */
  .card {
    box-shadow: none !important;
    border: 1px solid #ccc;
    page-break-inside: avoid;
  }

  /* Notes を下に回す（横並び回避） */
  .col-md-8,
  .col-md-4 {
    width: 100% !important;
  }

  /* テーブルをくっきり */
  table {
    border-collapse: collapse !important;
  }

  th,
  td {
    border: 1px solid #999 !important;
    color: #000 !important;
  }

  }

  </style>
 
  
