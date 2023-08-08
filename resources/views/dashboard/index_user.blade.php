@extends('layout.master')
  
@section('judul')

@endsection
@section('content')
<section class="content">
<div class="container-fluid" style="padding:60px 0px 0px 0px">
    <div class="row">
        <div class="col-lg-3 col-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <h3>{{ $data }}</h3>

              <p>Riwayat Booking</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="{{ url("/booking/index") }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
       
      </div>
</div>
</section>
@endsection