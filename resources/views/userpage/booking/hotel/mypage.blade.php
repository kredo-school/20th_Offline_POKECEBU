@extends('layouts.user')

@push('styles')
 
     <link rel="stylesheet" href="{{ asset('css/user.css/hotel/main-style.css') }}">
     <link rel="stylesheet" href="{{ asset('css/user.css/hotel/mypage.css') }}">
@endpush

@section('content')
<div class="mypage py-5">

    <div class="page-header">
        <h1 class="page-title">My Page</h1>
        <div class="page-title-line"></div>
    </div>

    @if (session('success'))
        <div class="alert-success-bar">{{ session('success') }}</div>
    @endif

    <div class="form-container">
        <form method="POST" action="{{ route('user.mypage.update') }}">
            @csrf

            <div class="form-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-user me-2"></i>Personal Information
                </h2>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">First Name</label>
                        <input type="text" name="first_name" class="field-input"
                            value="{{ $userDetail->first_name ?? '' }}" required>
                    </div>
                    <div class="field-group">
                        <label class="field-label">Last Name</label>
                        <input type="text" name="last_name" class="field-input"
                            value="{{ $userDetail->last_name ?? '' }}" required>
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">Birthday</label>
                        <input type="date" name="birthday" class="field-input"
                            value="{{ $userDetail->birthday ?? '' }}">
                    </div>
                    <div class="field-group">
                        <label class="field-label">Phone</label>
                        <input type="text" name="phone" class="field-input"
                            value="{{ $userDetail->phone ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-house me-2"></i>Address
                </h2>

                <div class="field-group">
                    <label class="field-label">Street</label>
                    <input type="text" name="street_address" class="field-input" placeholder="Street"
                        value="{{ $userDetail->street_address ?? '' }}">
                </div>
                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label">City</label>
                        <input type="text" name="city" class="field-input" placeholder="City"
                            value="{{ $userDetail->city ?? '' }}">
                    </div>
                    <div class="field-group">
                        <label class="field-label">State</label>
                        <input type="text" name="state" class="field-input" placeholder="State"
                            value="{{ $userDetail->state ?? '' }}">
                    </div>
                </div>
                <div class="field-group">
                    <label class="field-label">Postal Code</label>
                    <input type="text" name="postal_code" class="field-input" placeholder="Postal Code"
                        value="{{ $userDetail->postal_code ?? '' }}">
                </div>
            </div>

            <div class="form-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-users me-2"></i>Additional Guests
                </h2>

                <div id="other-guests-wrapper">
                    @php
                        $sessionGuests = session('other_guests', []);
                        $guestIndex = 0;
                    @endphp

                    @foreach ($sessionGuests as $guest)
                        <div class="other-guest shadow-sm border-0">
                            <div class="guest-number">Guest {{ $guestIndex + 1 }}</div>
                            <div class="mb-2">
                                <input type="text" name="other_guests[{{ $guestIndex }}][name]"
                                    class="field-input mb-2" placeholder="Full Name"
                                    value="{{ $guest['name'] ?? '' }}">
                            </div>
                            <div class="field-row">
                                <input type="email" name="other_guests[{{ $guestIndex }}][email]"
                                    class="field-input" placeholder="Email"
                                    value="{{ $guest['email'] ?? '' }}">
                                <input type="text" name="other_guests[{{ $guestIndex }}][phone]"
                                    class="field-input" placeholder="Phone"
                                    value="{{ $guest['phone'] ?? '' }}">
                            </div>
                        </div>
                        @php $guestIndex++; @endphp
                    @endforeach

                    @if (count($sessionGuests) === 0)
                        <div class="other-guest shadow-sm border-0">
                            <div class="guest-number">Guest 1</div>
                            <input type="text" name="other_guests[0][name]"
                                class="field-input mb-2" placeholder="Full Name">
                            <div class="field-row">
                                <input type="email" name="other_guests[0][email]"
                                    class="field-input" placeholder="Email">
                                <input type="text" name="other_guests[0][phone]"
                                    class="field-input" placeholder="Phone">
                            </div>
                        </div>
                        @php $guestIndex = 1; @endphp
                    @endif
                </div>

                <button type="button" id="add-guest" class="add-guest-btn mt-2">
                    <i class="fa-solid fa-plus me-1"></i> Add Another Guest
                </button>
            </div>

            <div class="pt-3">
                <button type="submit" class="save-btn">Save Changes</button>
            </div>
        </form>
    </div>

</div>

<script>
    let guestIndex = {{ $guestIndex }};
    document.getElementById('add-guest').addEventListener('click', function() {
        const wrapper = document.getElementById('other-guests-wrapper');
        const div = document.createElement('div');
        div.classList.add('other-guest', 'shadow-sm', 'border-0');
        div.innerHTML = `
            <div class="guest-number">Guest ${guestIndex + 1}</div>
            <input type="text" name="other_guests[${guestIndex}][name]" class="field-input mb-2" placeholder="Full Name">
            <div class="field-row">
                <input type="email" name="other_guests[${guestIndex}][email]" class="field-input" placeholder="Email">
                <input type="text" name="other_guests[${guestIndex}][phone]" class="field-input" placeholder="Phone">
            </div>
        `;
        wrapper.appendChild(div);
        guestIndex++;
    });
</script>
@endsection