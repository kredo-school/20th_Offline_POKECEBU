@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold mb-4 text-center">My Page</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('mypage.update') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" value="{{ $userDetail->first_name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" value="{{ $userDetail->last_name ?? '' }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Birthday</label>
            <input type="date" name="birthday" class="form-control" value="{{ $userDetail->birthday ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $userDetail->phone ?? '' }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <input type="text" name="street_address" class="form-control" placeholder="Street" value="{{ $userDetail->street_address ?? '' }}">
            <input type="text" name="city" class="form-control mt-1" placeholder="City" value="{{ $userDetail->city ?? '' }}">
            <input type="text" name="state" class="form-control mt-1" placeholder="State" value="{{ $userDetail->state ?? '' }}">
            <input type="text" name="postal_code" class="form-control mt-1" placeholder="Postal Code" value="{{ $userDetail->postal_code ?? '' }}">
        </div>

        <!-- 追加ゲスト情報（セッションから取得して表示） -->
        <div class="mb-4">
            <h5>Additional Guests</h5>
            <div id="other-guests-wrapper">
                @php
                    $sessionGuests = session('other_guests', []);
                    $guestIndex = 0;
                @endphp

                @foreach($sessionGuests as $guest)
                    <div class="other-guest mb-2">
                        <input type="text" name="other_guests[{{ $guestIndex }}][name]" class="form-control mb-1" placeholder="Full Name" value="{{ $guest['name'] ?? '' }}">
                        <input type="email" name="other_guests[{{ $guestIndex }}][email]" class="form-control mb-1" placeholder="Email" value="{{ $guest['email'] ?? '' }}">
                        <input type="text" name="other_guests[{{ $guestIndex }}][phone]" class="form-control" placeholder="Phone" value="{{ $guest['phone'] ?? '' }}">
                    </div>
                    @php $guestIndex++; @endphp
                @endforeach

                @if(count($sessionGuests) === 0)
                    <div class="other-guest mb-2">
                        <input type="text" name="other_guests[0][name]" class="form-control mb-1" placeholder="Full Name">
                        <input type="email" name="other_guests[0][email]" class="form-control mb-1" placeholder="Email">
                        <input type="text" name="other_guests[0][phone]" class="form-control" placeholder="Phone">
                    </div>
                    @php $guestIndex = 1; @endphp
                @endif
            </div>

            <button type="button" id="add-guest" class="btn btn-secondary btn-sm mt-2">Add Another Guest</button>
        </div>

        <button type="submit" class="btn btn-primary w-100">Save</button>
    </form>
</div>

<script>
let guestIndex = {{ $guestIndex }};
document.getElementById('add-guest').addEventListener('click', function() {
    const wrapper = document.getElementById('other-guests-wrapper');
    const div = document.createElement('div');
    div.classList.add('other-guest', 'mb-2');
    div.innerHTML = `
        <input type="text" name="other_guests[${guestIndex}][name]" class="form-control mb-1" placeholder="Full Name">
        <input type="email" name="other_guests[${guestIndex}][email]" class="form-control mb-1" placeholder="Email">
        <input type="text" name="other_guests[${guestIndex}][phone]" class="form-control" placeholder="Phone">
    `;
    wrapper.appendChild(div);
    guestIndex++;
});
</script>
@endsection
