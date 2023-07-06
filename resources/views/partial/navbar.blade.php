<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      {{-- <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      

      <!-- Messages Dropdown Menu -->
      
      
    </ul>
    <button class="navbar-toggler" type="button" data-toggle="collapse">
      <span class="navbar-toggler-icon"></span>
    </button>
   
      <ul class="navbar-nav mb-3">
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img src="{{ asset('layout/dist/img/user.png') }}" width="40" height="40" class="rounded-circle">
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            @if ( auth()->user()->type == 'admin') 
                                    <a class="dropdown-item" href="{{ url('/admin/'. Auth::user()->id . '/edit' ) }}" class="d-block">Profile</a>
                                    @endif
                                    @if ( auth()->user()->type == 'user') 
                                    <a class="dropdown-item" href="{{ url('/user/' . Auth::user()->id . '/edit' ) }}" class="d-block">Profile</a>
                                    @endif
                                    
            <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                      @csrf
                                  </form>
          </div>
        </li>   
      </ul>
  </nav>