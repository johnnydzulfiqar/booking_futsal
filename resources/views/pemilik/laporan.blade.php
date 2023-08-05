<style>
    body {
        font-family: Arial, sans-serif;
    }

    .header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .logo {
        width: 110px;
        /* margin-left: 20px; */
    }

    .title {
        flex-grow: 1;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        padding: 8px;
        text-align: left;
        border: 1px solid black;
    }

    tr:hover {
        background-color: #f5f5f5;
    }

    .button {
        margin-top: 20px;
        text-align: center;
    }

    .button button {
        padding: 10px 20px;
        background-color: #4CAF50;
        border: none;
        color: white;
        cursor: pointer;
        font-size: 16px;
    }
</style>
<div id="main">
<div class="content">
<div class="header">
    <img src="{{ asset('layout/dist/img/logofutsal.jpg') }}" alt="AdminLTE Logo" width="150px" height="150px">
    <div class="title" style="text-align: center;">
        <h3>QUEEN FUTSAL</h3>
        <h3>BANDUNG</h3>
      <p>Jl. Brigadir Jend. Katamso No.66, Cihaur Geulis, Kec. Cibeunying Kidul, Kota Bandung, Jawa Barat 40122</p> 
    </div>
</div>
<hr style="height: 3px;background-color: black;">
{{-- <h2 style="text-align:center">LAPORAN REKAP </h2> --}}
<table id="example1" class="table table-bordered table-striped">
    <thead>
      <tr>
        {{-- <th>No</th> --}}
        <th>Booking AN</th>
        {{-- <th>Lapangan</th> --}}
        <th>Pembayaraan</th>
        <th>Mulai</th>
        <th>Selesai</th>
        <th>Jam</th>
        <th>Harga</th>
        <th>Status</th>

      </tr>
      </thead>
      <tbody>
        @foreach ($data as $item)
        @auth
        @if ($user_id = Auth::user()->id === $item->user_id)  
        <tr>
                      
        {{-- <td>{{ $loop->iteration }}</td> --}}
        <td>{{ $item->user->name }}</td>
        {{-- <td>{{ $item->lapangan->nama }}</td> --}}
        @if (is_null($item->bukti))
        <td>Belum Bayar</td>
        @else
        {{-- <td><img src="{{asset('storage/img/' . $item->bukti)}}" alt="foto" width="100px"></td> --}}
        <td>{{ $item->pembayaraan }}</td>
        @endif
      
        <td>{{ Carbon\Carbon::parse($item->time_from)->format('d-M-Y H:00') }}</td>  
        <td>{{ Carbon\Carbon::parse($item->time_to)->format('d-M-Y H:00') }}</td> 
        <td>{{ $item->jam }}</td>    
        <td>@currency ($item->total_harga)</td>    
        <td>{{ $item->status }}</td>    


        
        </tr>  
        @endif
        @endauth          
        @endforeach
      </tbody>
      <tfoot>
      <tr>
        {{-- <th>No</th> --}}
        <th>Booking AN</th>
        {{-- <th>Lapangan</th> --}}
        <th>Pembayaraan</th>
        <th>Mulai</th>
        <th>Selesai</th>
        <th>Jam</th>
        <th>Harga</th>
        <th>Status</th>

      </tr>
      </tfoot>
  </table>
  <h2 style="margin : 25px 0px 0px 1040px">Meiliani Ajang</h2>
  <img src="https://upload.wikimedia.org/wikipedia/commons/6/6e/Tanda_Tangan_Mick_Schumacher.png" alt="" style="margin : 25px 0px 0px 1040px" width="150px" height="150px">
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