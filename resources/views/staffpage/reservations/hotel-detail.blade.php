  @extends('layouts.staff')

  @section('title', 'reservations.hotel.detail')

  @section('content')

    <!-- Reservation info table -->
    <h3>Gest Details</h3>

    <div class="container">
      <table class="table table-bordersd table-striped">
        <thead>
          <tr class="table-prymary text-uppercase">
            <th>Item</th>
            <th>Detals</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
          $all_users = getAllUsers();
          while ($user = $all_users->fetch_assoc()) {
          
            
          // loop1 $user = ['reservation_id'=>1, 'gest_name'=>'AAA'];
          // loop2 $user = ['reservation_id'=>1, 'email'=>'XXX.com'];
          // loop3 $user = ['reservation_id'=>1, 'Phone_number'=>'123-456-789'];etc...
          ?>

          <tr>
            <td>Guest Name</td>
            <td><?= $user['gest_name'] ?></td>
          </tr>

          <tr>
            <td>Email</td>
            <td>*</td>
          </tr>

          <tr>
            <td>Phone Number</td>
            <td>*</td>
          </tr>

          <tr>
            <td>Reservation ID</td>
            <td>*</td>
          </tr>

          <tr>
            <td>Stay Period</td>
            <td>*</td>
          </tr>

          <tr>
            <td>Room & Guests</td>
            <td>*</td>
          </tr>

          <tr>
            <td>Special Requests</td>
            <td>*</td>
          </tr>

          <tr>
            <td>Payment Status</td>
            <td>*</td>
          </tr>

          <?php
          }
          ?>

        </tbody>
      </table>
    </div>

  @endsection
