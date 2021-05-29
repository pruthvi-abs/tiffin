@extends('admin.layout.dashboard')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','currency','tenant_title','tenant_favicon','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<!-- page content -->
<h1>{{$webpage}}</h1>
<!-- top tiles -->


{!! Form::open(['route'=>'yearlydashboard','method'=>'POST','role'=>'form','id'=>'formsubmit','name'=>'yearlydashboardform']) !!}
<div class="row">
  <div class="col-md-5"></div>
   <div class="col-md-2">
     <div class="form-group text-center">
       <?php
        $first_year_data =  DB::select('SELECT * FROM orders order by created_at limit 1');
        if($first_year_data==NULL){
        ?>
        {!! Form::label('year','Select Year') !!}
        <select id="yearselect" class="form-control required" name="year">
          <option value="">Select Year</option>
          <option value="2020">2020</option>
        </select>
        <?php
        }else{
          //$first_year_data =  Order::orderBy('created_at')->first();
          $first_year = date("Y",strtotime($first_year_data[0]->created_at));
          $curr_year = date("Y");
          $count_y = $curr_year-$first_year+1;
       ?>
       {!! Form::label('year','Select Year') !!}
       <select id="yearselect" class="form-control required" name="year">
         <option value="">Select Year</option>
         <option value="2020">2020</option>
         <?php
          for($p=0;$p<$count_y;$p++){
          ?>
          <option value="<?php echo $first_year; ?>" <?php if($first_year==$selectedyear){ echo "selected"; } ?>> <?php echo $first_year; ?></option>
          <?php
          $first_year++;
          }
         ?>
       </select>
       <?php
        }
       ?>

       @if ($errors->has('year'))
         <p class='text-red'>{{ $errors->first('year') }}</p>
        @endif
     </div>
     <!--
     <div class="box-footer">
       {!! Form::submit('Submit',['class'=>'btn-sm btn bg-purple']) !!}
     </div>
    -->
  </div>
  <div class="col-md-5"></div>
</div>
{!! Form::close() !!}

<!-- top tiles -->
<div class="tile_count">
<div class="row" >
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Orders</span>
<div class="count">{{$todaytotalorder}} / {{$todaytotalorderpicked}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Tiffin Orders</span>
<div class="count">{{$todaytiffinorder}} / {{$todaytiffinorderpicked}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Menu Orders</span>
<div class="count">{{$todaymenuorder}} / {{$todaymenuorderpicked}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Catering Orders</span>
<div class="count">{{$todaycateringorder}} / {{$todaycateringorderpicked}}</div>
</div>
</div>
</div>

<div class="tile_count">
<div class="row" >
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Incomes</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_amount}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Cash Incomes</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['cash']}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Check Incomes</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['check']}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Credit Card Incomes</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['creditcard']}}</div>
</div>
<div class="col-md-2 col-sm-4  tile_stats_count">
<span class="count_top">Total Paypal Incomes</span>
<div class="count">{{$theme_data->currency}}{{$payment_total_report['paypal']}}</div>
</div>
</div>
</div>
<!-- /top tiles -->

<div class="row">
  <div class="col-md-6 col-sm-6 widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <?php
          $curr_year_month_data = array();
          $curr_year_cash_data = array();
          $curr_year_creditcard_data = array();
          $curr_year_paypal_data = array();
          $curr_year_check_data = array();
          $curr_total = 0;
          for($i=0,$j=1;$i<count($orderpayment_history_data);$i++,$j++){
            $curr_year_month_data[$i] = $orderpayment_history_data[$j]['name'];
            $curr_year_cash_data[$i] = $orderpayment_history_data[$j]['cash'];
            $curr_year_creditcard_data[$i] = $orderpayment_history_data[$j]['creditcard'];
            $curr_year_check_data[$i] = $orderpayment_history_data[$j]['check'];
            $curr_year_paypal_data[$i] = $orderpayment_history_data[$j]['paypal'];
            $curr_total = $curr_total + $orderpayment_history_data[$j]['cash']+$orderpayment_history_data[$j]['creditcard']+$orderpayment_history_data[$j]['check']+$orderpayment_history_data[$j]['paypal'];
          }
          $curr_year_month_data_j = json_encode($curr_year_month_data);
          $curr_year_cash_data_j = json_encode($curr_year_cash_data);
          $curr_year_creditcard_data_j = json_encode($curr_year_creditcard_data);
          $curr_year_check_data_j = json_encode($curr_year_check_data);
          $curr_year_paypal_data_j = json_encode($curr_year_paypal_data);
        ?>
        <h2>Revenue History - Year - {{$selectedyear}}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="wrapper">
          <canvas id="currRevenue"></canvas>
        </div>
      </div>
    </div>
  </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script>
