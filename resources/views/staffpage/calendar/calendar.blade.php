@extends('layouts.app')

@push('styles')
<style>
.calendar {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
}

.calendar-day {
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 12px;
    background-color: #fff;
    min-height: 120px; /* 少し大きめ */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: flex-start;
}

.calendar-day:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* ステータスボックス風 */
.status-indicator {
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 6px 8px;
    border-radius: 6px;
    font-size: 0.9rem;
    font-weight: bold;
    margin: 2px 0;
    color: #fff;
    width: 80%;
    text-align: center;
    cursor: pointer;
    transition: transform 0.1s;
    text-decoration: none; /* aタグ用 */
}
.status-indicator:hover {
    transform: scale(1.05);
}

.available { background-color: #28a745; }   /* 緑＝空室 */
.in_use { background-color: #17a2b8; }      /* 青＝使用中 */
.reserved { background-color: #007bff; }    /* 水色＝予約済 */
.maintenance { background-color: #ffc107; color:#000; } /* 黄＝メンテナンス */
</style>
@endpush

@section('content')
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

