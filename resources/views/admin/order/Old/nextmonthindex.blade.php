@extends('admin.layout.dashboard')
@section('content')
<style>
.btn-toggle {
  margin: 0 4rem;
  padding: 0;
  position: relative;
  border: none;
  height: 1.5rem;
  width: 3rem;
  border-radius: 1.5rem;
  color: #6b7381;
  background: #bdc1c8;
}
.btn-toggle:focus, .btn-toggle:focus.active, .btn-toggle.focus, .btn-toggle.focus.active {
  outline: none;
}
.btn-toggle:before, .btn-toggle:after {
  line-height: 1.5rem;
  width: 4rem;
  text-align: center;
  font-weight: 600;
  font-size: .75rem;
  text-transform: uppercase;
  letter-spacing: 2px;
  position: absolute;
  bottom: 0;
  transition: opacity .25s;
}
.btn-toggle:before {
  content: 'No';
  left: -4rem;
}
.btn-toggle:after {
  content: 'Yes';
  right: -4rem;
  opacity: .5;
}
.btn-toggle > .handle {
  position: absolute;
  top: 0.1875rem;
  left: 0.1875rem;
  width: 1.125rem;
  height: 1.125rem;
  border-radius: 1.125rem;
  background: #fff;
  transition: left .25s;
}
.btn-toggle.active {
  transition: background-color .25s;
}
.btn-toggle.active {
  background-color: #29b5a8;
}
.btn-toggle.active > .handle {
  left: 1.6875rem;
  transition: left .25s;
}
.btn-toggle.active:before {
  opacity: .5;
}
.btn-toggle.active:after {
  opacity: 1;
}
</style>
<?php
if(Auth::user()->role_id==1){
?>
<div class="page-title">
  	<div class="col-md-9 col-sm-9 form-group pull-right">
    	<h3>{{ $action }}</h3>
		</div>
    <div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
      </div>
    </div>
</div>
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

						<div class="table-responsive">
              <table id="datatable" class="table table-striped jambo_table bulk_action">
                <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Type</th>
                  <th>Delivery Date Time</th>
                  <th>Pay Method</th>
                  <th>Pay Status</th>
                  <th>Order Amount</th>
                  <th>Pending Amount</th>
                  <th>Picked up</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
						</div>
   </div>
  <!-- /.box -->
	</div>
<!-- /.col -->
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{!! url('/order') !!}" method="post" id="editform" novalidate>
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
      <div class="modal-body">
				{{ csrf_field() }}
        <input type="hidden" value="" id="order_id" name="order_id" class="form-control required"/>
          <div class="row">
						<div class="col-md-12">
							{!! Form::label('membername','Member Name : ') !!} <span id="user_name"></span><br>
              {!! Form::label('grandtotal','Grand Total : ') !!} <span id="grandtotal"></span><br>
              {!! Form::label('grandtotal','Remaining Amount : ') !!} <span id="remainingtotal"></span><br>
						</div>
					</div>
          <div class="row">
            <div class="col-md-12">
              <div class="radio">
                 <label><input type="radio" value="Cash" name="payment_type" class="report_date form-control required"/> <span>Cash</span></label>
                 <label><input type="radio" value="Check" name="payment_type" class="report_date form-control required"/>  <span>Check</span></label>
                 <label><input type="radio" value="Credit Card" name="payment_type" class="report_date form-control required"/>  <span>Credit Card</span></label>
                 <label><input type="radio" value="Paypal"  name="payment_type" class="report_date form-control required"/>  <span>Paypal</span></label>
              </div>

 						</div>
          </div>
          <div class="row">
					 	<div class="col-md-12">
							 <div class="form-group">
								 {!! Form::label('payment_details','Payment Details') !!}
								 <input type="text" value="" id="payment_details" name="payment_details" class="form-control required"/>
								 @if ($errors->has('payment_details'))
									 <p class='text-red'>{{ $errors->first('payment_details') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-6">
						 <div class="form-group">
							 {!! Form::label('payment_amount','Amount') !!}
							 <input type="number" value="" step='0.01' min="1" id="payment_amount" name="payment_amount" class="form-control required"/>
							 @if ($errors->has('payment_amount'))
								 <p class='text-red'>{{ $errors->first('payment_amount') }}</p>
								@endif
						 </div>
						</div>
						<div class="col-md-6">
							 <div class="form-group">
								 {!! Form::label('payment_date','Payment Date') !!}
								 <input type="text" value="<?php echo date("m/d/Y H:i:s"); ?>" id="payment_date" name="payment_date" class="datetimepicker1 form-control"/>
								 @if ($errors->has('payment_date'))
									 <p class='text-red'>{{ $errors->first('payment_date') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('notes','Notes') !!}
               <textarea value="" id="notes" name="notes" class="form-control"></textarea>
							 @if ($errors->has('notes'))
								 <p class='text-red'>{{ $errors->first('notes') }}</p>
								@endif
						 </div>
						</div>
					</div>
          <div class="row" id="ordchecknone">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('order_pickup','Order Picked up') !!}
               <span id="ordcheckdata"></span>
               <div class="">
								<label>
									<input type="checkbox" name="order_pickup" value="Yes" class="js-switch ordcheck" />
                  <!--
                  <div class="btn btn-toggle active" data-toggle="button" aria-pressed="false" autocomplete="off">
                    <div class="handle"></div>
                  </div>
                  -->
								</label>
							 </div>
							 @if ($errors->has('order_pickup'))
								 <p class='text-red'>{{ $errors->first('order_pickup') }}</p>
								@endif
						 </div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Payment</button>
      </div>
			</form>
      <script>
        $('input[type="radio"]').on('click change', function(e) {
          if($(this).val()=="Cash"){
              $("#payment_details").removeClass('required');
            }else{
              $("#payment_details").addClass('required');
            }
        });
      $(document).ready(function($) {
        $("#editform").validate({
          rules: {
            payment_type:  "required",
          },
          messages: {
            payment_type:  "This field is required",
          },
          submitHandler: function(form) {
            form.submit();
          }
        });
      });
      </script>
			</form>
    </div>
  </div>
</div>


<!-- refund -->
<div class="modal fade" id="refundpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{!! url('/order') !!}" method="post" id="refundpaymentform" novalidate>
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
      <div class="modal-body">
				{{ csrf_field() }}
        <input type="hidden" value="" id="r_order_id" name="r_order_id" class="form-control required"/>
        <input type="hidden" value="Refund" id="r_payment_status" name="r_payment_status" class="form-control required"/>
          <div class="row">
						<div class="col-md-12">
							{!! Form::label('membername','Member Name : ') !!} <span id="r_user_name"></span><br>
              {!! Form::label('grandtotal','Grand Total : ') !!} <span id="r_grandtotal"></span><br>
              {!! Form::label('grandtotal','Remaining Amount : ') !!} <span id="r_remainingtotal"></span><br>
						</div>
					</div>
          <input type="hidden" value="Paypal"  name="r_payment_type" class="report_date form-control required"/>
          <div class="row">
					 	<div class="col-md-12">
							 <div class="form-group">
								 {!! Form::label('r_payment_details','Payment Payer ID') !!}
								 <input type="text" value="" id="r_payment_details" name="r_payment_details" class="form-control required"/>
								 @if ($errors->has('r_payment_details'))
									 <p class='text-red'>{{ $errors->first('r_payment_details') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-6">
						 <div class="form-group">
							 {!! Form::label('r_payment_amount','Amount') !!}
							 <input type="number" value="" step='0.01' min="1" id="r_payment_amount" name="r_payment_amount" class="form-control required"/>
							 @if ($errors->has('r_payment_amount'))
								 <p class='text-red'>{{ $errors->first('r_payment_amount') }}</p>
								@endif
						 </div>
						</div>
						<div class="col-md-6">
							 <div class="form-group">
								 {!! Form::label('','Payment Date') !!}
								 <input type="text" value="<?php echo date("m/d/Y H:i:s"); ?>" id="r_payment_date" name="r_payment_date" class="datetimepicker1 form-control"/>
								 @if ($errors->has('r_payment_date'))
									 <p class='text-red'>{{ $errors->first('r_payment_date') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('r_notes','Notes') !!}
               <textarea value="" id="r_notes" name="r_notes" class="form-control"></textarea>
							 @if ($errors->has('r_notes'))
								 <p class='text-red'>{{ $errors->first('r_notes') }}</p>
								@endif
						 </div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Refund</button>
      </div>
			</form>
    </div>
  </div>
</div>



<!-- Cancel -->
<div class="modal fade" id="cancelorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{!! url('/order') !!}" method="post" id="cancelorderform" novalidate>
      <div class="modal-body">
				{{ csrf_field() }}
        <input type="hidden" value="" id="c_order_id" name="c_order_id" class="form-control required"/>
          <div class="row">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('c_notes','Notes') !!}
               <textarea value="" id="c_notes" name="c_notes" class="form-control"></textarea>
							 @if ($errors->has('c_notes'))
								 <p class='text-red'>{{ $errors->first('c_notes') }}</p>
								@endif
						 </div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
			</form>
    </div>
  </div>
</div>

<script type="text/javascript">
var oTable="";
$(document).ready(function(){
 oTable = $('#datatable').DataTable({
		"processing": true,
		"serverSide": true,
    "ajax": "{{ route('getNextmonthOrder') }}",
    "aaSorting": [[0, 'asc']],
    "columns": [
      {"bVisible": true, data: 'sr_no', name: 'sr_no'},
      {data: 'name', name: 'name'},
      {data: 'users_email', name: 'users_email'},
      {data: 'mobile', name: 'mobile'},
      {data: 'main_categories_id', name: 'main_categories_id'},
      {data: 'delivery_date', name: 'delivery_date'},
      {data: 'payment_method', name: 'payment_method'},
      {data: 'p_id', name: 'p_id', 'bSortable': false,'mRender':renderactionspaid,'sWidth':'5%'},
      {data: 'grand_total', name: 'grand_total'},
      {data: 'remaining_total_amt', name: 'remaining_total_amt'},
      {data: 'order_pickup', name: 'order_pickup','mRender':renderactionspickup,'sWidth':'5%'},
      {data: 'id', name: 'id', 'bSortable': false,'mRender':renderaction,'sWidth':'12%'},

    ],
		"stateSave": true,
    "stateSaveCallback": function(settings,data) {
    localStorage.setItem('DataTables_'+window.location.pathname, JSON.stringify(data) )
    },
    "stateLoadCallback": function(settings) {
    return JSON.parse( localStorage.getItem( 'DataTables_'+window.location.pathname) )
    },
	});
	oTable.draw();

  oTable.on('click','.approvepayment', function(){
  		$tr = $(this).closest('tr');
  		if($($tr).hasClass('child')){
  			$tr = $tr.prev('.parent');
  		}
  		var data = oTable.row($tr).data();
      var group_data = data['id'];
      var s_oid=group_data.split(',');
  		$('#order_id').val(s_oid[0]);
  		$('#user_name').html(data['name']);
      $('#grandtotal').html(data['grand_total']);
      $('#remainingtotal').html(data['remaining_total_amt']);
      $('#payment_amount').val(data['remaining_total_amt'].substring(1));
      var afdata=data['order_pickup'].split(',');
      var adataid=afdata[0];
      var adatavalue=afdata[1];
      if(adatavalue=="Yes"){
        $('#ordchecknone').attr("style","display:none;");
        $('.ordcheck').prop("checked",true);
      }else{
        $('#ordchecknone').attr("style","display:block;");
        $('.ordcheck').removeAttr("checked");
      }
      $('#editform').attr('action', 'https://www.neoinventions.com/dailytiffin/orderpaid/'+s_oid[0]);
  		$('#editModal').modal('show');
  });

  oTable.on('click','.refundpayment', function(){
  		$tr = $(this).closest('tr');
  		if($($tr).hasClass('child')){
  			$tr = $tr.prev('.parent');
  		}
  		var data = oTable.row($tr).data();
      var group_data = data['id'];
      var s_oid=group_data.split(',');
  		$('#r_order_id').val(s_oid[0]);
  		$('#r_user_name').html(data['name']);
      $('#r_grandtotal').html(data['grand_total']);
      $('#r_remainingtotal').html(data['remaining_total_amt']);
      $('#r_payment_amount').val(data['remaining_total_amt'].substring(1));
      $('#refundpaymentform').attr('action', 'https://www.neoinventions.com/dailytiffin/orderrefund/'+s_oid[0]);
  		$('#refundpayment').modal('show');
  });


    oTable.on('click','.ordclick', function(){
      $tr = $(this).closest('tr');
  		if($($tr).hasClass('child')){
  			$tr = $tr.prev('.parent');
  		}
      var data = oTable.row($tr).data();
      var odata = data['order_pickup'];
      var fdata=odata.split(',');
      var dataid=fdata[0];
      var datavalue=fdata[1];
       swal({
        title: "Are you sure?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-sm btn btn-success",
        confirmButtonText: "Yes, Order Pickeup",
        closeOnConfirm: true
      }, function (isConfirm) {
          if(isConfirm){
            $.ajax({
              url:'{!! url('/orderpick') !!}'+'/'+dataid,
              type:'POST',
              data: { "order_id":dataid,"order_pickup":datavalue,'_method': "POST", '_token' : "{{ Session::token() }}"},
              success:function(data){
                if(data==0){
                  //location.reload();
                  swal("Done!", "Information changed successfully", "success");
    							oTable.draw();
                }
              },
            });
          }else{
            var founddata = $("div.orderpickup"+dataid).hasClass("active");
            if(founddata==true){
              $("div.orderpickup"+dataid).removeClass("active");
            }else{
              $("div.orderpickup"+dataid).addClass("active");
            }
          }
        });
    });
});

function renderactionspickup(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datavalue=fdata[1];
  var dataorderstatus=fdata[2];
  if(dataorderstatus=="Canceled"){
    var fd = "<div class=\"btn btn-toggle\" ><div class=\"handle\"></div></div>";
    return fd;
  }else{
    if(datavalue=="Yes"){
      var fd = "<div attr-value=\"" + datavalue + "\" class=\"btn ordclick orderpickup"+dataid+" btn-toggle active\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
      return fd;
    }else{
      var fd = "<div attr-value=\"" + datavalue + "\" type=\"submit\" class=\"btn ordclick orderpickup"+dataid+" btn-toggle\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
      return fd;
    }
  }
}

function renderaction(data, type, row){
    var fdata=data.split(',');
    var dataid=fdata[0];
    var datastatus=fdata[1];
    var dataorderstatus=fdata[2];
    url='{!! url('/order') !!}'+'/'+dataid;
    if(dataorderstatus=="Canceled"){
      var value =  "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='View' class='btn-sm btnbtn-sm btn btn-primary'>View</a>&nbsp;&nbsp;";
    }else{
      if(datastatus=="No"){
        var value =  "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='View' class='btn-sm btnbtn-sm btn btn-primary'>View</a>&nbsp;&nbsp;"+
        "<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessageReject("+'"'+dataid+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-danger' data-original-title="+"Reject"+">Cancel</a>&nbsp;&nbsp;";
      }else{
        var value =  "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='View' class='btn-sm btnbtn-sm btn btn-primary'>View</a>&nbsp;&nbsp;";
      }
    }
    return value;
}

// Reject Order
function showConfirmMessageReject(id) {
  $('#c_order_id').val(id);
  $('#cancelorderform').attr('action', '{!! url('/orderreject') !!}'+'/'+id);
  $('#cancelorder').modal('show');
  /*
	swal({
  title: "Are you sure?",
  input: 'text',
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, Cancel it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderreject') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Canceled!", "Order Canceled successfully", "success");
							oTable.draw();
						}
					},
				});
			}
});
*/
}

function renderactionspaid(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datastatus=fdata[1];

    if(datastatus=="Paid"){
      var value = "<span>Paid</span>";
      return value;
    }else if(datastatus=="Refunded"){
      var value = "<span>Refunded</span>";
      return value;
    }else if(datastatus=="Canceled"){
      var value = "<span>Canceled</span>";
      return value;
    }else if(datastatus=="Refund"){
      var value = "<a href='javascript:void(0);' class='btn-sm btn btn-danger refundpayment' data-whatever='"+data+"'><span>Refund</span></a>&nbsp;&nbsp;";
      return value;
    }else{
      var value = "<a href='javascript:void(0);' class='btn-sm btn btn-success approvepayment' data-whatever='"+data+"'><span>Pay</span></a>&nbsp;&nbsp;";
			//var value ="<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessagePaid("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-success' data-original-title="+"Accept"+">Paid</a>";
      return value;
    }
}

// Paid Order
/*
function showConfirmMessagePaid(id) {
	swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-success",
  confirmButtonText: "Yes, Amount receive!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderpaid') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Accepted!", "Amount Received successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
*/
/*
function renderactions(data, type, row){
  //return data;
    if(data==""){
      return "";
    }else{
			var value ="<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessageAccept("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-success' data-original-title="+"Accept"+">Accept</a>&nbsp;&nbsp;"+
      "<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessageReject("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-danger' data-original-title="+"Reject"+">Reject</a>&nbsp;&nbsp;";
      return value;
    }
}
// Reject Order
function showConfirmMessageReject(id) {
	swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, Reject it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderreject') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Rejected!", "Order rejected successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
// Approve Order
function showConfirmMessageAccept(id) {
	swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-success",
  confirmButtonText: "Yes, Accept it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderaccept') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Accepted!", "Order Accepted successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
*/

</script>



















<?php
// sales user
}elseif(Auth::user()->role_id==2){
?>
<div class="page-title">
  	<div class="col-md-9 col-sm-9 form-group pull-right">
    	<h3>{{ $action }}</h3>
		</div>
    <div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
      </div>
    </div>
</div>
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

						<div class="table-responsive">
              <table id="datatable" class="table table-striped jambo_table bulk_action">
                <thead>
                <tr>
                  <th></th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Type</th>
                  <th>Delivery Date Time</th>
                  <th>Pay Method</th>
                  <th>Pay Status</th>
                  <th>Order Amount</th>
                  <th>Pending Amount</th>
                  <th>Picked up</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
						</div>
   </div>
  <!-- /.box -->
	</div>
<!-- /.col -->
</div>


<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

			<form action="{!! url('/order') !!}" method="post" id="editform">
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
      <div class="modal-body">
				{{ csrf_field() }}
        <input type="hidden" value="" id="order_id" name="order_id" class="form-control required"/>
          <div class="row">
						<div class="col-md-12">
							{!! Form::label('membername','Member Name : ') !!} <span id="user_name"></span><br>
              {!! Form::label('grandtotal','Grand Total : ') !!} <span id="grandtotal"></span><br>
              {!! Form::label('grandtotal','Remaining Amount : ') !!} <span id="remainingtotal"></span><br>
						</div>
					</div>
          <div class="row">
            <div class="col-md-12">
              <div class="radio">
                 <label><input type="radio" value="Cash" name="payment_type" class="report_date form-control required"/> <span>Cash</span></label>
                 <label><input type="radio" value="Check" name="payment_type" class="report_date form-control required"/>  <span>Check</span></label>
                 <label><input type="radio" value="Credit Card" name="payment_type" class="report_date form-control required"/>  <span>Credit Card</span></label>
                 <label><input type="radio" value="Paypal"  name="payment_type" class="report_date form-control required"/>  <span>Paypal</span></label>
              </div>
 						</div>
          </div>
          <div class="row">
					 <div class="col-md-6">
						 <div class="form-group">
							 {!! Form::label('account_type','Account Type') !!}
							 <input type="text" value="" id="account_type" name="account_type" class="form-control required"/>
							 @if ($errors->has('account_type'))
								 <p class='text-red'>{{ $errors->first('account_type') }}</p>
								@endif
						 </div>
						</div>
						<div class="col-md-6">
							 <div class="form-group">
								 {!! Form::label('payment_details','Payment Details') !!}
								 <input type="text" value="" id="payment_details" name="payment_details" class="form-control"/>
								 @if ($errors->has('payment_details'))
									 <p class='text-red'>{{ $errors->first('payment_details') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-6">
						 <div class="form-group">
							 {!! Form::label('payment_amount','Amount') !!}
							 <input type="number" value="" step='0.01' min="1" id="payment_amount" name="payment_amount" class="form-control required"/>
							 @if ($errors->has('payment_amount'))
								 <p class='text-red'>{{ $errors->first('payment_amount') }}</p>
								@endif
						 </div>
						</div>
						<div class="col-md-6">
							 <div class="form-group">
								 {!! Form::label('payment_date','Payment Date') !!}
								 <input type="text" value="" id="payment_date" name="payment_date" class="datepicker1 form-control"/>
								 @if ($errors->has('payment_date'))
									 <p class='text-red'>{{ $errors->first('payment_date') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('notes','Notes') !!}
               <textarea value="" id="notes" name="notes" class="form-control required"></textarea>
							 @if ($errors->has('notes'))
								 <p class='text-red'>{{ $errors->first('notes') }}</p>
								@endif
						 </div>
						</div>
					</div>
          <div class="row" id="ordchecknone">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('order_pickup','Order Picked up') !!}
               <span id="ordcheckdata"></span>
               <div class="">
								<label>
									<input type="checkbox" name="order_pickup" value="Yes" class="js-switch ordcheck" />
                  <!--
                  <div class="btn btn-toggle active" data-toggle="button" aria-pressed="false" autocomplete="off">
                    <div class="handle"></div>
                  </div>
                  -->
								</label>
							 </div>
							 @if ($errors->has('order_pickup'))
								 <p class='text-red'>{{ $errors->first('order_pickup') }}</p>
								@endif
						 </div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Payment</button>
      </div>
			</form>
      <script>
        $('input[type="radio"]').on('click change', function(e) {
          if($(this).val()=="Cash"){
              $("#payment_details").removeClass('required');
            }else{
              $("#payment_details").addClass('required');
            }
        });
      $(document).ready(function($) {
        $("#editform").validate({
          rules: {
            payment_type:  "required",
          },
          messages: {
            payment_type:  "This field is required",
          },
          submitHandler: function(form) {
            form.submit();
          }
        });
      });
      </script>
    </div>
  </div>
</div>


<!-- refund -->
<div class="modal fade" id="refundpayment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Payment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{!! url('/order') !!}" method="post" id="refundpaymentform" novalidate>
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
      <div class="modal-body">
				{{ csrf_field() }}
        <input type="hidden" value="" id="r_order_id" name="r_order_id" class="form-control required"/>
        <input type="hidden" value="Refund" id="r_payment_status" name="r_payment_status" class="form-control required"/>
          <div class="row">
						<div class="col-md-12">
							{!! Form::label('membername','Member Name : ') !!} <span id="r_user_name"></span><br>
              {!! Form::label('grandtotal','Grand Total : ') !!} <span id="r_grandtotal"></span><br>
              {!! Form::label('grandtotal','Remaining Amount : ') !!} <span id="r_remainingtotal"></span><br>
						</div>
					</div>
          <input type="hidden" value="Paypal"  name="r_payment_type" class="report_date form-control required"/>
          <div class="row">
					 	<div class="col-md-12">
							 <div class="form-group">
								 {!! Form::label('r_payment_details','Payment Payer ID') !!}
								 <input type="text" value="" id="r_payment_details" name="r_payment_details" class="form-control required"/>
								 @if ($errors->has('r_payment_details'))
									 <p class='text-red'>{{ $errors->first('r_payment_details') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-6">
						 <div class="form-group">
							 {!! Form::label('r_payment_amount','Amount') !!}
							 <input type="number" value="" step='0.01' min="1" id="r_payment_amount" name="r_payment_amount" class="form-control required"/>
							 @if ($errors->has('r_payment_amount'))
								 <p class='text-red'>{{ $errors->first('r_payment_amount') }}</p>
								@endif
						 </div>
						</div>
						<div class="col-md-6">
							 <div class="form-group">
								 {!! Form::label('','Payment Date') !!}
								 <input type="text" value="<?php echo date("m/d/Y H:i:s"); ?>" id="r_payment_date" name="r_payment_date" class="datetimepicker1 form-control"/>
								 @if ($errors->has('r_payment_date'))
									 <p class='text-red'>{{ $errors->first('r_payment_date') }}</p>
									@endif
							 </div>
							</div>
					</div>
          <div class="row">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('r_notes','Notes') !!}
               <textarea value="" id="r_notes" name="r_notes" class="form-control"></textarea>
							 @if ($errors->has('r_notes'))
								 <p class='text-red'>{{ $errors->first('r_notes') }}</p>
								@endif
						 </div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Refund</button>
      </div>
			</form>
    </div>
  </div>
</div>


<!-- Cancel -->
<div class="modal fade" id="cancelorder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cancel Order</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{!! url('/order') !!}" method="post" id="cancelorderform" novalidate>
      <div class="modal-body">
				{{ csrf_field() }}
        <input type="hidden" value="" id="c_order_id" name="c_order_id" class="form-control required"/>
          <div class="row">
					 <div class="col-md-12">
						 <div class="form-group">
							 {!! Form::label('c_notes','Notes') !!}
               <textarea value="" id="c_notes" name="c_notes" class="form-control"></textarea>
							 @if ($errors->has('c_notes'))
								 <p class='text-red'>{{ $errors->first('c_notes') }}</p>
								@endif
						 </div>
						</div>
					</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
			</form>
    </div>
  </div>
</div>

<script type="text/javascript">
var oTable="";
$(document).ready(function(){
 oTable = $('#datatable').DataTable({
		"processing": true,
		"serverSide": true,
    "ajax": "{{ route('getNextmonthOrder') }}",
    "aaSorting": [[0, 'asc']],
    "columns": [
      {"bVisible": true, data: 'sr_no', name: 'sr_no'},
      {data: 'name', name: 'name'},
      {data: 'users_email', name: 'users_email'},
      {data: 'mobile', name: 'mobile'},
      {data: 'main_categories_id', name: 'main_categories_id'},
      {data: 'delivery_date', name: 'delivery_date'},
      {data: 'payment_method', name: 'payment_method'},
      {data: 'p_id', name: 'p_id', 'bSortable': false,'mRender':renderactionspaid,'sWidth':'5%'},
      {data: 'grand_total', name: 'grand_total'},
      {data: 'remaining_total_amt', name: 'remaining_total_amt'},
      {data: 'order_pickup', name: 'order_pickup','mRender':renderactionspickup,'sWidth':'5%'},
      {data: 'id', name: 'id', 'bSortable': false,'mRender':renderaction,'sWidth':'12%'},
    ],
		"stateSave": true,
    "stateSaveCallback": function(settings,data) {
    localStorage.setItem('DataTables_'+window.location.pathname, JSON.stringify(data) )
    },
    "stateLoadCallback": function(settings) {
    return JSON.parse( localStorage.getItem( 'DataTables_'+window.location.pathname) )
    },
	});
	oTable.draw();

  oTable.on('click','.approvepayment', function(){
      $tr = $(this).closest('tr');
      if($($tr).hasClass('child')){
        $tr = $tr.prev('.parent');
      }
      var data = oTable.row($tr).data();
      var group_data = data['id'];
      var s_oid=group_data.split(',');
      $('#order_id').val(s_oid[0]);
      $('#user_name').html(data['name']);
      $('#grandtotal').html(data['grand_total']);
      $('#remainingtotal').html(data['remaining_total_amt']);
      $('#payment_amount').val(data['remaining_total_amt'].substring(1));
      var afdata=data['order_pickup'].split(',');
      var adataid=afdata[0];
      var adatavalue=afdata[1];
      if(adatavalue=="Yes"){
        $('#ordchecknone').attr("style","display:none;");
        $('.ordcheck').prop("checked",true);
      }else{
        $('#ordchecknone').attr("style","display:block;");
        $('.ordcheck').removeAttr("checked");
      }
      $('#editform').attr('action', 'https://www.neoinventions.com/dailytiffin/orderpaid/'+s_oid[0]);
      $('#editModal').modal('show');
  	});

    oTable.on('click','.refundpayment', function(){
    		$tr = $(this).closest('tr');
    		if($($tr).hasClass('child')){
    			$tr = $tr.prev('.parent');
    		}
    		var data = oTable.row($tr).data();
        var group_data = data['id'];
        var s_oid=group_data.split(',');
    		$('#r_order_id').val(s_oid[0]);
    		$('#r_user_name').html(data['name']);
        $('#r_grandtotal').html(data['grand_total']);
        $('#r_remainingtotal').html(data['remaining_total_amt']);
        $('#r_payment_amount').val(data['remaining_total_amt'].substring(1));
        $('#refundpaymentform').attr('action', 'https://www.neoinventions.com/dailytiffin/orderrefund/'+s_oid[0]);
    		$('#refundpayment').modal('show');
    });

    oTable.on('click','.ordclick', function(){
      $tr = $(this).closest('tr');
  		if($($tr).hasClass('child')){
  			$tr = $tr.prev('.parent');
  		}
      var data = oTable.row($tr).data();
      var odata = data['order_pickup'];
      var fdata=odata.split(',');
      var dataid=fdata[0];
      var datavalue=fdata[1];
       swal({
        title: "Are you sure?",
        text: "",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-sm btn btn-success",
        confirmButtonText: "Yes, Order Pickeup",
        closeOnConfirm: true
      }, function (isConfirm) {
          if(isConfirm){
            $.ajax({
              url:'{!! url('/orderpick') !!}'+'/'+dataid,
              type:'POST',
              data: { "order_id":dataid,"order_pickup":datavalue,'_method': "POST", '_token' : "{{ Session::token() }}"},
              success:function(data){
                if(data==0){
                  //location.reload();
                  swal("Done!", "Information changed successfully", "success");
    							oTable.draw();
                }
              },
            });
          }else{
            var founddata = $("div.orderpickup"+dataid).hasClass("active");
            if(founddata==true){
              $("div.orderpickup"+dataid).removeClass("active");
            }else{
              $("div.orderpickup"+dataid).addClass("active");
            }
          }
        });
    });

});
    $(".approvepayment").trigger( "reset" );
function renderactionspickup(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datavalue=fdata[1];
  var dataorderstatus=fdata[2];
  if(dataorderstatus=="Canceled"){
    var fd = "<div class=\"btn btn-toggle\" ><div class=\"handle\"></div></div>";
    return fd;
  }else{
    if(datavalue=="Yes"){
      var fd = "<div attr-value=\"" + datavalue + "\" class=\"btn ordclick orderpickup"+dataid+" btn-toggle active\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
      return fd;
    }else{
      var fd = "<div attr-value=\"" + datavalue + "\" type=\"submit\" class=\"btn ordclick orderpickup"+dataid+" btn-toggle\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
      return fd;
    }
  }
}
function renderaction(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datastatus=fdata[1];
  var dataorderstatus=fdata[2];
  url='{!! url('/order') !!}'+'/'+dataid;
  if(dataorderstatus=="Canceled"){
    var value =  "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='View' class='btn-sm btnbtn-sm btn btn-primary'>View</a>&nbsp;&nbsp;";
  }else{
    if(datastatus=="No"){
      var value =  "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='View' class='btn-sm btnbtn-sm btn btn-primary'>View</a>&nbsp;&nbsp;"+
      "<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessageReject("+'"'+dataid+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-danger' data-original-title="+"Reject"+">Cancel</a>&nbsp;&nbsp;";
    }else{
      var value =  "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='View' class='btn-sm btnbtn-sm btn btn-primary'>View</a>&nbsp;&nbsp;";
    }
  }
  return value;
}


// Reject Order
function showConfirmMessageReject(id) {
  $('#c_order_id').val(id);
  $('#cancelorderform').attr('action', '{!! url('/orderreject') !!}'+'/'+id);
  $('#cancelorder').modal('show');
  /*
	swal({
  title: "Are you sure?",
  input: 'text',
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, Cancel it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderreject') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Canceled!", "Order Canceled successfully", "success");
							oTable.draw();
						}
					},
				});
			}
});
*/
}

function renderactionspaid(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datastatus=fdata[1];

    if(datastatus=="Paid"){
      var value = "<span>Paid</span>";
      return value;
    }else if(datastatus=="Refunded"){
      var value = "<span>Refunded</span>";
      return value;
    }else if(datastatus=="Canceled"){
      var value = "<span>Canceled</span>";
      return value;
    }else if(datastatus=="Refund"){
      var value = "<a href='javascript:void(0);' class='btn-sm btn btn-danger refundpayment' data-whatever='"+data+"'><span>Refund</span></a>&nbsp;&nbsp;";
      return value;
    }else{
      var value = "<a href='javascript:void(0);' class='btn-sm btn btn-success approvepayment' data-whatever='"+data+"'><span>Pay</span></a>&nbsp;&nbsp;";
			//var value ="<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessagePaid("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-success' data-original-title="+"Accept"+">Paid</a>";
      return value;
    }
}

// Paid Order
/*
function showConfirmMessagePaid(id) {
	swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-success",
  confirmButtonText: "Yes, Amount receive!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderpaid') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Accepted!", "Amount Received successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
*/
/*
function renderactions(data, type, row){
  //return data;
    if(data==""){
      return "";
    }else{
			var value ="<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessageAccept("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-success' data-original-title="+"Accept"+">Accept</a>&nbsp;&nbsp;"+
      "<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessageReject("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btnbtn-sm btn btn-danger' data-original-title="+"Reject"+">Reject</a>&nbsp;&nbsp;";
      return value;
    }
}
// Reject Order
function showConfirmMessageReject(id) {
	swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, Reject it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderreject') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Rejected!", "Order rejected successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
// Approve Order
function showConfirmMessageAccept(id) {
	swal({
  title: "Are you sure?",
  text: "",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-success",
  confirmButtonText: "Yes, Accept it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/orderaccept') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "GET", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Accepted!", "Order Accepted successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
*/

</script>

<?php
// Remaining User
}else{
?>

<div class="page-title">
  	<div class="col-md-9 col-sm-9 form-group pull-right">
    	<h3>{{ $action }}</h3>
		</div>
    <div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
      </div>
    </div>
</div>
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
    </div>
    <p>You have no access of this page. Please contact to Administrator.</p>
  </div>
</div>

<?php
}
?>
@endsection