if ($('#currRevenue').length) {
var ctx = document.getElementById("currRevenue").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?php echo $curr_year_month_data_j; ?>,
    datasets: [{
      label: 'Cash',
      backgroundColor: "#26B99A",
      data: <?php echo $curr_year_cash_data_j; ?>,
    }, {
      label: 'Credit Card',
      backgroundColor: "#34495E",
      data: <?php echo $curr_year_creditcard_data_j; ?>,
    }, {
      label: 'Check',
      backgroundColor: "#ACADAC",
      data: <?php echo $curr_year_check_data_j; ?>,
    }, {
      label: 'Paypal',
      backgroundColor: "#3498DB",
      data: <?php echo $curr_year_paypal_data_j; ?>,
    }],
  },
options: {
    tooltips: {
      displayColors: true,
      callbacks:{
        mode: 'x',
      },
    },
    scales: {
      xAxes: [{
        stacked: true,
        gridLines: {
          display: false,
        }
      }],
      yAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
        },
        type: 'linear',
      }]
    },
    responsive: true,
    maintainAspectRatio: true,
    legend: { position: 'bottom' },
  }
});
}
</script>
  <div class="col-md-6 col-sm-6 widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <?php
          $year_month_data = array();
          $year_cash_data = array();
          $year_creditcard_data = array();
          $year_paypal_data = array();
          $year_check_data = array();
          $year_total = 0;
          for($i=0,$j=1;$i<count($year_orderpayment_history_data);$i++,$j++){
            $year_month_data[$i] = $year_orderpayment_history_data[$j]['name'];
            $year_cash_data[$i] = $year_orderpayment_history_data[$j]['cash'];
            $year_creditcard_data[$i] = $year_orderpayment_history_data[$j]['creditcard'];
            $year_check_data[$i] = $year_orderpayment_history_data[$j]['check'];
            $year_paypal_data[$i] = $year_orderpayment_history_data[$j]['paypal'];
            $year_total = $year_total + $year_orderpayment_history_data[$j]['cash']+$year_orderpayment_history_data[$j]['creditcard']+$year_orderpayment_history_data[$j]['check']+$year_orderpayment_history_data[$j]['paypal'];
          }
          $year_month_data_j = json_encode($year_month_data);
          $year_cash_data_j = json_encode($year_cash_data);
          $year_creditcard_data_j = json_encode($year_creditcard_data);
          $year_check_data_j = json_encode($year_check_data);
          $year_paypal_data_j = json_encode($year_paypal_data);
        ?>
        <h2>Revenue History - Year over year</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <canvas id="yearRevenue"></canvas>
      </div>
    </div>
  </div>
  <script>
  if ($('#yearRevenue').length) {
  var ctx = document.getElementById("yearRevenue").getContext('2d');
  var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?php echo $year_month_data_j; ?>,
      datasets: [{
        label: 'Cash',
        backgroundColor: "#26B99A",
        data: <?php echo $year_cash_data_j; ?>,
      }, {
        label: 'Credit Card',
        backgroundColor: "#34495E",
        data: <?php echo $year_creditcard_data_j; ?>,
      }, {
        label: 'Check',
        backgroundColor: "#ACADAC",
        data: <?php echo $year_check_data_j; ?>,
      }, {
        label: 'Paypal',
        backgroundColor: "#3498DB",
        data: <?php echo $year_paypal_data_j; ?>,
      }],
    },
  options: {
      tooltips: {
        displayColors: true,
        callbacks:{
          mode: 'x',
        },
      },
      scales: {
        xAxes: [{
          stacked: true,
          gridLines: {
            display: false,
          }
        }],
        yAxes: [{
          stacked: true,
          ticks: {
            beginAtZero: true,
          },
          type: 'linear',
        }]
      },
      responsive: true,
      maintainAspectRatio: true,
      legend: { position: 'bottom' },
    }
  });
  }
  </script>
