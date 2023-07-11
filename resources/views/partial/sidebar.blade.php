<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    @if ( auth()->user()->type == 'admin') 
    <a href="{{ url('/admin/index') }}" class="brand-link">
      @endif
      @if ( auth()->user()->type == 'user') 
      <a href="{{ url('/booking/index') }}" class="brand-link">
        @endif
        @if ( auth()->user()->type == 'pemilik') 
      <a href="{{ url('/pemilik/index') }}" class="brand-link">
        @endif
      <img src="{{ asset('layout/dist/img/logofutsal.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Queen Futsal</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('layout/dist/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          @if ( auth()->user()->type == 'admin') 
          <a href="{{ url('/admin/' . Auth::user()->id ) . '/edit'}}" class="d-block">{{ Auth::user()->name }}</a>
          @endif
          @if ( auth()->user()->type == 'user') 
          <a href="{{ url('/user/' . Auth::user()->id . '/edit') }}" class="d-block">{{ Auth::user()->name }}</a>
          @endif
          @if ( auth()->user()->type == 'pemilik') 
          <a href="{{ url('/pemilik/' . Auth::user()->id . '/edit') }}" class="d-block">{{ Auth::user()->name }}</a>
          @endif
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                @if ( auth()->user()->type == 'user') 
                <a href="{{ url('/booking/index') }}" class="nav-link active">
                  @endif
                  @if ( auth()->user()->type == 'admin') 
                  <a href="{{ url('/dashboard') }}" class="nav-link active">
                    @endif
                    @if ( auth()->user()->type == 'pemilik') 
                    <a href="{{ url('/pemilik/dashboard') }}" class="nav-link active">
                      @endif
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              
          </li>
          @if ( auth()->user()->type == 'user') 
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Management Booking
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/booking/index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Index Booking</p>
                </a>
                <a href="{{ url('/booking/jadwal') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jadwal Booking</p>
                </a>
              </li>
            
              
            </ul>
          </li>
          @endif
          @if ( auth()->user()->type == 'admin') 
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Management User
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Index User</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/create') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add User</p>
                </a>
              </li>
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Management Lapangan
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/lapangan/index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Index Lapangan</p>
                </a>
              </li>
              
              
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Management Booking
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/bookingadmin/index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Index Booking</p>
                </a>
                <a href="{{ url('/bookingadmin/jadwal') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Jadwal Booking</p>
                </a>
              </li>
            
              
            </ul>
          </li>
          @endif
          @if ( auth()->user()->type == 'pemilik') 
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Management Booking
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/pemilik/index') }}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Index Booking</p>
                </a>
              </li>
            
              
            </ul>
          </li>
          @endif
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>