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
          <div class="demo-inline-spacing " >
            {{-- <a type="button" class="btn btn-outline-primary" href="{{ url('lapangan/create') }}">
              <span class="tf-icons bx bx-pie-chart-alt"></span>&nbsp; Tambah Lapangan
            </a>     --}}
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($lapangan as $item)
                  <tr>
                                
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->nama }}</td>
                  <td>{{ $item->harga }}</td>
                  <td>{{ $item->status }}</td>  
                  <td>
                    <form action="/lapangan/{{  $item->id }}" method="POST">
                      @csrf
                      @method('delete')
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <a class="dropdown-item" href="/lapangan/{{ $item->id }}/edit"
                          ><i class="bx bx-edit-alt me-2"></i> Edit</a>
                          {{-- <input type="submit" class="btn btn-danger btn-sm" value="delete"> --}}
                      </div>
                    </div>
                  </form>
                  </td>        
                  </tr>            
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
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