</div>


<div class="row">
  <div class="col-md-6 col-sm-6 widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <?php
          $monthdata_name = array();
          $menu_month_data = array();
          $tiffin_month_data = array();
          $catering_month_data = array();

          $a1=0;$a2=0;$a3=0;$a4=0;$a5=0;$a6=0;$a7=0;$a8=0;$a9=0;$a10=0;$a11=0;$a12=0;
          for($l=0;$l<count($product_history_data);$l++){
           for($u=1;$u<=count($product_history_data[$l]['price_data']);$u++){
             if($u==1){
               $a1 = $a1 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==2){
               $a2 = $a2 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==3){
               $a3 = $a3 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==4){
               $a4 = $a4 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==5){
               $a5 = $a5 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==6){
               $a6 = $a6 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==7){
               $a7 = $a7 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==8){
               $a8 = $a8 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==9){
               $a9 = $a9 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==10){
               $a10 = $a10 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==11){
               $a11 = $a11 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }else{
               $a12 = $a12 + $product_history_data[$l]['price_data'][$u]['total_amt'];
             }
           }
          }

          $m1=0;$m2=0;$m3=0;$m4=0;$m5=0;$m6=0;$m7=0;$m8=0;$m9=0;$m10=0;$m11=0;$m12=0;
          for($l=0;$l<count($tiffin_product_history_data);$l++){
           for($u=1;$u<=count($tiffin_product_history_data[$l]['price_data']);$u++){
             if($u==1){
               $m1 = $m1 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==2){
               $m2 = $m2 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==3){
               $m3 = $m3 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==4){
               $m4 = $m4 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==5){
               $m5 = $m5 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==6){
               $m6 = $m6 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==7){
               $m7 = $m7 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==8){
               $m8 = $m8 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==9){
               $m9 = $m9 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==10){
               $m10 = $m10 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==11){
               $m11 = $m11 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }else{
               $m12 = $m12 + $tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
             }
           }
          }
          $c1=0;$c2=0;$c3=0;$c4=0;$c5=0;$c6=0;$c7=0;$c8=0;$c9=0;$c10=0;$c11=0;$c12=0;
          for($l=0;$l<count($catering_product_history_data);$l++){
           for($u=1;$u<=count($catering_product_history_data[$l]['price_data']);$u++){
             if($u==1){
               $c1 = $c1 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==2){
               $c2 = $c2 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==3){
               $c3 = $c3 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==4){
               $c4 = $c4 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==5){
               $c5 = $c5 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==6){
               $c6 = $c6 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==7){
               $c7 = $c7 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==8){
               $c8 = $c8 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==9){
               $c9 = $c9 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==10){
               $c10 = $c10 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }elseif($u==11){
               $c11 = $c11 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }else{
               $c12 = $c12 + $catering_product_history_data[$l]['price_data'][$u]['total_amt'];
             }
           }
          }

          $menu_month_data[0]=$a1;
          $menu_month_data[1]=$a2;
          $menu_month_data[2]=$a3;
          $menu_month_data[3]=$a4;
          $menu_month_data[4]=$a5;
          $menu_month_data[5]=$a6;
          $menu_month_data[6]=$a7;
          $menu_month_data[7]=$a8;
          $menu_month_data[8]=$a9;
          $menu_month_data[9]=$a10;
          $menu_month_data[10]=$a11;
          $menu_month_data[11]=$a12;
          $tiffin_month_data[0]=$m1;
          $tiffin_month_data[1]=$m2;
          $tiffin_month_data[2]=$m3;
          $tiffin_month_data[3]=$m4;
          $tiffin_month_data[4]=$m5;
          $tiffin_month_data[5]=$m6;
          $tiffin_month_data[6]=$m7;
          $tiffin_month_data[7]=$m8;
          $tiffin_month_data[8]=$m9;
          $tiffin_month_data[9]=$m10;
          $tiffin_month_data[10]=$m11;
          $tiffin_month_data[11]=$m12;
          $catering_month_data[0]=$c1;
          $catering_month_data[1]=$c2;
          $catering_month_data[2]=$c3;
          $catering_month_data[3]=$c4;
          $catering_month_data[4]=$c5;
          $catering_month_data[5]=$c6;
          $catering_month_data[6]=$c7;
          $catering_month_data[7]=$c8;
          $catering_month_data[8]=$c9;
          $catering_month_data[9]=$c10;
          $catering_month_data[10]=$c11;
          $catering_month_data[11]=$c12;
          $monthdata_name_j = json_encode($month_data);
          $menu_month_data_j = json_encode($menu_month_data);
          $tiffin_month_data_j = json_encode($tiffin_month_data);
          $catering_month_data_j = json_encode($catering_month_data);
        ?>
        <h2>Tiffin & Catering Product History - Year - {{$selectedyear}}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="wrapper">
          <canvas id="tcproducthistorymonths"></canvas>
        </div>
      </div>
    </div>
  </div>
