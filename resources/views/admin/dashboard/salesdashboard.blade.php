@extends('admin.layout.dashboard')
@section('content')

@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','currency','tenant_title','tenant_favicon','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- page content -->
<h1>{{$webpage}}</h1>
<!-- top tiles -->
<div class="row" style="display: inline-block;" >
<div class="tile_count">
<div class="col-md-12 col-sm-12  tile_stats_count">

</div>
</div>
</div>
<!-- /top tiles -->

<!-- top tiles -->
<div class="tile_count">
<div class="row" >
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Order</span>
<div class="count">{{$todaytotalorder}} / {{$todaytotalorderpicked}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Tiffin order</span>
<div class="count">{{$todaytiffinorder}} / {{$todaytiffinorderpicked}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Menu order</span>
<div class="count">{{$todaymenuorder}} / {{$todaymenuorderpicked}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Catering order</span>
<div class="count">{{$todaycateringorder}} / {{$todaycateringorderpicked}}</div>
</div>
</div>
</div>

<div class="tile_count">
<div class="row" >
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Income</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_amount}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Cash Income</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['cash']}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Check Income</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['check']}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Credit Card Income</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['creditcard']}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Today's Paypal Income</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['paypal']}}</div>
</div>
</div>
</div>
<!-- /top tiles -->


<div class="row">
  <div class="col-md-2 col-sm-12  widget_tally_box ">
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
  <div class="col-md-2 col-sm-12  widget_tally_box ">
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

  <div class="col-md-8 col-sm-12  widget_tally_box ">
    <div class="x_panel">
      <div class="x_title">
        <h2>Upcoming Catering Orders</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
            <div class="table-responsive">
              <table id="cateringtodayacceptorder" class="table cell-border table-striped table-border jambo_table bulk_action">
                <tbody>
                </tbody>
              </table>
            </div>
        </div>
    </div>
  </div>
</div>

<?php
/*
<div class="row">
  <div class="col-md-4 col-sm-12  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tiffin - Today Accepted Order</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
          <?php
            if(count($tiffintodayacceptorder) >= 1){
          ?>
          <div class="table-responsive">
            <table id="tiffintodayacceptorder" class="table table-striped jambo_table bulk_action">
              <thead>
              <tr>
                <th width="5%"></th>
                <th width="5%">Order ID</th>
                <th width="30%">Payment Method</th>
                <th width="30%">Grand Total</th>
                <th width="30%">Delivery Date</th>
              </tr>
              </thead>
              <tbody>
                <?php
                for($i=0,$j=1;$i<count($tiffintodayacceptorder);$i++,$j++){
                ?>
                <tr>
                  <td wisth="5%">{{$j}}</td>
                  <td wisth="5%">#{{$tiffintodayacceptorder[$i]->id}}</td>
                  <td wisth="30%">{{$tiffintodayacceptorder[$i]->payment_method}}</td>
                  <td wisth="30%">{{$theme_data->currency}}{{$tiffintodayacceptorder[$i]->grand_total}}</td>
                  <td wisth="30%">{{ Carbon\Carbon::parse($tiffintodayacceptorder[$i]->delivery_date)->format($theme_data->datetime_format) }}</td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <?php
            }else{
          ?>
          <p>No Order found</p>
          <?php
            }
          ?>
        </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-12  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Catering - Today Accepted Order</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
          <?php
            if(count($cateringtodayacceptorder) >= 1){
          ?>
          <div class="table-responsive">
            <table id="cateringtodayacceptorder" class="table table-striped jambo_table bulk_action">
              <thead>
              <tr>
                <th width="5%"></th>
                <th width="5%">Order ID</th>
                <th width="30%">Payment Method</th>
                <th width="30%">Grand Total</th>
                <th width="30%">Delivery Date</th>
              </tr>
              </thead>
              <tbody>
                <?php
                for($i=0,$j=1;$i<count($cateringtodayacceptorder);$i++,$j++){
                ?>
                <tr>
                  <td wisth="5%">{{$j}}</td>
                  <td wisth="5%">#{{$cateringtodayacceptorder[$i]->id}}</td>
                  <td wisth="30%">{{$cateringtodayacceptorder[$i]->payment_method}}</td>
                  <td wisth="30%">{{$theme_data->currency}}{{$cateringtodayacceptorder[$i]->grand_total}}</td>
                  <td wisth="30%">{{ Carbon\Carbon::parse($cateringtodayacceptorder[$i]->delivery_date)->format($theme_data->datetime_format) }}</td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <?php
            }else{
          ?>
          <p>No Order found</p>
          <?php
            }
          ?>
        </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-12  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Menu - Today Accepted Order</h2>
        <div class="clearfix"></div>
      </div>
        <div class="x_content">
          <?php
            if(count($menutodayacceptorder) >= 1){
          ?>
          <div class="table-responsive">
            <table id="menutodayacceptorder" class="table table-striped jambo_table bulk_action">
              <thead>
              <tr>
                <th width="5%"></th>
                <th width="5%">Order ID</th>
                <th width="30%">Payment Method</th>
                <th width="30%">Grand Total</th>
                <th width="30%">Delivery Date</th>
              </tr>
              </thead>
              <tbody>
                <?php
                for($i=0,$j=1;$i<count($menutodayacceptorder);$i++,$j++){
                ?>
                <tr>
                  <td wisth="5%">{{$j}}</td>
                  <td wisth="5%">#{{$menutodayacceptorder[$i]->id}}</td>
                  <td wisth="30%">{{$menutodayacceptorder[$i]->payment_method}}</td>
                  <td wisth="30%">{{$theme_data->currency}}{{$menutodayacceptorder[$i]->grand_total}}</td>
                  <td wisth="30%">{{ Carbon\Carbon::parse($menutodayacceptorder[$i]->delivery_date)->format($theme_data->datetime_format) }}</td>
                </tr>
                <?php
                }
                ?>
              </tbody>
            </table>
          </div>
          <?php
            }else{
          ?>
          <p>No Order found</p>
          <?php
            }
          ?>
        </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 col-sm-4 ">
    <div class="x_panel tile fixed_height_320 overflow_hidden">
      <div class="x_title">
        <h2>Orders</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="" style="width:100%">
          <tr>
            <th style="width:37%;">
              <p>Total Order : {{$totalorder}}</p>
            </th>
            <th>
              <div class="col-lg-7 col-md-7 col-sm-7 ">
                <p class="">Status</p>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-5 ">
                <p class="">Count</p>
              </div>
            </th>
          </tr>
          <tr>
            <td>
              <?php
                $order_data_array = array();
                $order_data_array[0]=$paidorder;
                $order_data_array[1]=$unpaidorder;
                $ordercanvasDoughnut = json_encode($order_data_array);
              ?>
              <canvas class="ordercanvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
            </td>
            <td>
              <table class="tile_info">
                <tr>
                  <td>
                    <p><i class="fa fa-square green"></i>Paid Order</p>
                  </td>
                  <td>{{$paidorder}}</td>
                </tr>
                <tr>
                  <td>
                    <p><i class="fa fa-square red"></i>Unpaid Order</p>
                  </td>
                  <td>{{$unpaidorder}}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4 ">
    <div class="x_panel tile fixed_height_320 overflow_hidden">
      <div class="x_title">
        <h2>Orders ( Picked up And Not Picked up )</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="" style="width:100%">
          <tr>
            <th style="width:37%;">
              <p>Total Order : {{$totalorder}}</p>
            </th>
            <th>
              <div class="col-lg-7 col-md-7 col-sm-7 ">
                <p class="">Status</p>
              </div>
              <div class="col-lg-5 col-md-5 col-sm-5 ">
                <p class="">Count</p>
              </div>
            </th>
          </tr>
          <tr>
            <td>
              <?php
                $order_t_data_array = array();
                $order_t_data_array[0]=$acceptorder;
                $order_t_data_array[1]=$pickuporder;
                //$order_t_data_array[2]=$rejectedorder;
                $orderscanvasDoughnut = json_encode($order_t_data_array);
              ?>
              <canvas class="orderscanvasDoughnut" height="140" width="140" style="margin: 15px 10px 10px 0"></canvas>
            </td>
            <td>
              <table class="tile_info">
                <tr>
                  <td>
                    <p><i class="fa fa-square aero"></i>Not Picked up</p>
                  </td>
                  <td>{{$acceptorder}}</td>
                </tr>
                <tr>
                  <td>
                    <p><i class="fa fa-square green"></i>Picked up</p>
                  </td>
                  <td>{{$pickuporder}}</td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
  <div class="col-md-4 col-sm-4  widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <h2>Order History</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <?php
          $order_history = json_encode($order_history_data);
        ?>
        <div id="order_graph_bar" style="width:100%; height:200px;"></div>
        <div class=" bg-white progress_summary">
        </div>
      </div>
    </div>
  </div>
</div>
*/
?>

