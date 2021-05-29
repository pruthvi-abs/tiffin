@extends('admin.layout.dashboard')
@section('content')
@php
  $theme_data = App\ThemeSetting::select('tenant_image','datetime_format','currency','tenant_title','tenant_favicon','order_cutoff_time')->where('deleted_at',null)->where('id',1)->first();
@endphp
<style>
.radio > label {
	display: inline-block;
	margin-bottom: .5rem;
	position: relative;
	margin-right: 10px;
}
.radio > label input.report_date {
	position: relative;
	display: block;
	float: left;
	width: auto;
	margin-top: -9px;
	margin-right: 10px;
}
.radio > label > span {
	float: left;
	position: relative;
	display: inline-block;
	width: auto;
}
</style>
<div class="page-title">
  	<div class="col-md-8 col-sm-8 form-group pull-right">
    	<h3>{{ $action }}</h3>
		</div>
    <div class="col-md-4 text-right">
      {!! Form::open(['route'=>'report.datepdf','method'=>'POST','role'=>'form','id'=>'formsubmit','style'=>'margin-right:10px;margin-left:10px;','target'=>'_blank']) !!}
          @php
            $encodedorder_report = json_encode($order_report);
            $catering_encodedorder_report = json_encode($catering_order_report);
            $menu_encodedorder_report = json_encode($menu_order_report);
            $payment_total_report_data = json_encode($payment_total_report);
          @endphp
          <input type="hidden" name="order_reports" value="{{$encodedorder_report}}"/>
          <input type="hidden" name="catering_order_reports" value="{{$catering_encodedorder_report}}"/>
          <input type="hidden" name="menu_order_reports" value="{{$menu_encodedorder_report}}"/>
          <input type="hidden" name="payment_details_show" value="{{$payment_details_show}}"/>
          <input type="hidden" name="payment_total_report" value="{{$payment_total_report_data}}"/>
          {!! Form::submit('PDF',['class'=>'btn-sm btn bg-purple pull-right','target'=>'_blank']) !!}
      {!! Form::close() !!}
      <?php
      /*
      {!! Form::open(['route'=>'report.dateexcel','method'=>'POST','role'=>'form','id'=>'formsubmit','style'=>'margin-right:10px;margin-left:10px;display:inline-block;']) !!}
          @php
            $encodedorder_report = json_encode($order_report);
          @endphp
          <input type="hidden" name="order_reportsexcel" value="{{$encodedorder_report}}"/>
          {!! Form::submit('Excel',['class'=>'btn-sm btn bg-green pull-right']) !!}
      {!! Form::close() !!}
      */
      ?>
    </div>
