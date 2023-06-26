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
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('booking/create')}}" method="POST">
                        @csrf
                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5>
                                        Keterangan Harga Per Jam<br><br>
                                        Jam 7-12 : @currency($data->harga)<br>
                                        Jam 13-18 : @currency($data->harga+50000)<br>
                                        Jam 19-23 : @currency($data->harga+100000)<br>
                                    </h5>
                                    <label for="lapangan_id">Lapangan</label>
                                    <select name="lapangan_id" id="lapangan_id" class="form-control">
                                        @foreach ($lapangan as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('lapangan_id')
                                        <div class="alert alert-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <div class="form-group mb-2">
                                        <label for="time_from">Jam Mulai</label>
                                        <input type="text" class="form-control datetimepicker" id="time_from" name="time_from" value="{{ old('time_from') }}" />
                                        @error('time_from')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-2">
                                        <label for="time_to">Jam Berakir</label>
                                        <input type="text" class="form-control datetimepicker" id="time_to" name="time_to" value="{{ old('time_to') }}" />
                                        @error('time_to')
                                            <div class="alert alert-danger">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="row p-2">
                                        <button type="submit" class="btn btn-primary">Send</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/id.js"></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        

        if (@js($errors->any())) {
            $('#exampleModal').modal('show');
        }

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          headerToolbar: {
                left: 'prev,next',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,listWeek'
            },
            // resources: @js($resources),
            events: @js($events),
            dateClick: function (info) {
                if ((new Date(info.dateStr)).getTime() <= (new Date()).setHours(0)) {
                    return;
                }
                $('#time_from').val(info.dateStr);
                $('#time_to').val(info.dateStr);
                $('#exampleModal').modal('toggle');
            }
        });

        calendar.render();
    });
    $('.datetimepicker').datetimepicker({
        format: 'YYYY-MM-DD HH:00',
        locale: 'id',
        sideBySide: true,
        icons: {
            up: 'fas fa-chevron-up',
            down: 'fas fa-chevron-down',
            previous: 'fas fa-chevron-left',
            next: 'fas fa-chevron-right',
        },
        minDate: new Date,
        stepping: 10,
        disabledHours: [0, 1, 2, 3, 4, 5, 6]
    });

    </script>
@endsection