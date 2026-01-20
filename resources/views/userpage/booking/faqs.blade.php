<div class="container-fluid py-3" style="background:#eef3f7;">
    <h1 class="mb-3">FAQ</h1>

    <div class="row justify-content-center g-3">

        {{-- Left menu --}}
        <div class="col-md-3">
            <div class="bg-light rounded-4 p-3 shadow-sm scroll-box faq-row">
                <h4 class="text-center mb-3">Categories</h4>

                @php
                    // TODO: get from db
                    $categories = [
                        'Hotel Arrangements',
                        'Restaurant Arrangements',
                        'Plans / Reservations',
                        'Cancellation',
                        'Member Information',
                        'Membership Details',
                        'Support',
                    ];
                @endphp

                @foreach($categories as $index => $category)
                    <div class="mb-2">
                        <button
                            class="btn w-100 text-start rounded-pill
                            {{ $index === 1 ? 'btn-primary text-white' : 'btn-outline-secondary' }}">
                            {{ $category }}
                        </button>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Center FAQ --}}
        <div class="col-md-5">
            <div class="bg-white rounded-4 shadow-sm scroll-box faq-row">

                {{-- sticky header --}}
                <div class="p-4 border-bottom bg-white sticky-top">
                    <h4 class="fw-bold mb-0">Restaurant Arrangements</h4>
                </div>

                {{-- scroll content --}}
                <div class="p-4">
                    @for ($i = 1; $i <= 12; $i++)
                        <div class="mb-4">
                            <p class="fw-semibold mb-1">
                                Q{{ $i }}: Can I change the time?
                            </p>
                            <p class="text-muted mb-0">
                                A: Yes, you can adjust times in advance.
                                Restrictions may apply depending on plan.
                            </p>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Right Contact --}}
        <div class="col-md-3">
            <div class="bg-primary bg-opacity-10 rounded-4 p-3 shadow-sm faq-row">
                <h5 class="fw-bold mb-3">Contact Us</h5>

                <div class="mb-3">
                    <input type="text" class="form-control rounded-3"
                           placeholder="Company Name">
                </div>

                <div class="mb-3">
                    <input type="email" class="form-control rounded-3"
                           placeholder="Email Address">
                </div>

                <div class="mb-3">
                    <textarea class="form-control rounded-3" rows="8"
                              placeholder="Inquiry Details"></textarea>
                </div>

                <button class="btn btn-primary w-100 rounded-pill py-2">
                    Send
                </button>
            </div>
        </div>

    </div>
</div>

<style>
    .faq-row {
        height: 75vh;
    }

    .scroll-box {
        overflow-y: auto;
    }

    @media (max-width: 768px) {
        .faq-row {
            height: auto;
        }

        .scroll-box {
            overflow-y: visible;
        }
    }
</style>
