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
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Booking AN</th>
                  <th>Lapangan</th>
                  <th>Bukti</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
                  <th>Status</th>
                  <th>Action</th>

                </tr>
                </thead>
                <tbody>
                  @foreach ($booking as $item)
                  <tr>
                                
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->user->name }}</td>
                  <td>{{ $item->lapangan->nama }}</td>
                  @if (is_null($item->bukti))
                  <td><a href="bayar dp">link ss dp</a></td>
                  @else
                  <td>{{ $item->bukti }}</td>
                  @endif
                
                  <td>{{ $item->time_from }}</td>  
                  <td>{{ $item->time_to }}</td>    
                  <td>{{ $item->status }}</td>    


                  <td>
                    @if ($item->status=='Belum Bayar DP')
                    <form action="/admin/{{  $item->id }}" method="POST">
                      @csrf
                      @method('delete')
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <a class="dropdown-item" href="/admin/{{ $item->id }}/edit"
                          ><i class="bx bx-edit-alt me-2"></i> Edit</a>
                          <a class="dropdown-item" href="/admin/{{ $item->id }}/edit"
                            ><i class="bx bx-edit-alt me-2"></i> Detail</a>
                      </div>
                    </div>
                  </form>
                  @else
                  
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                     
                        <a class="dropdown-item" href="/admin/{{ $item->id }}/edit"
                          ><i class="bx bx-edit-alt me-2"></i> Detail</a>
                    </div>
                  </div>

                @endif  
                  </td>        
                  </tr>            
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Booking AN</th>
                  <th>Lapangan</th>
                  <th>Bukti</th>
                  <th>Mulai</th>
                  <th>Selesai</th>
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