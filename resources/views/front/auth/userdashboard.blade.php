@extends('front.layout.main')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','tenant_title','tenant_favicon','currency','order_cutoff_time','catering_cancel_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- Page Title -->
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">User Dashboard</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / User Dashboard</p>
            </div>
        </div>
    </div>
</div>
<section class="section section-bg-edge">
<div class="mt-5 mb-5">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-3">
  @include('front.includes.usersidebar')
</div>
<div class="col-lg-9 col-md-9">
  <h4 class="pt-5 pb-2">Dashboard</h4>
  <p><strong>Welcome, {{ $user_login->name }}.</strong></p>
  <h6 class="pb-2">Latest Order</h6>
  <div class="pb-5">
  <div class="table-responsive">
  <table class="table table-bordered" style="width:100%">
        <thead>
            <tr>
                <th width="15%">Order Number</th>
                <th width="20%">Order Date</th>
                <th width="10%">Payment Method</th>
                <th width="10%">Grand Total</th>
                <th width="20%">Delivery Date</th>
                <th width="10%">Status</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
          <?php
            for($i=0;$i<count($orders);$i++){
          ?>
            <tr>
                <td>#{{$orders[$i]->id}}</td>
                <td><?php echo Carbon\Carbon::parse($orders[$i]->created_at)->format($theme_data->datetime_format); ?></td>
                <td>{{$orders[$i]->payment_method}}</td>
                <td>{{ $theme_data->currency }}{{$orders[$i]->grand_total}}</td>
                <td><?php echo Carbon\Carbon::parse($orders[$i]->delivery_date)->format($theme_data->datetime_format); ?></td>
                <td>{{$orders[$i]->order_status}}</td>
                <td>
                  <?php if($orders[$i]->order_status!="Accepted"){ ?>
                    <a class="" href="{{ url('/myvieworder') }}/{{$orders[$i]->id}}"><span>View</span></a>
                  <?php }else{ ?>
                    <a class="" href="{{ url('/myvieworder') }}/{{$orders[$i]->id}}"><span>View</span></a>
                    <?php
                      //echo $orders[$i]->delivery_date."<=".date("m/d/Y H:i:s");
                      if($orders[$i]->main_categories_id==1){
                      //tiffin
                        $cutofftime = $theme_data->order_cutoff_time;
                        $delivery_date = Carbon\Carbon::parse($orders[$i]->delivery_date)->format('Y-m-d');
                        //echo $delivery_date.">=".date("Y-m-d");
                        //echo "<br>";
                        //echo $cutofftime.">".date("H:i:s");
                        if($delivery_date==date("Y-m-d")){
                          if($cutofftime>date("H:i:s")){
                          ?>
                          | <a class="" href="{{ url('/mycancelorder') }}/{{$orders[$i]->id}}"><span>Cancel</span></a>
                          <?php
                          }
                        }elseif($delivery_date>date("Y-m-d")){
                        ?>
                          | <a class="" href="{{ url('/mycancelorder') }}/{{$orders[$i]->id}}"><span>Cancel</span></a>
                        <?php
                        }else{}
                      }elseif($orders[$i]->main_categories_id==2){
                        //catering
                        $cu = $theme_data->catering_cancel_cutoff_time;
                        $fdate=date('Y-m-d H:i:s');
                        $cutoffdate = Carbon\Carbon::parse($fdate)->addHours($cu)->format('Y-m-d H:i:s');
                        //echo $orders[$i]->delivery_date." > ".$cutoffdate;
                        if($orders[$i]->delivery_date > $cutoffdate){
                          ?>
                          | <a class="" href="{{ url('/mycancelorder') }}/{{$orders[$i]->id}}"><span>Cancel</span></a>
                          <?php
                        }
                      }else{
                      //menu
                        if($orders[$i]->delivery_date > date("Y-m-d H:i:s")){
                          ?>
                          | <a class="" href="{{ url('/mycancelorder') }}/{{$orders[$i]->id}}"><span>Cancel</span></a>
                          <?php
                        }
                      }
                    ?>
                  <?php } ?>
                 </td>
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
  </div>
  </div>
</div>
</div>
</div>
</div>
</section>
<script>
$(document).ready(function() {
  /*
    $('#example').DataTable({
      "pagingType": "full_numbers",
      searching: false,
      ordering:  false,
      paging: false,
    });
    */
} );
</script>
@endsection
