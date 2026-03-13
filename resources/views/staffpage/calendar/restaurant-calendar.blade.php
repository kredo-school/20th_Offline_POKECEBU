@extends('layouts.staff')
 
@section('title', 'Restaurant carender')
 
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
      <input type="date" id="dateTo" class="form-control">
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

      timeZone: 'local',

      slotMinTime: "10:00:00",
      slotMaxTime: "25:00:00",

      allDaySlot: false,
      nowIndicator: true,  //現在時間ライン

      height: "auto",
      events: "{{ route('restaurant.calendar.data') }}",

      //クリックして予約一覧
      eventClick: function(info) {
        if (info.event.url) {
          window.location.href = info.event.url;
        }
      },

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
 
