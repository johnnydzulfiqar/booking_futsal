@extends('layout.master')
  
@section('judul')

@endsection
@section('content')
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Data Booking</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
           
            {{-- @if ($data?->lapangan->status == 'Tidak Aktif')
                <h3 style="color: red">Lapangan Tutup</h3>
            @else
            <a class="btn btn-primary mb-3" href="/booking/create" role="button">Booking Baru</a>
            @endif --}}

            <form method="GET" action="/booking/filter">
              <div class="row pb-3">
            <div class="col-md-3">
              <label>Start date</label>
              <input type="date" name="start_date" class="form-control">
            </div>
            <div class="col-md-3">
              <label>End date</label>
              <input type="date" name="end_date" class="form-control">
            </div>
            <div class="col-md-1 pt-4" style="margin: 5px 0px 0px 0px">
              <button type="submit" class="btn btn-primary">Filter</button>
            </div>
          </div>
          </form>
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  {{-- <th>No</th> --}}
                  <th>Booking AN</th>
                  <th>Lapangan</th>
                  <th>Bukti</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Jam</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Action</th>

                </tr>
                </thead>
                <tbody>
                  @foreach ($booking as $item)
                  @auth
                  @if ($user_id = Auth::user()->id === $item->user_id)  
                  <tr>
                                
                  {{-- <td>{{ $loop->iteration }}</td> --}}
                  <td>{{ $item->user->name }}</td>
                  <td>{{ $item->lapangan->nama }}</td>
                  @if (is_null($item->bukti))
                  <td><a href="/booking/{{ $item->id }}/edit">Belum Bayar DP</a></td>
                  @else
                  {{-- <td><img src="{{asset('storage/img/' . $item->bukti)}}" alt="foto" width="100px"></td> --}}
                  <td>Sudah Bayar DP</td>
                  @endif
                
                  <td>{{ Carbon\Carbon::parse($item->time_from)->format('d-M-Y H:00') }}</td>  
                  <td>{{ Carbon\Carbon::parse($item->time_to)->format('d-M-Y H:00') }}</td> 
                  <td>{{ $item->jam }}</td>    
                  <td>@currency ($item->total_harga)</td>    
                  <td>{{ $item->status }}</td>    


                  <td>
                    @if ($item->status=='Masuk Jadwal')
                    <form action="/booking/{{  $item->id }}" method="POST">
                      @csrf
                      @method('delete')
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        
                          <a class="dropdown-item" href="/booking/{{ $item->id }}/show"
                            ><i class="bx bx-edit-alt me-2"></i> Detail</a>
                            <a class="dropdown-item" href="/booking/{{ $item->id }}/invoice"
                              ><i class="bx bx-edit-alt me-2"></i> Invoice</a>
                      </div>
                    </div>
                  </form>
                  @else
                  
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                     
                        <a class="dropdown-item" href="/booking/{{ $item->id }}/show"
                          ><i class="bx bx-edit-alt me-2"></i> Detail</a>
                          <a class="dropdown-item" href="/booking/{{ $item->id }}/edit"
                            ><i class="bx bx-edit-alt me-2"></i> Edit</a>
                          
                    </div>
                  </div>

                @endif  
                <form action="/booking/{{ $item->id }}" method="POST">
                  @csrf 
                  @method('delete')
              @if ($item->status == 'Belum Bayar DP')
              <input type="submit" class="btn btn-danger mt-2" value="Batal">
              @endif
            </form>
                  </td>        
                  </tr>  
                  @endif
                  @endauth          
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  {{-- <th>No</th> --}}
                  <th>Booking AN</th>
                  <th>Lapangan</th>
                  <th>Bukti</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Jam</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Action</th>

                </tr>
                </tfoot>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
</section>
@endsection