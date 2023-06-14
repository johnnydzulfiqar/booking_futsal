@extends('layout.master')
  
@section('judul')
    Jadwal Booking
@endsection

@section('content')
    @php
        $resources = [];
        $events = [];
        foreach ($lapangan as $lapang) {
            array_push($resources, [
                'id' => 'lapangan-' . $lapang->id,
                'title' => $lapang->nama,
            ]);
        }
        foreach ($booking as $book) {
            array_push($events, [
                'id' => $book->id,
                'resourceId' => 'lapangan-' . $book->lapangan_id,
                'title' => $book->user->name . " ($book->jam jam)",
                'start' => $book->time_from,
                'end' => $book->time_to,
            ]);
        }
    @endphp
    <div id='calendar'></div>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            resources: @js($resources),
            events: @js($events),
        });
        calendar.render();
      });

    </script>
@endsection