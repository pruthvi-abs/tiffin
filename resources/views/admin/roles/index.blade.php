@extends('admin.layout.dashboard')
@section('content')


<div class="page-title">
  	<div class="col-md-9 col-sm-9 form-group pull-right">
    	<h3>{{ $action }}</h3>
		</div>
    <div class="col-md-3 col-sm-3 form-group ">
			<div class="pull-right">
        <?php
        /*
			     {!! Html::linkRoute('roles.create','Add New',[],['class'=>'btn-sm btn btn-primary margin']) !!}
        */
        ?>
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
                  <th>Role Name</th>
									<th>Created</th>
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
    "ajax": "{{ route('getRoles') }}",
    "aaSorting": [[0, 'asc']],
    "columns": [
        {"bVisible": true, data: 'sr_no', name: 'sr_no'},
        {data: 'name', name: 'name'},
				{data: 'created_at', name: 'created_at'},
        {data: 'id', name: 'id', 'bSortable': false,'mRender':renderaction,'sWidth':'20%'},
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
});
function renderaction(data, type, row){
		    url='{!! url('/roles') !!}'+'/'+data+'/edit';
        deleteurl='{!! url('/roles') !!}'+'/'+data;
				var value = "<a href='"+url+"' title='' data-placement='top' data-toggle='tooltip' data-original-title='Edit' class='btn-sm btn btn-warning'>Edit</a>&nbsp;&nbsp;";
				//+"<a data-type='confirm'  href='javascript:void(0);' onclick='showConfirmMessage("+'"'+data+'"'+");' data-toggle="+"tooltip"+" data-placement="+"top"+" title='' class='btn-sm btn btn-danger' data-original-title="+"Delete"+">Delete</a>";
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
					url:'{!! url('/roles') !!}'+'/'+id,
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