<script>
if ($('#tcproducthistorymonths').length) {
var ctx = document.getElementById("tcproducthistorymonths").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: <?php echo $monthdata_name_j; ?>,
    datasets: [{
      label: 'Tiffin',
      backgroundColor: "#26B99A",
      data: <?php echo $tiffin_month_data_j; ?>,
    }, {
      label: 'Catering',
      backgroundColor: "#34495E",
      data: <?php echo $catering_month_data_j; ?>,
    }, {
      label: 'Menu',
      backgroundColor: "#3498DB",
      data: <?php echo $menu_month_data_j; ?>,
    }],
  },
options: {
    tooltips: {
      displayColors: true,
      callbacks:{
        mode: 'x',
      },
    },
    scales: {
      xAxes: [{
        stacked: true,
        gridLines: {
          display: false,
        }
      }],
      yAxes: [{
        stacked: true,
        ticks: {
          beginAtZero: true,
        },
        type: 'linear',
      }]
    },
    responsive: true,
    maintainAspectRatio: true,
    legend: { position: 'bottom' },
  }
});
}
</script>
<div class="col-md-6 col-sm-6 widget_tally_box">
  <div class="x_panel">
    <div class="x_title">
      <?php
        $monthdata_name = array();
        $menu_year_data = array();
        $tiffin_year_data = array();
        $catering_year_data = array();
        $a1=0;$a2=0;$a3=0;$a4=0;$a5=0;
        for($l=0;$l<count($year_product_history_data);$l++){
         for($u=1;$u<=count($year_product_history_data[$l]['price_data']);$u++){
           if($u==1){
             $a1 = $a1 + $year_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==2){
             $a2 = $a2 + $year_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==3){
             $a3 = $a3 + $year_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==4){
             $a4 = $a4 + $year_product_history_data[$l]['price_data'][$u]['total_amt'];
           }else{
             $a5 = $a5 + $year_product_history_data[$l]['price_data'][$u]['total_amt'];
           }
         }
        }
        $m1=0;$m2=0;$m3=0;$m4=0;$m5=0;
        for($l=0;$l<count($year_tiffin_product_history_data);$l++){
         for($u=1;$u<=count($year_tiffin_product_history_data[$l]['price_data']);$u++){
           if($u==1){
             $m1 = $m1 + $year_tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==2){
             $m2 = $m2 + $year_tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==3){
             $m3 = $m3 + $year_tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==4){
             $m4 = $m4 + $year_tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
           }else{
             $m5 = $m5 + $year_tiffin_product_history_data[$l]['price_data'][$u]['total_amt'];
           }
         }
        }
        $c1=0;$c2=0;$c3=0;$c4=0;$c5=0;
        for($l=0;$l<count($year_catering_product_history_data);$l++){
         for($u=1;$u<=count($year_catering_product_history_data[$l]['price_data']);$u++){
           if($u==1){
             $c1 = $c1 + $year_catering_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==2){
             $c2 = $c2 + $year_catering_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==3){
             $c3 = $c3 + $year_catering_product_history_data[$l]['price_data'][$u]['total_amt'];
           }elseif($u==4){
             $c4 = $c4 + $year_catering_product_history_data[$l]['price_data'][$u]['total_amt'];
           }else{
             $c5 = $c5 + $year_catering_product_history_data[$l]['price_data'][$u]['total_amt'];
           }
         }
        }
        $menu_year_data[0]=$a1;
        $menu_year_data[1]=$a2;
        $menu_year_data[2]=$a3;
        $menu_year_data[3]=$a4;
        $menu_year_data[4]=$a5;
        $tiffin_year_data[0]=$m1;
        $tiffin_year_data[1]=$m2;
        $tiffin_year_data[2]=$m3;
        $tiffin_year_data[3]=$m4;
        $tiffin_year_data[4]=$m5;
        $catering_year_data[0]=$c1;
        $catering_year_data[1]=$c2;
        $catering_year_data[2]=$c3;
        $catering_year_data[3]=$c4;
        $catering_year_data[4]=$c5;
        $yeardata_name_j = json_encode($year_data);
        $menu_year_data_j = json_encode($menu_year_data);
        $tiffin_year_data_j = json_encode($tiffin_year_data);
        $catering_year_data_j = json_encode($catering_year_data);
      ?>
      <h2>Product History - Year over year</h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="wrapper">
        <canvas id="tcproducthistoryyears"></canvas>
      </div>
    </div>
  </div>