<script>
$(document).ready(function(){


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

  /*
$('#tiffintodayacceptorder').DataTable( {
  scrollCollapse: true,
  paging:         false
});
$('#cateringtodayacceptorder').DataTable( {
  scrollCollapse: true,
  paging:         false
});
$('#menutodayacceptorder').DataTable( {
  scrollCollapse: true,
  paging:         false
});

$('#pendatatable').DataTable( {
  scrollCollapse: true,
  paging:         false
});
$('#accdatatable').DataTable( {
  scrollCollapse: true,
  paging:         false
});

if ($('.ordercanvasDoughnut').length) {
    var chart_doughnut_settings = {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: {
            labels: [
                "Paid Order",
                "Unpaid Order"

            ],
            datasets: [{
                data: <?php //echo $ordercanvasDoughnut; ?>,
                backgroundColor: [
                    "#26B99A",
                    "#E74C3C"

                ],
                hoverBackgroundColor: [
                    "#36CAAB",
                    "#E95E4F"

                ]
            }]
        },
        options: {
            legend: false,
            responsive: false
        }
    }
    $('.ordercanvasDoughnut').each(function () {
        var chart_element = $(this);
        var chart_doughnut = new Chart(chart_element, chart_doughnut_settings);
    });
}
if ($('.orderscanvasDoughnut').length) {
    var chart_doughnut_settings = {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: {
            labels: [
                "Not Picked up",
                "Picked up",

            ],
            datasets: [{
                data: <?php //echo $orderscanvasDoughnut; ?>,
                backgroundColor: [
                    "#BDC3C7",
                    "#26B99A",
                ],
                hoverBackgroundColor: [
                    "#CFD4D8",
                    "#36CAAB",
                ]
            }]
        },
        options: {
            legend: false,
            responsive: false
        }
    }
    $('.orderscanvasDoughnut').each(function () {
        var chart_element = $(this);
        var chart_doughnut = new Chart(chart_element, chart_doughnut_settings);
    });
}


if ($('#order_graph_bar').length) {

    Morris.Bar({
        element: 'order_graph_bar',
        data: <?php //echo $order_history; ?>,
        xkey: 'month',
        ykeys: ['order'],
        labels: ['Order'],
        barRatio: 0.4,
        barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        xLabelAngle: 0,
        hideHover: 'auto',
        resize: true
    });

}
*/
});

</script>


@endsection