</div>
<div class="clearfix"></div>


       {!! Form::open(['route'=>'report','method'=>'POST','role'=>'form','id'=>'formsubmit']) !!}
       <div class="box-body">
      <div class="row">
        <div class="col-md-12">
          <div class="form-group">
            <div class="radio">
              <label><input type="radio" value="yes" name="payment_details" <?php if($payment_details_show=="yes"){ echo "checked"; } ?> class="report_date form-control required"/> <span>With Payment Details</span></label>
              <label><input type="radio" value="no" name="payment_details"  <?php if($payment_details_show=="no"){ echo "checked"; } ?> class="report_date form-control required"/> <span>Without Payment Details</span></label>
           </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="form-group">
            <div class="radio">
             <label><input type="radio" value="today" <?php if($report_day_type=="today"){ echo "checked"; } ?> name="report_date" class="report_date cust form-control required"/> <span>Today</span></label>
             <label><input type="radio" value="tomorrow" <?php if($report_day_type=="tomorrow"){ echo "checked"; } ?> name="report_date" class="report_date cust form-control required"/> <span>Tomorrow</span></label>
             <label><input type="radio" value="nextweek" <?php if($report_day_type=="nextweek"){ echo "checked"; } ?> name="report_date" class="report_date cust form-control required"/> <span>Next week (Next 7 days)</span></label>
             <label><input type="radio" value="custom" <?php if($report_day_type=="custom"){ echo "checked"; } ?> name="report_date" class="report_date cust form-control required"/> <span>Custom Date Range</span></label>
           </div>
          </div>
        </div>
      </div>
      <div id="rdnone" <?php if($report_day_type=="custom"){ echo "style='display:block;'"; }else{ echo "style='display:none;'"; } ?>>
       <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            {!! Form::label('fromdate','Select From Date') !!}
            <?php
            if($report_day_type=="custom"){
            ?>
            <input type="text" value="{{ $report_fromdate }}" name="fromdate" class="datepicker1 form-control required"/>
            <?php }else{ ?>
            <input type="text" value="" name="fromdate" class="datepicker1 form-control required"/>
            <?php } ?>
            @if ($errors->has('fromdate'))
              <p class='text-red'>{{ $errors->first('fromdate') }}</p>
             @endif
          </div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
              {!! Form::label('todate','Select To Date') !!}
              <?php
              if($report_day_type=="custom"){
              ?>
              <input type="text" value="{{ $report_todate }}" name="todate" class="datepicker2 form-control required"/>
              <?php }else{ ?>
              <input type="text" value="" name="todate" class="datepicker2 form-control required"/>
              <?php } ?>
              @if ($errors->has('todate'))
                <p class='text-red'>{{ $errors->first('todate') }}</p>
               @endif
            </div>
         </div>
       </div>
     </div>
       <div class="row">
        <div class="col-md-12">
       <div class="box-footer">
         {!! Form::submit('Submit',['class'=>'btn-sm btn bg-purple']) !!}
       </div>
     </div>
   </div>
       </div>
       {!! Form::close() !!}

