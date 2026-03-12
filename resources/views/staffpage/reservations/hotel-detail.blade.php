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
                  <button type="button" class="btn btn-send btn-outline-danger">Cancel Reservation</button>
              </div>
          </div>
          <div class="row">
              {{-- Main Card --}}
              <div class="col-md-8">
                  <div class="card shadow-sm main-card">
                      <div class="card-header d-flex justify-content-between align-items-center">
                          <div>
                              <strong>Reservation ID:</strong>{{ $reservation->reservation_id }}
                              
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
                                  <td><i class="table-icon fa-solid fa-clipboard-list"></i> Check in</td>
                                  <td>
                                    {{ $reservation->start_at ->format('Y-m-d') }}
                                </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-calendar-days"></i> Check out</td>
                                  <td>
                                   {{ $reservation->end_at->format('Y-m-d') }}
                                    </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-calendar-days"></i> Nights</td>
                                  <td>
                                   {{ $reservation->start_at->diffInDays($reservation->end_at) }}
                                 days
                                    </td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-bed"></i> Room & Guests</td>
                                  <td>
                                    {{ $reservation->room->type->name }}
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
                                  <td>{{ number_format($reservation->total_price) }}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-solid fa-money-check-dollar"></i> Cancellation Fee</td>
                                  <td>{{ number_format($reservation->hotel->cancellation_fee) }}</td>
                              </tr>



                          </tbody>
                      </table>
                      <div class="card-footer d-flex justify-content-end">
                          <button class="btn btn-print btn-outline-primary" onclick="window.print()">Print Confirmation</button>
                          
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
                        {{ $reservation->other ?? '' }}
                      </div>
                      
                  </div>
              </div>
          </div>
      </div>
       

  @endsection

<style>
  
  /* 印刷機能 */
  @media print {
      /* ヘッダーやナビは非表示 */
      nav,
      .btn,
      .btn-cancel,
      .btn-print,
      .btn-send,
      .btn-add,
      .btn-edit {
        display: none !important;
      }

      /* 紙いっぱいに表示 */
      .container {
        max-width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
      }

    th,
    td {
      border: 1px solid #999 !important;
      color: #000 !important;
    }
  }

  </style>
 

