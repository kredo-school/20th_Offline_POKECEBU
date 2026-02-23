@extends('layouts.admin')

@section('content')
    {{-- CSS: ボタン高さ揃えと表示制御 --}}
    <style>
        /* 共通：ボタンの高さを揃える */
        .action-buttons .action-btn {
            min-height: 25px;
            display: inline-flex;
            align-items: center;
            padding: 0.45rem 1rem;
        }

        /* テキストエリアの初期スタイル（非表示） */
        .reject-form .reject-input-container {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 320px;
            z-index: 1200;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
        }

        .reject-form .reject-input-container .reject-reason {
            width: 100%;
            resize: vertical;
            border-radius: 8px;
        }

        /* ホバー表示モード用 */
        .reject-form.hover-mode .reject-input-container {
            display: none;
        }

        .reject-form.hover-mode:hover .reject-input-container {
            display: block;
        }

        /* クリック表示モードで open クラスが付いたら表示 */
        .reject-form.click-mode.open .reject-input-container {
            display: block;
        }

        /* 送信ボタンの表示切替 */
        .reject-form.click-mode.open .reject-submit {
            display: inline-flex;
            margin-left: 8px;
        }

        .reject-form.click-mode.open .reject-toggle {
            display: none;
            /* トグルボタンを隠す（任意） */
        }

        /* モバイル対応：幅を狭くする */
        @media (max-width: 576px) {
            .reject-form .reject-input-container {
                width: 90vw;
                left: 5vw;
                right: auto;
            }
        }
    </style>

    <div class="container-fluid py-4">
        {{-- フラッシュメッセージ表示（追加） --}}
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif
        <div class="row">
            {{-- ホテル一覧（左側） --}}
            <div class="col-lg-3 mb-4">
                <h4 class="mb-3"><i class="fa-solid fa-building me-2"></i>Pending Hotels</h4>
                <ul class="list-group">
                    @forelse($tmpHotels as $hotel)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $hotel->name }}
                            <a href="{{ route('admin.hotel.approval.show', $hotel->id) }}"
                                class="btn btn-sm btn-outline-primary">Review</a>
                        </li>
                    @empty
                        <li class="list-group-item">No pending hotels</li>
                    @endforelse
                </ul>
            </div>

            {{-- ホテル詳細（右側） --}}
            <div class="col-lg-9">
                @if (isset($tmpHotel) && $tmpHotel)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h2 class="mb-0">{{ $tmpHotel->name }}</h2>
                                <div class="text-warning fs-5">
                                    @for ($i = 0; $i < floor($tmpHotel->star_rating ?? 0); $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                    @if (isset($tmpHotel->star_rating) && $tmpHotel->star_rating - floor($tmpHotel->star_rating) >= 0.5)
                                        <i class="fa-regular fa-star-half-stroke"></i>
                                    @endif
                                </div>
                            </div>

                            {{-- Approve / Reject ボタン群（ヘッダー内に収める） --}}
                            <div class="d-flex gap-2 align-items-center action-buttons">
                                <form method="post" action="{{ route('admin.hotel.approve', $tmpHotel->id) }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary rounded-pill action-btn">
                                        <i class="fa-solid fa-check me-1"></i> Approve
                                    </button>
                                </form>

                                <div class="reject-wrapper" style="position:relative;">
                                    <form method="post" action="{{ route('admin.hotel.reject', $tmpHotel->id) }}"
                                        class="reject-form click-mode" novalidate>
                                        @csrf

                                        <div class="reject-input-container">
                                            <textarea name="reject_reason" class="form-control reject-reason" placeholder="却下理由を入力してください" rows="3"
                                                aria-label="Reject reason"></textarea>
                                        </div>

                                        <button type="button" class="btn btn-danger rounded-pill action-btn reject-toggle">
                                            <i class="fa-solid fa-xmark me-1"></i> Reject
                                        </button>

                                        {{-- 隠し方を CSS で制御（d-none は使わない） --}}
                                        <button type="submit" class="btn btn-danger rounded-pill action-btn reject-submit">
                                            <i class="fa-solid fa-paper-plane me-1"></i> Send Reject
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- ヘッダー外：場所表示 --}}
                        <p class="mt-2"><i class="fa-solid fa-location-dot me-1"></i> {{ $tmpHotel->city ?? '—' }}</p>

                        {{-- 画像ギャラリー（重複を削除：ここで一度だけ表示） --}}
                        <div class="row mb-3">
                            @if ($tmpHotel->images && $tmpHotel->images->isNotEmpty())
                                @foreach ($tmpHotel->images as $img)
                                    <div class="col-md-6">
                                        @php
                                            // 画像パスがフル URL か相対パスかに対応
                                            $imgUrl = \Illuminate\Support\Str::startsWith($img->image, [
                                                'http://',
                                                'https://',
                                            ])
                                                ? $img->image
                                                : \Illuminate\Support\Facades\Storage::url(ltrim($img->image, '/'));
                                        @endphp
                                        <a href="{{ $imgUrl }}" target="_blank" rel="noopener noreferrer">
                                            <img src="{{ $imgUrl }}" class="img-fluid rounded mb-2" alt="Hotel Image">
                                        </a>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12">
                                    <p class="text-muted">No images uploaded.</p>
                                </div>
                            @endif
                        </div>


                        <h4 class="mt-3"><i class="fa-solid fa-circle-info me-2"></i>Hotel Details</h4>
                        {{-- 連絡先情報 --}}
                        <div class="mb-3">
                            <h5 class="mb-2"><i class="fa-solid fa-phone me-2"></i>Contact</h5>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <strong>Phone:</strong>
                                    @if (!empty($tmpHotel->phone))
                                        <a href="tel:{{ e($tmpHotel->phone) }}">{{ e($tmpHotel->phone) }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </li>
                                <li>
                                    <strong>Website:</strong>
                                    @if (!empty($tmpHotel->website))
                                        @php
                                            $site = $tmpHotel->website;
                                            if (!\Illuminate\Support\Str::startsWith($site, ['http://', 'https://'])) {
                                                $site = 'https://' . $site;
                                            }
                                        @endphp
                                        <a href="{{ e($site) }}" target="_blank"
                                            rel="noopener noreferrer">{{ e($tmpHotel->website) }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </li>
                                <li>
                                    <strong>Representative:</strong>
                                    @if (!empty($tmpHotel->representative_name))
                                        {{ e($tmpHotel->representative_name) }}
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </li>
                                <li>
                                    <strong>Representative Email:</strong>
                                    @if (!empty($tmpHotel->representative_email))
                                        <a
                                            href="mailto:{{ e($tmpHotel->representative_email) }}">{{ e($tmpHotel->representative_email) }}</a>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </li>
                            </ul>
                        </div>
                        <p>{{ $tmpHotel->description ?? 'No description provided.' }}</p>
                    </div>
                @else
                    <p>No hotel selected.</p>
                @endif
            </div>
        </div>
    </div>
    {{-- JS: クリックでトグル表示、Enter+Ctrlで送信などの補助 --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // クリックモードのトグル処理
            document.querySelectorAll('.reject-form.click-mode').forEach(function(form) {
                const toggle = form.querySelector('.reject-toggle');
                const submit = form.querySelector('.reject-submit');
                const textarea = form.querySelector('.reject-reason');

                // トグルボタンで open クラスを付ける/外す
                toggle && toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    form.classList.toggle('open');
                    if (form.classList.contains('open')) {
                        // フォーカスを textarea に移す
                        setTimeout(() => textarea && textarea.focus(), 50);
                    }
                });

                // テキストエリアで Enter+Ctrl (または Cmd) で送信できるようにする
                textarea && textarea.addEventListener('keydown', function(e) {
                    if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                        e.preventDefault();
                        // 送信ボタンが表示されていればクリック
                        if (submit) submit.click();
                    }
                });

                // フォーム送信時に空の理由を防ぐ（任意）
                form.addEventListener('submit', function(e) {
                    const val = textarea ? textarea.value.trim() : '';
                    if (!val) {
                        // 空なら確認ダイアログを出すか送信を止める
                        if (!confirm('却下理由が空です。本当に却下しますか？')) {
                            e.preventDefault();
                            return false;
                        }
                    }
                });

                // クリックモードで外側クリックで閉じる
                document.addEventListener('click', function(ev) {
                    if (!form.contains(ev.target) && form.classList.contains('open')) {
                        form.classList.remove('open');
                    }
                });
            });

            // ホバー表示モードを使う場合は .hover-mode をフォームに付けるだけで動作します
        });
    </script>
@endsection