</div>
<script>
if ($('#tcproducthistoryyears').length) {
var ctx = document.getElementById("tcproducthistoryyears").getContext('2d');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
  labels: <?php echo $yeardata_name_j; ?>,
  datasets: [{
    label: 'Tiffin',
    backgroundColor: "#26B99A",
    data: <?php echo $tiffin_year_data_j; ?>,
  }, {
    label: 'Catering',
    backgroundColor: "#34495E",
    data: <?php echo $catering_year_data_j; ?>,
  }, {
    label: 'Menu',
    backgroundColor: "#3498DB",
    data: <?php echo $menu_year_data_j; ?>,
  }],
},
options: {
  tooltips: {
    displayColors: true,
    callbacks:{
      mode: 'x',
    },
  },
  scales: {
    xAxes: [{
      stacked: true,
      gridLines: {
        display: false,
      }
    }],
    yAxes: [{
      stacked: true,
      ticks: {
        beginAtZero: true,
      },
      type: 'linear',
    }]
  },
  responsive: true,
  maintainAspectRatio: true,
  legend: { position: 'bottom' },
}
});
}
</script>
</div>


<div class="row">
  <div class="col-md-12 col-sm-12 widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <?php $t=0; for($l=0;$l<count($product_history_data);$l++){ ?>
        <?php for($u=1;$u<=count($product_history_data[$l]['price_data']);$u++){ ?>
          <?php $t = $t + $product_history_data[$l]['price_data'][$u]['total_amt']; ?>
        <?php } ?>
        <?php } ?>

        <h2>Menu Product - {{$selectedyear}} - {{$theme_data->currency}}{{$t}}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="table-responsive">
        <table class="table" style="width:100%">
          <tr>
            <th>Menu Item</th>
            <?php for($m=0;$m<count($month_data);$m++){ ?>
              <th>
                <?php echo $month_data[$m]; ?>
              </th>
            <?php } ?>
          </tr>
          <?php for($l=0;$l<count($product_history_data);$l++){ ?>
            <?php $rt=0; for($u=1;$u<=count($product_history_data[$l]['price_data']);$u++){ ?>
                <?php $rt = $rt + $product_history_data[$l]['price_data'][$u]['total_amt']; ?>
            <?php } ?>
          <?php if($rt>0){ ?>
              <tr>
                <td>
                  <?php echo $product_history_data[$l]['name']." : ".$theme_data->currency.$rt ?>
                </td>
              <?php for($u=1;$u<=count($product_history_data[$l]['price_data']);$u++){ ?>
                <td>
                  <?php echo $theme_data->currency.$product_history_data[$l]['price_data'][$u]['total_amt']; ?>
                </td>
              <?php } ?>
             </tr>
          <?php } ?>
        <?php } ?>
        </table>
        </div>
        <?php
        //print_r($product_history_data);
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12 col-sm-12 widget_tally_box">
    <div class="x_panel">
      <div class="x_title">
        <?php $t=0; for($l=0;$l<count($year_product_history_data);$l++){ ?>
        <?php for($u=1;$u<=count($year_product_history_data[$l]['price_data']);$u++){ ?>
          <?php $t = $t + $year_product_history_data[$l]['price_data'][$u]['total_amt']; ?>
        <?php } ?>
        <?php } ?>

        <h2>Menu Product -  Year over year - {{$theme_data->currency}}{{$t}}</h2>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="table-responsive">
        <table class="table" style="width:100%">
          <tr>
            <th>Menu Item</th>
            <?php for($m=0;$m<count($year_data);$m++){ ?>
              <th>
                <?php echo $year_data[$m]; ?>
              </th>
            <?php } ?>
          </tr>
          <?php for($l=0;$l<count($year_product_history_data);$l++){ ?>
          <?php $rt=0; for($u=1;$u<=count($year_product_history_data[$l]['price_data']);$u++){ ?>
              <?php $rt = $rt + $year_product_history_data[$l]['price_data'][$u]['total_amt']; ?>
          <?php } ?>
          <?php if($rt>0){ ?>
          <tr>
            <td>
              <?php echo $year_product_history_data[$l]['name']." : ".$theme_data->currency.$rt ?>
            </td>
          <?php for($u=1;$u<=count($year_product_history_data[$l]['price_data']);$u++){ ?>
            <td>
              <?php echo $theme_data->currency.$year_product_history_data[$l]['price_data'][$u]['total_amt']; ?>
            </td>
          <?php } ?>
         </tr>
        <?php } ?>
        <?php } ?>
        </table>
        </div>
        <?php
        ?>
      </div>
    </div>
  </div>
