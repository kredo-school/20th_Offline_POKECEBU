@extends('layouts.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/staff.css/calendar/calendar.css') }}">
@endpush

@section('content')

{{-- 右上のAll reservations リンク --}}
<div class="d-flex justify-content-end mt-3">
    <a href="{{ route('reservations.restaurant') }}" class="btn btn-primary">
        All reservations
    </a>
</div>

<div class="calendar mt-3">
    @for($day = 1; $day <= 30; $day++)
        {{-- カード全体をリンクで包む --}}
        <div class="calendar-day" onclick="window.location.href='{{ route('mock.restaurant.day', $day) }}'">
            
            {{-- 日付表示 --}}
            <div style="font-weight:bold; font-size:1.2rem; margin-bottom: 8px;">
                {{ $day }}
            </div>

            {{-- ステータスボタン部分：横並び --}}
            <div class="mt-2 d-flex flex-wrap justify-content-center gap-1">
                @if($days[$day]['available'] > 0)
                    <a href="{{ route('mock.restaurant.detail', ['day' => $day, 'type' => 'available']) }}"
                       class="status-indicator available"
                       onclick="event.stopPropagation();">Available</a>
                @endif

                @if($days[$day]['in_use'] > 0)
                    <a href="{{ route('mock.restaurant.detail', ['day' => $day, 'type' => 'in_use']) }}"
                       class="status-indicator in_use"
                       onclick="event.stopPropagation();">In-use</a>
                @endif

                @if($days[$day]['reserved'] > 0)
                    <a href="{{ route('mock.restaurant.detail', ['day' => $day, 'type' => 'reserved']) }}"
                       class="status-indicator reserved"
                       onclick="event.stopPropagation();">Reserved</a>
                @endif

                @if($days[$day]['maintenance'] > 0)
                    <a href="{{ route('mock.restaurant.detail', ['day' => $day, 'type' => 'maintenance']) }}"
                       class="status-indicator maintenance"
                       onclick="event.stopPropagation();">Maintenance</a>
                @endif
            </div>
        </div>
    @endfor
</div>

@endsection
@extends('layouts.staff')
 
@section('title', 'Restaurant-carender')
 
@section('content')

<div class="container mt-4">
  <h2 class="text-center mb-4">Reservation Schedule</h2>

  {{-- 検索窓 --}}
  <div class="d-flex gap-3 mb-3 justify-content-center">
    <div class="">
      <label for="">from</label>
      <input type="date" id="dateFrom" class="form-control">
    </div>

    <div class="">
      <label for="">to</label>
      <input id="dateTo" class="form-control">
    </div>

    <div class="align-self-end">
      <button id="searchBtn" class="btn btn-success">Search</button>
    </div>

  </div>
  <div class="calendar" id="calendar"></div>
</div>
    
@endsection

@push('scripts')
{{-- FullCalender CSS --}}
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
{{-- FullCalender JS --}}
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'timeGridWeek',
      locale: 'en',
      firstDay: 1, //月開始

      slotMinTime: "00:00:00",
      slotMaxTime: "24:00:00",

      allDaySlot: false,

      height: "auto",
      events: "{{ route('restaurant.store.calendar.data') }}",
      eventClick: function(info) {
        if (info.event.url) {
          window.location.href = info.event.url;
        }
      }
    });
    calendar.render();

    // 検索ボタン
    document.getElementById('searchBtn').addEventListener('click', function(){
      const from = document.getElementById('dateFrom') .value;

      if(from) {
        calendar.gotoDate(from);
      }
    });

    // from入力したらtoも自動入力される（１週間）
    document.getElementById('dateFrom').addEventListener('change', function(){
      const from = new Date(this.value);

      if(!isNaN(from)){
        const to = new Date(from);
        to.setDate(to.getDate() + 6);

        const yyyy  = to.getFullYear();
        const mm    = String(to.getMonth()+1).padStart(2,'0');
        const dd    = String(to.getDate()).padStart(2,'0');
      
        document.getElementById('dateTo').value = `${yyyy}-${mm}-${dd}`;
      }
    });
  });
</script>

    
@endpush
 
