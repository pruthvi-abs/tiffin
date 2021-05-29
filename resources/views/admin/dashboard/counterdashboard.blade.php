@extends('admin.layout.counterdashboard')
@section('content')

@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','currency','tenant_title','tenant_favicon','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<style>
#tiffintodayacceptorder_info,#cateringtodayacceptorder_info,#menutodayacceptorder_info {display: none;}
</style>
<!-- page content -->
<!-- top tiles -->
<div class="row" style="display: inline-block;" >
<div class="tile_count">
<div class="col-md-12 col-sm-12  tile_stats_count">
<h1>{{$webpage}}</h1>
</div>
</div>
</div>
<!-- /top tiles -->
<style>
.cucontent {font-size: 18px;}
</style>
<div class="row">
  <div class="col-md-2 col-sm-12  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Today's Orders</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
          <div class="cucontent">
            <?php if($todaytiffinorder >= 1){ ?>
            <div class="tiffin">
              Tiffin : <span class="today-tiffin-data">{{$todaytiffinorder}}</span>
            </div>
            <?php } ?>
            <div class="today-menu">
              <?php
               for($q=0;$q<count($todaymenu);$q++){
               ?>
               <?php echo $todaymenu[$q]['name'] ?> : <span class=""><?php echo $todaymenu[$q]['qty'] ?></span><br>
               <?php
                }
               ?>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="col-md-2 col-sm-12  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tomorrow's Orders</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
          <div class="cucontent">
            <?php if($tomorrowtiffinorder >= 1){ ?>
            <div class="tiffin">
              Tiffin : <span class="tomorrow-tiffin-data">{{$tomorrowtiffinorder}}</span>
            </div>
            <?php } ?>
            <div class="tomorrow-menu">
              <?php
               for($q=0;$q<count($tomorrowmenu);$q++){
               ?>
               <?php echo $tomorrowmenu[$q]['name'] ?> : <span class=""><?php echo $tomorrowmenu[$q]['qty'] ?></span><br>
               <?php
                }
               ?>
            </div>
          </div>
        </div>
    </div>
  </div>

  <div class="col-md-8 col-sm-12  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Upcoming Catering Orders</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
            <div class="table-responsive">
              <table id="cateringtodayacceptorder" class="table cell-border table-striped table-border jambo_table bulk_action">
                <!--
                <thead>
                <tr>
                  <th width="20%">Delivery Date</th>
                  <th width="10%">Count</th>
                  <th width="70%">Items</th>
                </tr>
                </thead>
                -->
                <tbody>

                </tbody>
              </table>
            </div>
        </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
/*
$('#cateringtodayacceptorder').DataTable( {
  scrollCollapse: true,
  paging:         false
});
*/
fetchcateringRecords();
function fetchcateringRecords(){
$.ajax({
 url: 'getcateringdata',
 type: 'get',
 dataType: 'json',
 success: function(response){
   var len = 0;
   $('#cateringtodayacceptorder tbody').empty(); // Empty <tbody>
   if(response['data'] != null){
      len = response['data'].length;
   }

   if(len > 0){
      for(var i=0; i<len; i++){
         var id = response['data'][i].id;
         var delivery_date = response['data'][i].delivery_date;
         var totcount = response['data'][i].count;
         var name = response['data'][i].name;

         var tr_str = "<tr>" +
           "<td>" + delivery_date + "</td>" +
           "<td>" + totcount + "</td>" +
           "<td>" + name + "</td>" +
         "</tr>";

         $("#cateringtodayacceptorder tbody").append(tr_str);
      }
   }else{
      var tr_str = "<tr>" +
          "<td align='center' colspan='5'>No data available in table</td>" +
      "</tr>";

      $("#cateringtodayacceptorder tbody").append(tr_str);
   }
 }
});
}

fetchtiffinRecords();
function fetchtiffinRecords(){
$.ajax({
 url: 'gettiffindata',
 type: 'get',
 dataType: 'json',
 success: function(response){

   $('.today-tiffin-data').empty(); // Empty <tbody>
   $('.tomorrow-tiffin-data').empty(); // Empty <tbody>
   if(response['todaytiffinorder'] != null){
      var todaytiffinorder = response['todaytiffinorder'];
      $(".today-tiffin-data").append(todaytiffinorder);
   }else{
      var tr_str = "";
      $(".today-tiffin-data").append(tr_str);
   }
   if(response['tomorrowtiffinorder'] != null){
      var tomorrowtiffinorder = response['tomorrowtiffinorder'];
      $(".tomorrow-tiffin-data").append(tomorrowtiffinorder);
   }else{
      var tr_str = "0";
      $(".tomorrow-tiffin-data").append(tr_str);
   }
 }
});
}

fetchmenuRecords();
function fetchmenuRecords(){
$.ajax({
 url: 'getmenudata',
 type: 'get',
 dataType: 'json',
 success: function(response){
      $('.today-menu').empty(); // Empty <tbody>
      $('.tomorrow-menu').empty(); // Empty <tbody>
      if(response['todaymenu'] != null){
          len = response['todaymenu'].length;
          if(len>0){
            for(var i=0; i<len; i++){
               var name = response['todaymenu'][i].name;
               var qty = response['todaymenu'][i].qty;
               var daat = name + " : <span>"+qty+"</span><br>";
               $(".today-menu").append(daat);
            }
          }
      }else{
         var tr_str = "";
         $(".today-menu").append(tr_str);
      }
      if(response['tomorrowmenu'] != null){
          len = response['tomorrowmenu'].length;
          if(len>0){
            for(var i=0; i<len; i++){
               var name = response['tomorrowmenu'][i].name;
               var qty = response['tomorrowmenu'][i].qty;
               var daat = name + " : <span>"+qty+"</span><br>";
               $(".tomorrow-menu").append(daat);
            }
          }
      }else{
         var tr_str = "";
         $(".tomorrow-menu").append(tr_str);
      }
 }
});
}
var intervalId = window.setInterval(function(){
  fetchcateringRecords();
  fetchtiffinRecords();
  fetchmenuRecords();
}, 30000);

});
</script>


@endsection
