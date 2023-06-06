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
        <form action="{{ !empty($admin) ? route('admin.update', $admin): url('admin/create')}}" method="POST" enctype="multipart/form-data">
            @if(!empty($admin))
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
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="name"
                      class="form-control"
                      id="name"
                      value="{{ old('name', @$admin->name) }}"
                      aria-describedby="basic-icon-default-fullname2"
                    />
                  </div>
                </div>
              </div>
              
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                    <input
                      type="text"
                      id="email"
                      name="email"
                      value="{{ old('email', @$admin->email) }}"
                      class="form-control"
                     
                      aria-describedby="basic-icon-default-email2"
                    />
                    <span id="basic-icon-default-email2" class="input-group-text">@example.com</span>
                  </div>
                  <div class="form-text">You can use letters, numbers & periods</div>
                </div>
              </div>
           
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Alamat</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="alamat"
                      class="form-control"
                      id="alamat"
                      value="{{ old('alamat', @$admin->alamat) }}"
                      aria-describedby="basic-icon-default-fullname2"
                    />
                  </div>
                </div>
              </div>
              <div class="row mb-3">
                <label class="col-sm-2 form-label" for="basic-icon-default-phone">Password</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="password"
                      id="password"
                      name="password"
                      value="{{ old('password', @$admin->password) }}"
                      class="form-control fullname2-mask"
                     
                      aria-describedby="basic-icon-default-fullname2"
                    />
                  </div>
                </div>
              </div>
              <label for="type">Role</label>
              <select id="type" name="type" class="form-select">
                <option value="0">User</option>
                <option value="1">Admin</option>

              </select>
              {{-- <div class="mb-3 row mt-3">
                <label for="foto_produk" class="col-sm-2 col-form-label">Foto</label>
                <div class="col-sm-5">
                @if(!empty(@$admin->foto_produk))
                <img src="{{ $admin->foto_produk }}" class="mb-3" alt="foto" width="100px" />
                @endif
                    <input type="file" class="form-control" name="foto_produk" id="foto_produk" placeholder="foto_produk">
                </div>
            </div> --}}
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
@endsection