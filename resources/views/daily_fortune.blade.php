@extends('layouts.user')

@push('styles')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .top-photo {
            width: 100%;
            height: 200px;
            /* FAQと同じ高さに統一 */
            margin-bottom: 20px;
            background-image: url("{{ asset('images/home-fortune.jpg') }}");
            /* 好きな画像に差し替え */
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.1);
            background-blend-mode: multiply;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 105, 137, 0.2);
        }

        .top-photo h1 {
            font-size: 3.5rem;
            font-weight: 800;
            color: #ffffff;
            margin: 0;
            z-index: 2;
            letter-spacing: 1px;
            text-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        .fortune-card {
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            box-shadow: 0 20px 50px rgba(0, 80, 120, 0.15);
            padding: 10px;
            border: 1px solid rgba(255, 255, 255, 0.6);
            overflow: hidden;
            margin-bottom: 200px;
        }

        .fortune-body {
            padding: 40px;
        }

        .draw-btn {
            border: none;
            border-radius: 50px;
            padding: 16px 40px;
            font-size: 1.1rem;
            font-weight: 700;
            background: linear-gradient(135deg, #007bb5, #00b4db);
            color: #fff;
            box-shadow: 0 10px 20px rgba(0, 180, 219, 0.3);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            cursor: pointer;
            letter-spacing: 0.5px;
        }

        .draw-btn:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 15px 25px rgba(0, 180, 219, 0.4);
            background: linear-gradient(135deg, #00b4db, #007bb5);
        }

        .spot-card {
            border-radius: 20px;
            padding: 30px;
            background: #ffffff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
            margin-top: 10px;
        }

        .spot-name {
            font-size: 2rem;
            font-weight: 800;
            color: #004d6e;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .spot-meta {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 50px;
            background: #e0f2f1;
            color: #00796b;
            font-size: 0.9rem;
            font-weight: 700;
            margin-right: 10px;
            margin-bottom: 15px;
            border: 1px solid rgba(0, 121, 107, 0.1);
        }

        .spot-description {
            color: #4a6572;
            line-height: 1.8;
            font-size: 1.05rem;
            margin-top: 15px;
        }

        .spot-image {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 16px;
            margin-bottom: 25px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
            transition: transform 0.5s ease;
        }

        .spot-image:hover {
            transform: scale(1.03);
        }

        /* 画面表示時のアニメーション */
        .animate-fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        
        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* ぐるぐるアニメーション用オーバーレイ */
        #fortune-spinner-overlay {
            position: fixed;
            top: 0; left: 0; width: 100vw; height: 100vh;
            background: rgba(224, 247, 250, 0.95);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .roulette-container {
            width: 320px;
            height: 320px;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 130, 200, 0.3);
            border: 8px solid #ffffff;
            background: #fff;
        }

        .roulette-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .spinner-text {
            font-weight: 800;
            font-size: 1.8rem;
            color: #005c8a;
            margin-bottom: 30px;
            letter-spacing: 1px;
            animation: pulse-text 1.5s infinite alternate;
        }

        @keyframes pulse-text {
            0% { opacity: 0.5; transform: scale(0.98); }
            100% { opacity: 1; transform: scale(1.02); }
        }
    </style>
@endpush

@section('content')
    <div class="container fortune-wrapper">
        <div class="top-photo">
            <h1>Today's Cebu Fortune</h1>
        </div>
        <div class="fortune-card">
            <div class="fortune-body">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if (session('message'))
                    <div class="alert alert-info">{{ session('message') }}</div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if (!$fortuneLog)
                    <div class="text-center animate-fade-in-up delay-1">
                        <p class="mb-4">You haven't drawn today's fortune yet.</p>
                        <form id="draw-form" action="{{ route('user.daily.fortune.draw') }}" method="POST">
                            @csrf
                            <button type="button" class="draw-btn mb-4" onclick="startOmikuji()">
                                <i class="fa-solid fa-wand-magic-sparkles me-2"></i> Draw today's recommendation
                            </button>
                        </form>
                    </div>
                @else
                    <div class="spot-card animate-fade-in-up delay-1">
                        @if ($fortuneLog->fortuneSpot->image)
                            @if (\Illuminate\Support\Str::startsWith($fortuneLog->fortuneSpot->image, 'http'))
                                <img src="{{ $fortuneLog->fortuneSpot->image }}"
                                    alt="{{ $fortuneLog->fortuneSpot->name }}" class="spot-image">
                            @else
                                <img src="{{ asset('storage/' . $fortuneLog->fortuneSpot->image) }}"
                                    alt="{{ $fortuneLog->fortuneSpot->name }}" class="spot-image">
                            @endif
                        @endif

                        <div class="spot-name">
                            {{ $fortuneLog->fortuneSpot->name }}
                        </div>

                        @if ($fortuneLog->fortuneSpot->location)
                            <div class="spot-meta">
                                {{ $fortuneLog->fortuneSpot->location }}
                            </div>
                        @endif

                        @if ($fortuneLog->fortuneSpot->category)
                            <div class="spot-meta">
                                {{ $fortuneLog->fortuneSpot->category }}
                            </div>
                        @endif

                        @if ($fortuneLog->fortuneSpot->description)
                            <div class="spot-description">
                                {{ $fortuneLog->fortuneSpot->description }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-4 text-center animate-fade-in-up delay-2">
                        <form id="draw-form" action="{{ route('user.daily.fortune.draw') }}" method="POST">
                            @csrf
                            <button type="button" class="draw-btn" onclick="startOmikuji()">
                                <i class="fa-solid fa-rotate-right me-2"></i> Draw Again!
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Spinning Animation Overlay -->
    <div id="fortune-spinner-overlay">
        <div class="spinner-text">Drawing Your Destiny...</div>
        <div class="roulette-container">
            <img id="roulette-image" src="" alt="Roulette" class="roulette-image">
        </div>
    </div>

    <script>
        const rouletteImages = [
            "https://cdn-ak.f.st-hatena.com/images/fotolife/n/newyorker24/20160720/20160720214257.png",
            "https://miro.medium.com/v2/resize:fit:965/1*_ODZre7ijbY3jk9adrs1jg.jpeg",
            "https://cebuinsider.com/wp-content/uploads/2023/08/Temple-of-Leah-Cebu-City.jpg",
            "https://tse1.mm.bing.net/th/id/OIP.MhThNU4C5DwJFCKqd9kMxAHaLk?rs=1&pid=ImgDetMain&o=7&rm=3",
            "https://www.topscebu.ph/_next/image?url=https:%2F%2Fcdn.sanity.io%2Fimages%2Foxei9udv%2Fproduction%2Fed70279bc18ddae5802d5554adb858f1ef87c89d-2048x1152.jpg%3Frect%3D0%2C0%2C1703%2C1152%26fm%3Dwebp&w=3840&q=75"
        ];

        // Preload images to avoid flickering
        rouletteImages.forEach(src => {
            const img = new Image();
            img.src = src;
        });

        function startOmikuji() {
            // Hide the spot card immediately so the user doesn't see the old result behind the transparent overlay
            const spotCard = document.querySelector('.spot-card');
            if (spotCard) {
                spotCard.style.display = 'none';
            }

            // Hide the draw again button wrapper
            const drawBtnWrapper = document.querySelector('.fortune-body .text-center.animate-fade-in-up.delay-2');
            if(drawBtnWrapper) {
                drawBtnWrapper.style.display = 'none';
            }

            // Show overlay
            const overlay = document.getElementById('fortune-spinner-overlay');
            const imgEl = document.getElementById('roulette-image');
            const textEl = document.querySelector('.spinner-text');
            overlay.style.display = 'flex';
            
            let i = 0;
            let finalImageUrl = null;
            let foundResult = false;
            
            const interval = setInterval(() => {
                if (!foundResult) {
                    imgEl.src = rouletteImages[i % rouletteImages.length];
                    i++;
                }
            }, 100); // cycle image every 100ms
            
            // Fire async request to draw the fortune without instantly refreshing
            const form = document.getElementById('draw-form');
            const csrfToken = form.querySelector('input[name="_token"]').value;

            fetch(form.action, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Accept": "application/json"
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.spot && data.spot.image) {
                    // Check if it's already an absolute HTTP URL
                    if (data.spot.image.startsWith('http')) {
                        finalImageUrl = data.spot.image;
                    } else {
                        finalImageUrl = "{{ asset('storage') }}/" + data.spot.image;
                    }
                }
            });

            // Wait 2.5 seconds minimum for drama, then force the spinner to stop on the actual result
            setTimeout(() => {
                foundResult = true;
                clearInterval(interval);
                
                if (finalImageUrl) {
                    imgEl.src = finalImageUrl;
                    textEl.innerHTML = "It's a Match! ✨";
                }
                
                // Pause for 1.2s to admire the final image before loading the rest of the spot data
                setTimeout(() => {
                    window.location.reload();
                }, 1200);

            }, 2500);
        }
    </script>
@endsection
