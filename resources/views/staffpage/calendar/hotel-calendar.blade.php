@extends('layouts.staff')
 
@section('title', 'Hotel calendar')
 
@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">Hotel Reservation Schedule</h2>

   
    <div id="calendar"></div>
</div>


@push('scripts')

<link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'en',
            firstDay: 1, //日開始

            height: "auto",
           



            events: "{{ route('hotel.calendar.data') }}",
            eventClick: function(info) {
                if(info.event.url) {
                    window.location.href = info.event.url;
                }
            },

            eventContent: function(arg) {
                const rooms = arg.event.extendedProps.rooms;
                const guests = arg.event.extendedProps.guests;
                const capacity = arg.event.extendedProps.capacity;
                const checkins = arg.event.extendedProps.checkins;
                const checkouts = arg.event.extendedProps.checkouts;

                const rate = capacity ? Math.round((rooms / capacity) * 100) : 0;
                const html = `
                      <div style="
            font-size:14px;
            line-height:1.4;
        ">

            <div style="font-weight:bold">
                ${rooms} / ${capacity} rooms
            </div>

            <div>
                ${guests} guests
            </div>

            <div style="font-size:13px">
                <span style="">
                    IN ${checkins}
                </span>

                |

                <span style="">
                    OUT ${checkouts}
                </span>
            </div>

        </div>
                `;
                return { html: html };
            }

        });
        calendar.render();

       
    })

</script>

    
@endpush
    
@endsection
 