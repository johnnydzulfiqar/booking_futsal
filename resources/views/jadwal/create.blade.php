@extends('layout.master')
  
@section('judul')
Index Ruangan
@endsection
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms/</span> Horizontal Layouts</h4>

    <!-- Basic Layout & Basic with Icons -->
    <div class="row">
        <!-- Basic with Icons -->
        <form action="{{ !empty($jadwal) ? route('jadwal.update', $jadwal): url('jadwal/create')}}" method="POST" enctype="multipart/form-data">
            @if(!empty($jadwal))
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
                    <form>
                        <div class="form-group mb-2">
                            <label for="time_from">Jam Mulai</label>
                            <input type="text" class="form-control datetimepicker" id="time_from" name="time_from" value="{{ old('time_from') }}" />
                        </div>
                        <div class="form-group mb-2">
                            <label for="time_to">Jam Berakir</label>
                            <input type="text" class="form-control datetimepicker" id="time_to" name="time_to" value="{{ old('time_to') }}" />
                        </div>
                        <input style="display: none;" type="text" hidden name="status" value="Belum Bayar DP" class="form-control">
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
          {{-- </div> --}}
          <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
                  <script src="https://cdn.datatables.net/select/1.2.0/js/dataTables.select.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
              <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
              <script>
                  $('.datetimepicker').datetimepicker({
                      format: 'YYYY-MM-DD HH:mm',
                      locale: 'en',
                      sideBySide: true,
                      icons: {
                      up: 'fas fa-chevron-up',
                      down: 'fas fa-chevron-down',
                      previous: 'fas fa-chevron-left',
                      next: 'fas fa-chevron-right'
                      },
                      stepping: 10
                  });
              </script>
        @endsection