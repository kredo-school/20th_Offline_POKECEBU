@extends('layouts.user')

@section('title', 'FAQ')

@section('content')


    <div class="container-fluid py-3">
        <h3 class="mb-2">FAQ</h3>
        @if (Auth::user()->role_id == $role_admin)
            <a href="{{ route('admin.faq.displayList') }}" class="btn btn-secondary mb-2"><i class="fa-solid fa-pen"></i> FAQ details</a>    
        @endif
        <div class="row justify-content-center g-3">
            {{-- Left menu --}}
            <div class="col-md-3">
                <div class="bg-light rounded-4 p-3 shadow-sm scroll-box faq-row">
                    <h5 class="fw-bold mb-3">Categories</h5>
                    <div class="list-group">
                        @foreach($all_categories as $index => $category)
                            <div class="mb-1">
                                <button
                                    class="list-group-item btn w-100 text-start rounded-pill mb-2 category-btn
                                                            {{ $index === 0 ? 'btn-primary text-white active' : 'btn-outline-secondary' }}"
                                    data-category-id="{{ $category->id }}" data-category-name="{{ $category->name }}">
                                    {{ $category->name }}
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Center FAQ --}}
            <div class="col-md-5">
                <div class="bg-white rounded-4 shadow-sm scroll-box faq-row">

                    {{-- sticky header --}}
                    <div class="p-4 border-bottom bg-white sticky-top">
                        <h4 class="fw-bold mb-0" id="faq-title">{{ $first_category->name }}</h4>
                    </div>

                    {{-- scroll content --}}
                    <div class="p-4" id="faq-content">
                        @if ($first_category->faqs->count() == 0)
                            <p class="text-muted text-center">No data</p>
                        @else
                            @foreach($first_category->faqs as $faq)
                                <div class="mb-4">
                                    <p class="fw-semibold mb-1">
                                        Q : {{ $faq->question }}
                                    </p>
                                    <p class="text-muted mb-0">
                                        A : {{ $faq->answer }}
                                    </p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Contact --}}
            <div class="col-md-3">
                <div class="bg-primary bg-opacity-10 rounded-4 p-3 shadow-sm faq-row">
                    <h5 class="fw-bold mb-3">Contact Us</h5>

                    <div class="mb-3">
                        <input type="text" class="form-control rounded-3" placeholder="Company Name">
                    </div>

                    <div class="mb-3">
                        <input type="email" class="form-control rounded-3" placeholder="Email Address">
                    </div>

                    <div class="mb-3">
                        <textarea class="form-control rounded-3" rows="8" placeholder="Inquiry Details"></textarea>
                    </div>

                    <button class="btn btn-primary w-100 rounded-pill py-2">
                        Send
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const categories = @json($all_categories);

        const buttons = document.querySelectorAll('.category-btn');
        const faqTitle = document.getElementById('faq-title');
        const faqContent = document.getElementById('faq-content');

        buttons.forEach(button => {
            button.addEventListener('click', () => {
                buttons.forEach(btn => {
                    btn.classList.remove('btn-primary', 'text-white', 'active');
                    btn.classList.add('btn-outline-secondary');
                });

                button.classList.add('btn-primary', 'text-white', 'active');
                button.classList.remove('btn-outline-secondary');

                faqTitle.textContent = button.dataset.categoryName;

                const categoryId = button.dataset.categoryId;
                const category = categories.find(c => c.id == categoryId);

                faqContent.innerHTML = '';

                if (!category.faqs || category.faqs.length === 0) {
                    faqContent.innerHTML = `<p class="text-muted text-center">No data</p>`;
                    return;
                }

                category.faqs.forEach(faq => {
                    faqContent.innerHTML += `
                        <div class="mb-4">
                            <p class="fw-semibold mb-1">
                                Q : ${faq.question}
                            </p>
                            <p class="text-muted mb-0">
                                A : ${faq.answer}
                            </p>
                        </div>
                        `;
                });
            });
        });
    </script>

    <style>
        .faq-row {
            height: 70vh;
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

@endsection