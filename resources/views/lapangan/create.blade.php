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
        <form action="{{ !empty($lapangan) ? route('lapangan.update', $lapangan): url('lapangan/create')}}" method="POST" enctype="multipart/form-data">
            @if(!empty($lapangan))
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
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Nama Lapangan</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="nama"
                      class="form-control"
                      id="nama"
                      value="{{ old('nama', @$lapangan->nama) }}"
                      aria-describedby="basic-icon-default-fullname2"
                    />
                  </div>
                </div>
              </div>
              
              <div class="row mb-3">
                <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Harga Sewa</label>
                <div class="col-sm-10">
                  <div class="input-group input-group-merge">
                    <span id="basic-icon-default-fullname2" class="input-group-text"
                      ><i class="bx bx-user"></i
                    ></span>
                    <input
                      type="text"
                      name="harga"
                      class="form-control"
                      id="harga"
                      value="{{ old('harga', @$lapangan->harga) }}"
                      aria-describedby="basic-icon-default-fullname2"
                    />
                  </div>
                </div>
              </div>
              <label for="status">Status</label>
              <select id="status" name="status" class="form-select">
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
              </select>
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