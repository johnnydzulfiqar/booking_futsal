@extends('layout.master')
  
@section('judul')
Index User
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Horizontal Layouts</h4>
    <!-- Basic Layout & Basic with Icons -->
    {{-- <div class="row"> --}}
        <!-- Basic with Icons -->
        <form action="{{ !empty($booking) ? route('booking.update', $booking): url('booking/create')}}" method="POST" enctype="multipart/form-data">
            @if(!empty($booking))
            @method('PATCH')
            @endif
            @csrf
            <div class="col-xxl">
        <div class="card mb-4">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="mb-0">Basic with Icons</h5>
            <small class="text-muted float-end">Merged input group</small>
          </div>
          <div class="card-body">
            <h5>
              Keterangan Harga Per Jam<br><br>
              Jam 7-12 : @currency($data->harga)<br>
              Jam 13-18 : @currency($data->harga+50000)<br>
              Jam 19-23 : @currency($data->harga+100000)<br>

            </h5>
            <form>
              <label for="lapangan_id">Lapangan</label>
              <select name="lapangan_id" id="lapangan_id" class="form-control">
                {{-- <option value="">Pilih Ruangan</option> --}}
                @foreach ($lapangan as $item)
                    <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    {{-- <option @selected(old('nama_ruangan', @$item->nama_ruangan) == '' ) value="">- Pilih Lantai -</option> --}}
                    {{-- <option @selected(old('id', @$item->id) == @$item->id) value="{{ @$item->id }}">{{ $item->nama_ruangan }}</option> --}}
                    @endforeach
            </select>
           
            {{-- <input style="display: none;" type="text" hidden name="harga" value="{{ $item->harga }}" class="form-control"> --}}
     
            @error('lapangan_id')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
        <div class="form-group mb-2">
          <label for="time_from">Jam Mulai</label>
          <input type="text" class="form-control datetimepicker" id="time_from" name="time_from" value="{{ old('time_from', @$booking->time_from) }}" />
          @error('time_from')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
      </div>
      <div class="form-group mb-2">
          <label for="time_to">Jam Berakir</label>
          <input type="text" class="form-control datetimepicker" id="time_to" name="time_to" value="{{ old('time_to', @$booking->time_to) }}" />
          @error('time_to')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
      </div>
      @if(!empty($booking))
      <div class="mb-3 row mt-3">
        <div class="col-sm-5">
          @if(!empty(@$booking->bukti))
          <img src="{{ asset('storage/img/' . $booking->bukti) }}" class="mb-3" alt="foto" width="100px" />
          
          @endif
          <label for="foto_barang" class="">Bayar DP sebesar 50% : @currency ( $booking->total_harga/2) </label>
          <input type="file" class="form-control" name="bukti" id="bukti" placeholder="bukti">
          </div>
      </div>
      @error('bukti')
      <div class="alert alert-danger">
          {{ $message }}
      </div>  
      @enderror
      @endif
              <div class="row justify-content-end">
                <div class="col-sm-10">
                  <button type="submit" class="btn btn-primary">Send</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </form>
    </div>
          <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
          <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/locale/id.js"></script>
              
              <script>
                  $('.datetimepicker').datetimepicker({
                      // format: 'YYYY-MM-DD HH:mm',
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

                  if (@js($booking)) {
                    $('#time_from').val(moment(@js($booking->time_from)).format('YYYY-MM-DD HH:00'));
                    $('#time_to').val(moment(@js($booking->time_to)).format('YYYY-MM-DD HH:00'));
                  }

                  if (@js(old('time_from'))) {
                    $('#time_from').val(moment(@js(old('time_from'))).format('YYYY-MM-DD HH:00'));
                  }
                  if (@js(old('time_to'))) {
                    $('#time_to').val(moment(@js(old('time_to'))).format('YYYY-MM-DD HH:00'));
                  }
              </script>
  {{-- </div> --}}
@endsection