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
            <h3 class="card-title">DataTable with default features</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if ( auth()->user()->type == 'admin')
            <form method="GET" action="{{ url("/admin/filter") }}">
            @endif
            @if ( auth()->user()->type == 'pemilik')
            <form method="GET" action="{{ url("/pemilik/filter") }}">
            @endif
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
                  <th>No</th>
                  <th>Booking Atas Nama</th>
                  {{-- <th>Lapangan</th> --}}
                  <th>Pembayaraan</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Jam</th>
                  <th>Harga</th>
                  <th>Status</th>
                  {{-- <th>Action</th> --}}

                </tr>
                </thead>
                <tbody>
                  @foreach ($booking as $item)
                 
                  <tr>
                                
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->user->name }}</td>
                  {{-- <td>{{ $item->lapangan->nama }}</td> --}}
                  @if (is_null($item->bukti))
                  <td style="color :red">Belum melakukan pembayaraan</td>
                  @else
                  {{-- <td><img src="{{asset('storage/img/' . $item->bukti)}}" alt="foto" width="100px"></td> --}}
                  <td style="color: green">{{ $item->pembayaraan }}</td>
                  @endif
                
                  <td>{{ $item->time_from }}</td>  
                  <td>{{ $item->time_to }}</td> 
                  <td>{{ $item->jam }}</td>    
                  <td>@currency ( $item->total_harga )</td>    
                  <td>{{ $item->status }}</td>    

 
                  </tr>  
                        
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Booking Atas Nama </th>
                  {{-- <th>Lapangan</th> --}}
                  <th>Pembayaraan</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Jam</th>
                  <th>Harga</th>
                  <th>Status</th>
                  {{-- <th>Action</th> --}}

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