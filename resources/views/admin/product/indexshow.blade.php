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
<div class="page-title">
  	<div class="col-md-9 col-sm-9 form-group pull-right">
    	<h3>{{ $action }}</h3>
      <div class="custom-list">
        <div class="btn-group">
          <label class="">
            <span>{!! Html::linkRoute('productall','All',array(),['class'=>'btn btn-primary']) !!}</span>
          </label>
          <label class="">
            <span>{!! Html::linkRoute('product.index','Visible',array(),['class'=>'btn btn-primary active']) !!}</span>
          </label>
          <label class="">
            <span>{!! Html::linkRoute('producthide','Hidden',array(),['class'=>'btn btn-primary']) !!}</span>
          </label>
        </div>
      </div>
		</div>
    <div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
         {!! Html::linkRoute('product.create','Add New',[],['class'=>'btn-sm btn btn-primary margin']) !!}
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
                  <th>Image</th>
                  <th>Name</th>
									<th>Category Name</th>
                  <th>Price</th>
                  <th>Is Visible?</th>
                  <th>Is Featured?</th>
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
<script type="text/javascript">

var oTable="";
$(document).ready(function(){
 oTable = $('#datatable').DataTable({
		"processing": true,
		"serverSide": true,
    "ajax": "{{ route('getProduct') }}",
    "aaSorting": [[0, 'asc']],

    "columns": [
        {"bVisible": true, data: 'sr_no', name: 'sr_no'},
        {data: 'small_image', name: 'small_image',render: function (data, type, full, meta) {return "<img src=\"" + data + "\" height=\"50\"/>";},},
        {data: 'p_name', name: 'p_name'},
        {data: 'categories_id', name: 'categories_id'},
				{data: 'price', name: 'price'},
        {data: 'is_visibility', name: 'is_visibility','mRender':renderactionsvisibility,'sWidth':'5%'},
        {data: 'is_featured', name: 'is_featured','mRender':renderactionsisfeatured,'sWidth':'5%'},
        {data: 'id', name: 'id', 'bSortable': false,'mRender':renderaction,'sWidth':'10%'},
    ],
		"stateSave": true,
    "stateSaveCallback": function(settings,data) {
    localStorage.setItem('DataTables_'+window.location.pathname, JSON.stringify(data) )
    },
    "stateLoadCallback": function(settings) {
    return JSON.parse( localStorage.getItem( 'DataTables_'+window.location.pathname) )
    },
	});
  oTable.on('click','.visibilityclick', function(){
    $tr = $(this).closest('tr');
    if($($tr).hasClass('child')){
      $tr = $tr.prev('.parent');
    }
    var data = oTable.row($tr).data();
    var odata = data['is_visibility'];
    var fdata=odata.split(',');
    var dataid=fdata[0];
    var datavalue=fdata[1];
          $.ajax({
            url:'{!! url('/productvisibility') !!}'+'/'+dataid,
            type:'POST',
            data: { "product_id":dataid,"product_visible":datavalue,'_method': "POST", '_token' : "{{ Session::token() }}"},
            success:function(data){
              if(data==0){
                //location.reload();
                swal("Done!", "Information changed successfully", "success");
  							oTable.draw();
              }
            },
          });
  });

  oTable.on('click','.isfeaturedclick', function(){
    $tr = $(this).closest('tr');
    if($($tr).hasClass('child')){
      $tr = $tr.prev('.parent');
    }
    var data = oTable.row($tr).data();
    var odata = data['is_featured'];
    var fdata=odata.split(',');
    var dataid=fdata[0];
    var datavalue=fdata[1];
    $.ajax({
      url:'{!! url('/productisfeatured') !!}'+'/'+dataid,
      type:'POST',
      data: { "product_id":dataid,"product_isfeatured":datavalue,'_method': "POST", '_token' : "{{ Session::token() }}"},
      success:function(data){
        if(data==0){
          //location.reload();
          swal("Done!", "Information changed successfully", "success");
          oTable.draw();
        }
      },
    });
    });

	oTable.draw();
});
function renderactionsvisibility(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datavalue=fdata[1];
  if(datavalue=="yes"){
    var fd = "<div attr-value=\"" + datavalue + "\" class=\"btn visibilityclick visibility"+dataid+" btn-toggle active\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
    return fd;
  }else{
    var fd = "<div attr-value=\"" + datavalue + "\" type=\"submit\" class=\"btn visibilityclick visibility"+dataid+" btn-toggle\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
     return fd;
  }
}
function renderactionsisfeatured(data, type, row){
  var fdata=data.split(',');
  var dataid=fdata[0];
  var datavalue=fdata[1];
  var datais_visible=fdata[2];
  if(datavalue=="yes"){
    if(datais_visible=="yes"){
      var fd = "<div attr-value=\"" + datavalue + "\" class=\"btn isfeaturedclick isfeatured"+dataid+" btn-toggle active\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
      return fd;
    }else{
      var fd = "<div attr-value=\"" + datavalue + "\" class=\"btn btn-toggle active\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
      return fd;
    }
  }else{
    if(datais_visible=="yes"){
      var fd = "<div attr-value=\"" + datavalue + "\" type=\"submit\" class=\"btn isfeaturedclick isfeatured"+dataid+" btn-toggle\" data-toggle=\"button\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
       return fd;
    }else{
      var fd = "<div attr-value=\"" + datavalue + "\" type=\"submit\" class=\"btn btn-toggle\" aria-pressed=\"false\" autocomplete=\"off\"><div class=\"handle\"></div></div>";
       return fd;
    }
  }
}
function renderaction(data, type, row){
		    url='{!! url('/product') !!}'+'/'+data+'/edit';
        deleteurl='{!! url('/product') !!}'+'/'+data;
				var value = "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='Edit' class='btn-sm btn btn-warning'>Edit</a>&nbsp;&nbsp;"
				+"<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessage("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btn btn-danger' data-original-title="+"Delete"+">Delete</a>";
        return value;
}
// Delete Data
function showConfirmMessage(id) {
	swal({
  title: "Are you sure?",
  text: "Your will not be able to recover this data!",
  type: "warning",
  showCancelButton: true,
  confirmButtonClass: "btn-sm btn btn-danger",
  confirmButtonText: "Yes, delete it!",
  closeOnConfirm: true
}, function (isConfirm) {
			if(isConfirm){
				$.ajax({
					url:'{!! url('/product') !!}'+'/'+id,
					type:'POST',
					data: { '_method': "DELETE", '_token' : "{{ Session::token() }}"},
					success:function(data){
						//data = $.parseJSON(data);
						if(data==0){
							swal("Deleted!", "Information deleted successfully", "success");
							oTable.draw();
						}
					},
				});
			}
		});
}
</script>
@endsection