<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-sm-12">
  <!-- /.box-header -->
    <div class="box-body">
      @if(Session::has('success'))
      	<div class="alert alert-success" role="alert">
      		{!! Session::get('success') !!}
      	</div>
      @elseif(Session::has('error'))
      	<div class="alert alert-danger" role="alert">
      		{!! Session::get('danger') !!}
      	</div>
      @endif
      <?php
      //print_r($order_report)
      ?>
      <style>
      .table td, .table th {padding: 5px;}
      .table thead th {vertical-align: top;}
      .table thead th {border-bottom: none;}
      table.jambo_table {border: 1px solid #000;}
      .table td, .table th {border-top: 1px solid #000;}
      .table thead th,.table tbody td {border-left: 1px solid #000;}
      </style>

      <?php if($payment_details_show=="yes"){ ?>
      <table id="pendatatable" class="table table-striped jambo_table">
      <thead>
      <tr>
      <th width="25%">
        <div>Cash : {{ $theme_data->currency }}<?php echo $payment_total_report['cash']; ?></div>
      </th>
      <th width="25%">
        <div>Check : {{ $theme_data->currency }}<?php echo $payment_total_report['check']; ?></div>
      </th>
      <th width="25%">
        <div>Credit Card : {{ $theme_data->currency }}<?php echo $payment_total_report['creditcard']; ?></div>
      </th>
      <th width="25%">
        <div>Paypal : {{ $theme_data->currency }}<?php echo $payment_total_report['paypal']; ?></div>
      </th>
      </tr>
      <tr>
      <th colspan="3" width="75%">
        <div>Total Amount Received :</div>
      </th>
      <th colspan="1" width="25%">
        <div>
          <?php
            $total = $payment_total_report['cash']+$payment_total_report['check']+$payment_total_report['creditcard']+$payment_total_report['paypal'];
            echo $theme_data->currency.$total;
          ?>
        </div>
      </th>
      </tr>

      <tr>
      <th width="25%">
        <div>Cash : {{ $theme_data->currency }}<?php echo $payment_total_report['cash_refund']; ?></div>
      </th>
      <th width="25%">
        <div>Check : {{ $theme_data->currency }}<?php echo $payment_total_report['check_refund']; ?></div>
      </th>
      <th width="25%">
        <div>Credit Card : {{ $theme_data->currency }}<?php echo $payment_total_report['creditcard_refund']; ?></div>
      </th>
      <th width="25%">
        <div>Paypal : {{ $theme_data->currency }}<?php echo $payment_total_report['paypal_refund']; ?></div>
      </th>
      </tr>
      <tr>
      <th  colspan="3" width="75%">
        <div>Total Amount Refund:</div>
      </th>
      <th colspan="1" width="25%">
        <div>
          <?php
          $total = $payment_total_report['cash_refund']+$payment_total_report['check_refund']+$payment_total_report['creditcard_refund']+$payment_total_report['paypal_refund'];
          echo $theme_data->currency.$total;
          ?>
        </div>
      </th>
      </tr>

      <tr>
      <th  colspan="3" width="75%">
        <div>Total Amount :</div>
      </th>
      <th colspan="1" width="25%">
        <div>
          <?php
            $total_rec = $payment_total_report['cash']+$payment_total_report['check']+$payment_total_report['creditcard']+$payment_total_report['paypal'];
            $total_ref = $payment_total_report['cash_refund']+$payment_total_report['check_refund']+$payment_total_report['creditcard_refund']+$payment_total_report['paypal_refund'];
            $f_amount = $total_rec-$total_ref;
            echo $theme_data->currency.$f_amount;
          ?>
        </div>
      </th>
      </tr>
      </thead>
    </table>
  <?php } ?>


      <?php if(count($order_report)>=1){ ?>
      <div class="table-responsive">
      <table id="pendatatable" class="table table-striped jambo_table">
      <thead>
      <tr>
      <th rowspan="2" colspan="1" width="10%">
      <div>Tiffin</div>
      </th>
      <th rowspan="1" colspan="4" width="35%">Name</th>
      <?php if($payment_details_show=="yes"){ ?>
        <th rowspan="2" colspan="4" width="25%">
        <div>Item, Item, Item</div>
        </th>
      <?php }else{ ?>
        <th rowspan="2" colspan="4" width="35%">
        <div>Item, Item, Item</div>
        </th>
      <?php } ?>
      <th rowspan="2" colspan="1" width="10%">
      <div>Time</div>
      </th>
      <th rowspan="2" colspan="1"  width="10%">
      <div>Paid</div>
      </th>
      <?php if($payment_details_show=="yes"){ ?>
        <th rowspan="2" colspan="1"  width="10%">
        <div>Payment</div>
        </th>
      <?php } ?>
      </tr>
      <tr>
      <th rowspan="1" colspan="3" width="20%">Email</th>
      <th width="15%">Phone</th>
      </tr>
      </thead>
      <tbody>
        <?php for($i=0;$i<count($order_report);$i++){ ?>
          <tr>
          @if($order_report[$i]['amount_received']=="Yes")
            <td rowspan="2" colspan="1"><div>#{{$order_report[$i]['id']}} <br> Picked up</div></td>
          @else
            <td bgcolor="#A020F0" style="color:#fff;" rowspan="2" colspan="1"><div>#{{$order_report[$i]['id']}} <br> Not picked up</div></td>
          @endif
          <td rowspan="1" colspan="4">{{$order_report[$i]['name']}}</td>
          <td rowspan="2" colspan="4">
          <div>
            <?php for($k=0;$k<count($order_report[$i]['products']);$k++){ ?>
              @if($k==0)
                {{$order_report[$i]['products'][$k]['pname']}}
              @else
                , {{$order_report[$i]['products'][$k]['pname']}}
              @endif
            <?php } ?>
          </div>
          </td>
          <td rowspan="2" colspan="1">
          <div>{{$order_report[$i]['delivery_date']}}</div>
          </td>
          @if($order_report[$i]['amount_received']=="Yes")
            <td rowspan="2" colspan="1"><div>
              <?php if($payment_details_show=="yes"){ ?>
                <strong>
                  <?php $amt = $order_report[$i]['total_amount_received']-$order_report[$i]['total_amount_refund']; ?>
                  {{$theme_data->currency.$amt}}
                  /
                  <?php echo $order_report[$i]['grand_total']; ?>
                </strong>
              <br>
              <?php } ?>
              Paid </div></td>
          @else
            <td bgcolor="#A020F0" style="color:#fff;" rowspan="2" colspan="1"><div>
              <?php if($payment_details_show=="yes"){ ?>
                <strong>
                  <?php $amt = $order_report[$i]['total_amount_received']-$order_report[$i]['total_amount_refund']; ?>
                  {{$theme_data->currency.$amt}}
                  /
                  <?php echo $order_report[$i]['grand_total']; ?>
                </strong>
              <br>
            <?php } ?>
              Unpaid </div>
            </td>
          @endif
          <?php if($payment_details_show=="yes"){ ?>
            <td rowspan="2" colspan="1">
              <div>
                <?php
                  if($order_report[$i]['payment_details_s']=="yes"){
                    echo "Received : <br>";
                    for($k=0;$k<count($order_report[$i]['payment_details']);$k++){
                      echo $order_report[$i]['payment_details'][$k]['payment_details_type']." : ".$order_report[$i]['payment_details'][$k]['payment_details_amount'];
                    }
                  }
                ?>
                <?php
                if($order_report[$i]['payment_details_r']=="yes"){
                  echo "<br>Refund : <br>";
                  for($k=0;$k<count($order_report[$i]['payment_details_refund']);$k++){
                   echo $order_report[$i]['payment_details_refund'][$k]['payment_details_type_refund']." : ".$order_report[$i]['payment_details_refund'][$k]['payment_details_amount_refund'];
                  }
                 }
                 ?>
              </div>
            </td>
          <?php } ?>
          </tr>
          <tr>
          <td rowspan="1" colspan="3">{{$order_report[$i]['user_email']}}</td>
          <td>{{$order_report[$i]['mobile']}}</td>
          </tr>
      <?php } ?>
      </tbody>
      </table>
      </div>
      <?php } ?>



      <!-- Catering -->
      <?php if(count($catering_order_report)>=1){ ?>
      <div class="table-responsive">
      <table id="pendatatable" class="table table-striped jambo_table">
        <thead>
        <tr>
        <th rowspan="2" colspan="1" width="10%">
        <div>Catering</div>
        </th>
        <th rowspan="1" colspan="4" width="35%">Name</th>
        <?php if($payment_details_show=="yes"){ ?>
          <th rowspan="2" colspan="4" width="25%">
          <div>Item, Item, Item</div>
          </th>
        <?php }else{ ?>
          <th rowspan="2" colspan="4" width="35%">
          <div>Item, Item, Item</div>
          </th>
        <?php } ?>
        <th rowspan="2" colspan="1" width="10%">
        <div>Time</div>
        </th>
        <th rowspan="2" colspan="1"  width="10%">
        <div>Paid</div>
        </th>
        <?php if($payment_details_show=="yes"){ ?>
          <th rowspan="2" colspan="1"  width="10%">
          <div>Payment</div>
          </th>
        <?php } ?>
        </tr>
        <tr>
        <th rowspan="1" colspan="3" width="20%">Email</th>
        <th width="15%">Phone</th>
        </tr>
        </thead>
      <tbody>
          <?php for($i=0;$i<count($catering_order_report);$i++){ ?>
            <tr>
            @if($catering_order_report[$i]['amount_received']=="Yes")
              <td rowspan="2" colspan="1"><div>#{{$catering_order_report[$i]['id']}} <br> Picked up</div></td>
            @else
              <td bgcolor="#A020F0" style="color:#fff;" rowspan="2" colspan="1"><div>#{{$catering_order_report[$i]['id']}} <br> Not picked up</div></td>
            @endif
            <td rowspan="1" colspan="4">{{$catering_order_report[$i]['name']}}</td>
            <td rowspan="2" colspan="4">
            <div>
              <?php for($k=0;$k<count($catering_order_report[$i]['products']);$k++){ ?>
                @if($k==0)
                  {{$catering_order_report[$i]['products'][$k]['pname']}}
                @else
                  , {{$catering_order_report[$i]['products'][$k]['pname']}}
                @endif
              <?php } ?>
            </div>
            </td>
            <td rowspan="2" colspan="1">
            <div>{{$catering_order_report[$i]['delivery_date']}}</div>
            </td>
            @if($catering_order_report[$i]['amount_received']=="Yes")
              <td rowspan="2" colspan="1">
                <div>
                <?php if($payment_details_show=="yes"){ ?>
                  <strong>
                    <?php $amt = $catering_order_report[$i]['total_amount_received']-$catering_order_report[$i]['total_amount_refund']; ?>
                    {{$theme_data->currency.$amt}}
                    /
                    <?php echo $catering_order_report[$i]['grand_total']; ?>
                  </strong>
                <br>
                <?php } ?>
                Paid
              </div>
              </td>
            @else
              <td bgcolor="#A020F0" style="color:#fff;" rowspan="2" colspan="1">
                <div>
                <?php if($payment_details_show=="yes"){ ?>
                  <strong>
                    <?php $amt = $catering_order_report[$i]['total_amount_received']-$catering_order_report[$i]['total_amount_refund']; ?>
                    {{$theme_data->currency.$amt}}
                    /
                    <?php echo $catering_order_report[$i]['grand_total']; ?>
                  </strong>
                <br>
              <?php } ?>
                Unpaid
              </div>

              </td>
            @endif
            <?php if($payment_details_show=="yes"){ ?>
              <td rowspan="2" colspan="1">
                <div>
                  <?php
                    if($catering_order_report[$i]['payment_details_s']=="yes"){
                    echo "Received : <br>";
                     for($k=0;$k<count($catering_order_report[$i]['payment_details']);$k++){
                      echo $catering_order_report[$i]['payment_details'][$k]['payment_details_type']." : ".$catering_order_report[$i]['payment_details'][$k]['payment_details_amount'];
                      }
                    }
                   ?>
                  <?php
                  if($catering_order_report[$i]['payment_details_r']=="yes"){
                    echo "<br>Refund : <br>";
                    for($k=0;$k<count($catering_order_report[$i]['payment_details_refund']);$k++){
                      echo $catering_order_report[$i]['payment_details_refund'][$k]['payment_details_type_refund']." : ".$catering_order_report[$i]['payment_details_refund'][$k]['payment_details_amount_refund'];
                    }
                  }
                  ?>
                </div>
              </td>
            <?php } ?>
            </tr>
            <tr>
            <td rowspan="1" colspan="3">{{$catering_order_report[$i]['user_email']}}</td>
            <td>{{$catering_order_report[$i]['mobile']}}</td>
            </tr>
        <?php } ?>
      </tbody>
      </table>
      </div>
      <?php } ?>


      <!-- Menu -->
      <?php if(count($menu_order_report)>=1){ ?>
      <div class="table-responsive">
      <table id="pendatatable" class="table table-striped jambo_table">
        <thead>
        <tr>
        <th rowspan="2" colspan="1" width="10%">
        <div>Menu</div>
        </th>
        <th rowspan="1" colspan="4" width="35%">Name</th>
        <?php if($payment_details_show=="yes"){ ?>
          <th rowspan="2" colspan="4" width="25%">
          <div>Item, Item, Item</div>
          </th>
        <?php }else{ ?>
          <th rowspan="2" colspan="4" width="35%">
          <div>Item, Item, Item</div>
          </th>
        <?php } ?>

        <th rowspan="2" colspan="1" width="10%">
        <div>Time</div>
        </th>
        <th rowspan="2" colspan="1"  width="10%">
        <div>Paid</div>
        </th>
        <?php if($payment_details_show=="yes"){ ?>
          <th rowspan="2" colspan="1"  width="10%">
          <div>Payment</div>
          </th>
        <?php } ?>
        </tr>
        <tr>
        <th rowspan="1" colspan="3" width="20%">Email</th>
        <th width="15%">Phone</th>
        </tr>
        </thead>
      <tbody>
        <?php for($i=0;$i<count($menu_order_report);$i++){ ?>
          <tr>
          @if($menu_order_report[$i]['amount_received']=="Yes")
            <td rowspan="2" colspan="1"><div>#{{$menu_order_report[$i]['id']}} <br> Picked up</div></td>
          @else
            <td bgcolor="#A020F0" style="color:#fff;" rowspan="2" colspan="1"><div>#{{$menu_order_report[$i]['id']}} <br> Not picked up</div></td>
          @endif
          <td rowspan="1" colspan="4">{{$menu_order_report[$i]['name']}}</td>
          <td rowspan="2" colspan="4">
          <div>
            <?php for($k=0;$k<count($menu_order_report[$i]['products']);$k++){ ?>
              @if($k==0)
                {{$menu_order_report[$i]['products'][$k]['pname']}}
              @else
                , {{$menu_order_report[$i]['products'][$k]['pname']}}
              @endif
            <?php } ?>
          </div>
          </td>
          <td rowspan="2" colspan="1">
          <div>{{$menu_order_report[$i]['delivery_date']}}</div>
          </td>
          @if($menu_order_report[$i]['amount_received']=="Yes")
            <td rowspan="2" colspan="1"><div>
              <?php if($payment_details_show=="yes"){ ?>
              <strong>
                <?php $amt = $menu_order_report[$i]['total_amount_received']-$menu_order_report[$i]['total_amount_refund']; ?>
                {{$theme_data->currency.$amt}}
                /
                <?php echo $menu_order_report[$i]['grand_total']; ?>
              </strong><br>
              <?php } ?>
              Paid </div></td>
          @else
            <td bgcolor="#A020F0" style="color:#fff;" rowspan="2" colspan="1"><div>
              <?php if($payment_details_show=="yes"){ ?>
                <strong>
                  <?php $amt = $menu_order_report[$i]['total_amount_received']-$menu_order_report[$i]['total_amount_refund']; ?>
                  {{$theme_data->currency.$amt}}
                  /
                  <?php echo $menu_order_report[$i]['grand_total']; ?>
                </strong> <br>
              <?php } ?>
              Unpaid </div></td>
          @endif
          <?php if($payment_details_show=="yes"){ ?>
            <td rowspan="2" colspan="1">
              <div>
                <?php
                  if($menu_order_report[$i]['payment_details_s']=="yes"){
                    echo "Received : <br>";
                    for($k=0;$k<count($menu_order_report[$i]['payment_details']);$k++){
                     echo $menu_order_report[$i]['payment_details'][$k]['payment_details_type']." : ".$menu_order_report[$i]['payment_details'][$k]['payment_details_amount'];
                    }
                  }
                  ?>
                  <?php
                  if($menu_order_report[$i]['payment_details_r']=="yes"){
                    echo "<br>Refund : <br>";
                    for($k=0;$k<count($menu_order_report[$i]['payment_details_refund']);$k++){
                      echo $menu_order_report[$i]['payment_details_refund'][$k]['payment_details_type_refund']." : ".$menu_order_report[$i]['payment_details_refund'][$k]['payment_details_amount_refund'];
                    }
                  }
                  ?>
              </div>
            </td>
          <?php } ?>
          </tr>
          <tr>
          <td rowspan="1" colspan="3">{{$menu_order_report[$i]['user_email']}}</td>
          <td>{{$menu_order_report[$i]['mobile']}}</td>
          </tr>
      <?php } ?>
      </tbody>
      </table>
      </div>
    <?php } ?>

   </div>
  <!-- /.box -->
	</div>
<!-- /.col -->
</div>

<script src="{{asset('public/admin/vendors/Chart.js/dist/Chart.min.js')}}"></script>
<script>
$('.report_date.cust').click(function(){
  var data = $(this).val();
  if(data=="custom"){
    $('#rdnone').attr("style","display:block;");
  }else{
    $('#rdnone').attr("style","display:none;");
  }
});
$(document).ready(function(){

  /*
  $('#pendatatable').DataTable( {
    scrollCollapse: true,
    paging:         false
  });
  */
});
</script>
@endsection
