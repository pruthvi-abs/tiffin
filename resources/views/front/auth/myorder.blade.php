@extends('front.layout.main')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','tenant_title','tenant_favicon','currency','order_cutoff_time','catering_cancel_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- Page Title -->
<style>
.dataTables_paginate a {
	padding: 6px 9px 6px 0 !important;
	background: #fff !important;
	border-color: #fff !important;
}
#orderlist_paginate {
	float: right;
}
</style>
<div class="page-title bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <h4 class="mb-0 pull-left">Order</h4>
            </div>
            <div class="col-lg-6 col-md-6">
                <p class="mb-0  pull-right"><a href="{{ url('/') }}">Home</a> / Order</p>
            </div>
        </div>
    </div>
</div>
<section class="section section-bg-edge">
<div class="container">
<div class="row">
<div class="col-lg-3 col-md-3">
  @include('front.includes.usersidebar')
</div>
<div class="col-lg-9 col-md-9">
  <h4 class="pt-5 pb-2">Order</h4>
  <div class="pb-5">
  <div class="table-responsive">
  <table id="orderlist" class="table table-bordered " style="width:100%">
        <thead>
            <tr>
                <th width="15%">Order Number</th>
                <th width="20%">Order Date</th>
                <th width="10%">Payment Method</th>
                <th width="10%">Grand Total</th>
                <th width="20%">Delivery Date</th>
                <th width="10%">Status</th>
                <th width="20%">Action</th>
            </tr>
        </thead>
        <tbody>
          <?php
            for($i=0;$i<count($orders);$i++){
          ?>
            <tr>
                <td>#{{$orders[$i]->id}}</td>
                <td>{{$orders[$i]->created_at}}</td>
                <td>{{$orders[$i]->payment_method}}</td>
                <td>${{$orders[$i]->grand_total}}</td>
                <td>{{$orders[$i]->delivery_date}}</td>
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
</section>
<link href="cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
<link href="{{asset('public/admin/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
<link href="{{asset('public/admin/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

<script src="{{asset('public/admin/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
<script src="{{asset('public/admin/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
<!--
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js" type="text/javascript"></script>
-->
<script>
$(document).ready(function() {

  $('#orderlist').DataTable({
      "pagingType": "full_numbers",
      //searching: false,
      ordering:  false,
      //paging: false,
      //scrollY: 300,
    });
});
</script>
@endsection
