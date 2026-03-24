  @extends('layouts.staff')

  @section('title', 'resraurant.detail')

  @section('content')

      <div class="container  mt-4">
          <a href="{{ route('restaurant.reservations.date', $reservation->start_at->format('Y-m-d')) }}"
              class="btnbtn-sm mt-4 text-decoration-none text-dark">
              <i class="fa-solid fa-arrow-left"></i> Reservation List
          </a>
          {{-- Header --}}
          <div class="card shadow-sm mb-3">
              <div class="card-body d-flex justify-content-between align-items-center">

                  <div>
                      <h3 class="mb-1">
                          <i class="fa-regular fa-calendar-check"></i>
                          Reservation Detail #<span onclick="copyReservation()"
                              style="cursor: pointer; text-decoration:underline"
                              title="Click to copy">{{ $reservation->reservation_id }}</span>
                      </h3>

                      <small class="text-muted">
                          {{ $reservation->start_at->format('Y/m/d') }}
                          |
                          {{ $reservation->start_at->format('H:i') }}
                      </small>
                  </div>

                  <button class="btn btn-danger">
                      Cancel Reservation
                  </button>
              </div>
          </div>

          {{-- Main Card --}}
          <div class="row">
              <div class="col-md-8">
                  <div class="card shadow-sm main-card">
                      {{-- detail --}}
                      <table class="table table-bordered mb-0">

                          <tbody>
                              <tr class="table-primary">
                                  <td colspan="2"><strong>Guest Information</strong></td>
                              </tr>

                              <tr>
                                  <td><i class="fa-solid fa-user"></i> Guest Name</td>
                                  <td>{{ $reservation->user->name }}</td>
                              </tr>

                              <tr>
                                  <td><i class="fa-solid fa-phone"></i> Phone</td>
                                  <td>{{ optional($reservation->user->detail)->phone ?? '-' }}</td>
                              </tr>
                              <tr>
                                  <td><i class="table-icon fa-regular fa-envelope"></i> Email</td>
                                  <td>
                                      {{ $reservation->user->email }}
                                  </td>
                              </tr>

                              <tr class="table-primary">
                                  <td colspan="2"><strong>Reservation Details</strong></td>
                              </tr>

                              <tr>
                                  <td><i class="fa-solid fa-calendar"></i> Date</td>
                                  <td>{{ $reservation->start_at->format('Y/m/d') }}</td>
                              </tr>

                              <tr>
                                  <td><i class="fa-solid fa-clock"></i> Time</td>
                                  <td>{{ $reservation->start_at->format('H:i') }}</td>
                              </tr>

                              <tr>
                                  <td><i class="fa-solid fa-chair"></i> Table</td>
                                  <td>{{ $reservation->table?->type?->name }}</td>
                              </tr>

                              <tr>
                                  <td><i class="fa-solid fa-users"></i> Guests</td>
                                  <td>{{ $reservation->guests }}</td>
                              </tr>

                          </tbody>
                      </table>
                      <div class="card-footer d-flex justify-content-end bg-light">

                          {{-- <a href="{{  route('restaurant.reservations.date', ['date' => $reservation->start_at->format('Y-m-d')])}}"class="btn btn-secondary">Back</a> --}}
                          <button class="btn btn-print btn-outline-primary" onclick="window.print()">Print
                              Confirmation</button>

                      </div>
                  </div>
              </div>
              {{-- Notes Panel --}}
              <div class="col-md-4">
                  <div class="card shadow-sm">
                      <div class="card-header">
                          <h5 class="mb-0"><i class="fa-solid fa-note-sticky"></i> Notes</h5>
                      </div>
                      <div class="card-body" style="min-height: 120px">
                          {{ $reservation->other ?? 'No notes' }}
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <script>
          function copyReservation() {
              navigator.clipboard.writeText("{{ $reservation->reservatiom_id }}");
              alert("Reservation ID copied!");
          }
      </script>


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
   @endsection
