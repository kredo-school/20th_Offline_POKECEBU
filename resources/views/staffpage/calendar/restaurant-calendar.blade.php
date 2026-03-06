@extends('layouts.staff')
 
@section('title', 'Restaurant-carender')
 
@section('content')

<div class="container mt-4">
  <h2 class="text-center mb-4">Reservation Schedule</h2>
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
      locale: 'ja',
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
  });
</script>

    
@endpush
 