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
                  <th>Name</th>
                  <th>Email(s)</th>
                  <th>Alamat</th>
                  <th>Role</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                  @foreach ($user as $item)
                  <tr>
                                
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $item->name }}</td>
                  <td>{{ $item->email }}</td>
                  <td>{{ $item->alamat }}</td>
                  <td>{{ $item->type }}</td>    
                  <td>
                    @if ($item->type=='admin')
                    <form action="{{ url("/admin/$item->id") }}" method="POST">
                      @csrf
                      @method('delete')
                    <div class="dropdown">
                      <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                        <a class="dropdown-item" href="{{ url("/admin/$item->id/edit") }}"
                          ><i class="bx bx-edit-alt me-2"></i> Edit</a>
                      
                      </div>
                    </div>
                  </form>
                  @else
                  <form action="{{ url("/admin/$item->id") }}" method="POST">
                    @csrf
                    @method('delete')
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Action
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                      <a class="dropdown-item" href="{{ url("/admin/$item->id/edit") }}"
                        ><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <input type="submit" class="btn btn-danger btn-sm" value="delete">
                    </div>
                  </div>
                </form>
                @endif  
                  </td>        
                  </tr>            
                  @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Email(s)</th>
                  <th>Alamat</th>
                  <th>Role</th>
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