</div>
<!--<script src="{{asset('public/admin/vendors/Chart.js/dist/Chart.min.js')}}"></script>-->
<script>
$(document).ready(function(){

$('#yearselect').on('change', function() {
   //document.forms[yearlydashboardform].submit();
   this.form.submit();
});

/*
if ($('.ordercanvasDoughnut').length) {
    var chart_doughnut_settings = {
        type: 'doughnut',
        tooltipFillColor: "rgba(51, 51, 51, 0.55)",
        data: {
            labels: [
                "Pay on Pickup",
                "Paypal"

            ],
            datasets: [{
                data: <?php //echo $ordercanvasDoughnut; ?>,
                backgroundColor: [
                    "#26B99A",
                    "#BDC3C7"

                ],
                hoverBackgroundColor: [
                    "#36CAAB",
                    "#CFD4D8"

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
                "Accept Order",
                "Picked up",
            ],
            datasets: [{
                data: <?php //echo $orderscanvasDoughnut; ?>,
                backgroundColor: [
                    "#26B99A",
                    "#BDC3C7",
                ],
                hoverBackgroundColor: [
                    "#36CAAB",
                    "#CFD4D8",
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
*/
/*
if ($('#orderpayments_graph_bar').length) {
    Morris.Bar({
        element: 'orderpayments_graph_bar',
        data: <?php //echo $orderpayment_history; ?>,
        xkey: 'month',
        ykeys: ['order'],
        labels: ['Income'],
        barRatio: 0.4,
        barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
        xLabelAngle: 0,
        hideHover: 'auto',
        resize: true
    });
}
*/

// Bar chart

});
</script>

@endsection
