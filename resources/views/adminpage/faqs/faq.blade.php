@extends('layouts.user')

@section('title', 'FAQ')

@section('content')

<div class="faq-body pb-5" style="min-height: 100vh;">
    <div class="container">
        <div class="top-photo"><h1>FAQ</h1></div>
        <div class="d-flex justify-content-between align-items-center mb-4">
            @if (Auth::user()->role_id == $role_admin)
                <a href="{{ route('admin.faq.displayList') }}" class="btn btn-outline-secondary btn-sm shadow-sm">
                    <i class="fa-solid fa-pen"></i> FAQ details
                </a>    
            @endif
        </div>

        <div class="row g-4">
            {{-- 左：カテゴリー選択 --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-3">
                    <h6 class="fw-bold mb-3 text-muted px-2">Categories</h6>
                    <div class="nav flex-column nav-pills" id="v-pills-tab">
                        @foreach($all_categories as $index => $category)
                            <button
                                class="nav-link text-start rounded-3 mb-2 category-btn {{ $index === 0 ? 'active' : 'text-dark hover-bg-light' }}"
                                data-category-id="{{ $category->id }}" 
                                data-category-name="{{ $category->name }}">
                                <i class="fa-solid fa-tag me-2 opacity-50"></i>{{ $category->name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- 中央：FAQリスト（アコーディオン） --}}
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="bg-white p-4 border-bottom">
                        <h4 class="fw-bold mb-0 text-primary" id="faq-title">{{ $first_category->name }}</h4>
                    </div>

                    <div class="p-3" id="faq-content" style="max-height: 70vh; overflow-y: auto;">
                        @if ($first_category->faqs->count() == 0)
                            <div class="text-center py-5">
                                <i class="fa-solid fa-folder-open fa-3x text-light mb-3"></i>
                                <p class="text-muted">No questions found in this category.</p>
                            </div>
                        @else
                            <div class="accordion accordion-flush" id="faqAccordion">
                                @foreach($first_category->faqs as $faq)
                                    <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $faq->id }}">
                                                <span class="text-primary me-2">Q.</span> {{ $faq->question }}
                                            </button>
                                        </h2>
                                        <div id="faq-{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body bg-light-subtle border-top text-muted">
                                                <div class="d-flex">
                                                    <span class="fw-bold text-danger me-2">A.</span>
                                                    <div>{{ $faq->answer }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 右：コンタクトフォーム --}}
            <div class="col-lg-3">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Still need help?</h5>
                    <p class="small text-muted mb-4">If you can't find your answer, please feel free to contact us.</p>

                    <form>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Company Name</label>
                            <input type="text" class="form-control form-control-sm bg-light border-0 px-3 py-2" placeholder="Your company">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Email Address</label>
                            <input type="email" class="form-control form-control-sm bg-light border-0 px-3 py-2" placeholder="name@example.com">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Inquiry Details</label>
                            <textarea class="form-control form-control-sm bg-light border-0 px-3 py-2" rows="5" placeholder="How can we help?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                            Send Message
                        </button>
                    </form>
                </div>
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
                btn.classList.remove('active', 'btn-primary');
                btn.classList.add('text-dark');
            });

            button.classList.add('active');
            button.classList.remove('text-dark');

            faqTitle.textContent = button.dataset.categoryName;
            const categoryId = button.dataset.categoryId;
            const category = categories.find(c => c.id == categoryId);

            faqContent.innerHTML = '';

            if (!category.faqs || category.faqs.length === 0) {
                faqContent.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fa-solid fa-folder-open fa-3x text-light mb-3"></i>
                        <p class="text-muted">No questions found in this category.</p>
                    </div>`;
                return;
            }

            let accordionHtml = '<div class="accordion accordion-flush" id="faqAccordion">';
            category.faqs.forEach(faq => {
                accordionHtml += `
                    <div class="accordion-item border-0 mb-2 shadow-sm rounded-3 overflow-hidden">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-${faq.id}">
                                <span class="text-primary me-2">Q.</span> ${faq.question}
                            </button>
                        </h2>
                        <div id="faq-${faq.id}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body bg-light-subtle border-top text-muted">
                                <div class="d-flex">
                                    <span class="fw-bold text-danger me-2">A.</span>
                                    <div>${faq.answer}</div>
                                </div>
                            </div>
                        </div>
                    </div>`;
            });
            accordionHtml += '</div>';
            faqContent.innerHTML = accordionHtml;
        });
    });
</script>

<style>
    .faq-body {
        background: linear-gradient(180deg,
        #fbfbe9 0%,
        #f9f9ee 50%,
        #ffffff 100%);
    }
    /* アコーディオンの矢印の色などを微調整 */
    .accordion-button:not(.collapsed) {
        background-color: transparent;
        color: inherit;
        box-shadow: none;
    }
    .accordion-button:focus {
        box-shadow: none;
        border-color: rgba(0,0,0,.125);
    }
    .category-btn.active {
        background-color: #0d6efd !important;
        color: white !important;
    }
    .hover-bg-light:hover {
        background-color: #f8f9fa;
    }
    /* スクロールバーのカスタマイズ（任意） */
    #faq-content::-webkit-scrollbar {
        width: 6px;
    }
    #faq-content::-webkit-scrollbar-thumb {
        background-color: #ddd;
        border-radius: 10px;
    }

    .top-photo {
        width: 100%;
        height: 200px;
        margin-bottom: 20px;
        background-image: url("{{ asset('images/home-faq.jpg') }}");
        background-size: cover;
        background-position: center 50%;
        background-repeat: no-repeat;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-align: center;
        background-color: rgba(0, 0, 0, 0.1); 
        background-blend-mode: multiply;
    }

    .top-photo h1 {
        font-size: 3em;
        font-weight: bold;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.6);
        margin: 0;
        position: relative; 
        z-index: 2;
    }
</style>

@endsection