@section('content')

{{-- 右上のAll reservations リンク --}}
<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('reservations.hotel') }}" class="btn btn-primary">
        All reservations
    </a>
</div>

<div class="calendar mt-3">
    @for($day=1; $day<=30; $day++)
        {{-- カード全体をリンクで包む --}}
        <div class="calendar-day" onclick="window.location.href='{{ route('mock.day', $day) }}'">
            
            {{-- 日付表示 --}}
            <div style="font-weight:bold; font-size:1.2rem; margin-bottom: 8px;">
                {{ $day }}
            </div>

            {{-- ステータスボタン部分：横並びに変更 --}}
            <div class="mt-2 d-flex flex-wrap justify-content-center gap-1">
                @if($days[$day]['available'] > 0)
                    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'available']) }}"
                       class="status-indicator available"
                       onclick="event.stopPropagation();">Available</a>
                @endif
                @if($days[$day]['in_use'] > 0)
                    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'in_use']) }}"
                       class="status-indicator in_use"
                       onclick="event.stopPropagation();">In-use</a>
                @endif
                @if($days[$day]['reserved'] > 0)
                    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'reserved']) }}"
                       class="status-indicator reserved"
                       onclick="event.stopPropagation();">Reserved</a>
                @endif
                @if($days[$day]['maintenance'] > 0)
                    <a href="{{ route('mock.detail', ['day' => $day, 'type' => 'maintenance']) }}"
                       class="status-indicator maintenance"
                       onclick="event.stopPropagation();">Maintenance</a>
                @endif
            </div>
        </div>
    @endfor
</div>

@endsection


