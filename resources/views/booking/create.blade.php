@extends('layout.master')
  
@section('judul')
Index User
@endsection
@section('content')
<style>
  .list-bullets {
list-style: none;
}

.list-bullets li {
display: flex;
align-items: center;
}

.list-bullets li::before {
content: '';
width: 12px;
height: 12px;
border-radius: 50%;
background: #5784d7;
border: 2px solid #8fb3f5;
display: block;
margin-right: 1rem;
}

/* Unordered list with custom numbers style */
ol.custom-numbers {
list-style: none;
}

ol.custom-numbers li {
counter-increment: my-awesome-counter;
}

ol.custom-numbers li::before {
content: counter(my-awesome-counter) ". ";
color: #2b90d9;
font-weight: bold;
}


/*
*
* ==========================================
* FOR DEMO PURPOSES
* ==========================================
*
*/
li {
font-style: italic;
}
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    {{-- <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms Edit</h4> --}}
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
            <h5 class="mb-0">Form edit</h5>
            {{-- <small class="text-muted float-end">Merged input group</small> --}}
          </div>
          <div class="card-body">
            <h4 class="mb-4">Keterangan Harga</h4>
              <!-- List with bullets -->
                <ul class="list-bullets">
                    <li class="mb-2"> Jam 7-12 : @currency($data->harga)</li>
                    <li class="mb-2"> Jam 15-18 : @currency($data->harga+50000)</li>
                    <li class="mb-2">Jam 19-23 : @currency($data->harga+100000)</li>
                </ul>
            <form>
              {{-- <label for="lapangan_id">Lapangan</label> --}}
              <select hidden name="lapangan_id" id="lapangan_id" class="form-control">
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
          <img src="{{ asset('storage/img/' . $booking->bukti) }}" class="mb-3" alt="foto" width="300px" id="geeks" /><br>
          <button type="button" onclick="zoomin()">
            Zoom-In
        </button>
        <button type="button" onclick="zoomout()"> 
          Zoom-Out
      </button> <br>
          @endif
          <span class="badge badge-info">Batas Pembayaran {{ \Carbon\Carbon::parse($booking->created_at)->modify('+1 hour')->format('j F, Y, H:i:s') }}</span><br>
          <span class="badge badge-info">*Apabila melebihi batas waktu maka booking dibatalkan</span>
          <label for="foto_barang" class="">Bayar DP sebesar 50% : <span id="dp">@currency ( $booking->total_harga/2)</span></label>
          <label for="foto_barang" class="">Sisa Bayar : <span id="dp">@currency ( $booking->total_harga/2)</span></label>

          <label for="foto_barang" class="">Atau Bayar Lunas sebesar : <span id="total">@currency ( $booking->total_harga)</span></label>

          <label>Ke Rekening BRI : 01110022 </label><br>
          <label>Atas Nama : Meiliani Ajang </label>

          <input type="file" class="form-control" name="bukti" id="bukti" placeholder="bukti">

          <div class="form-check mt-3">
            <input class="form-check-input" type="radio" name="pembayaraan" id="pembayaraan" value="Bayar DP" checked>
            <label class="form-check-label" for="flexRadioDefault1">
              Bayar DP
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="pembayaraan" id="pembayaraan" value="Bayar Lunas">
            <label class="form-check-label" for="flexRadioDefault2">
              Bayar Lunas
            </label>
          </div>
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
          <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script> --}}
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
                  function zoomin() {
            var GFG = document.getElementById("geeks");
            var currWidth = GFG.clientWidth;
            GFG.style.width = (currWidth + 100) + "px";
        }
          
        function zoomout() {
            var GFG = document.getElementById("geeks");
            var currWidth = GFG.clientWidth;
            GFG.style.width = (currWidth - 100) + "px";
        }
        $('.datetimepicker').on('dp.change', e => {
          const timefrom = moment($('#time_from').val());
          const timeto = moment($('#time_to').val());


          const start = +timefrom.format('H');
          const end = +timeto.format('H');

          const harga = @js($data->harga);

          let total = 0;
          for (let i = start; i < end; i++) {
            if (i < 15) {
                total += +harga;
            } else if (i >= 15 && i < 18) {
                total += (+harga + 50000);
            } else {
                total += (+harga + 100000);
            }
          }

          $('#total').text('Rp. ' + Intl.NumberFormat().format(total));
          $('#dp').text('Rp. ' + Intl.NumberFormat().format(total/2));
        })
              </script>
  {{-- </div> --}}
@endsection