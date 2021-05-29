<!-- footer content -->
<footer>
  <div class="pull-right">
    Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">Tiffin</a>. All rights
    reserved.
  </div>
  <div class="clearfix"></div>
</footer>
<!-- /footer content -->

<!-- Change Password Modal -->
<div id="changePasswordModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
   <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change Password</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
        {!! Form::open(['method'=>'POST','role'=>'form','id'=>'changePasswordForm','novalidate'=>'']) !!}
            <div class="box-body modal-body">
            	<div id="message" class=""></div>
	                <div class="form-group">
	                  {!! Form::label('currentpassword','Current Password') !!}
	                  {!! Form::password('currentpassword',['class'=>'form-control required','placeholder'=>'Current Password','id'=>'currentpassword','required'=>'true']) !!}
	                <p class="text-red" id="passwordmatch"></p>
	                </div>
	                <div class="form-group">
	                  {!! Form::label('newpassword','New Password') !!}
	                  {!! Form::password('newpassword',['class'=>'form-control required','placeholder'=>'New Password','id'=>'newpassword','minlength'=>6,'maxlength'=>30,'required'=>'true']) !!}
	                </div>

	                <div class="form-group">
	                  {!! Form::label('retypepassword','Re-type Password') !!}
	                  {!! Form::password('retypepassword',['class'=>'form-control required','placeholder'=>'Re-type Password','id'=>'retypepassword','equalTo'=>'#newpassword','required'=>'true']) !!}
	                </div>
	              </div>
          <div class="modal-footer box-footer">
          	{!! Form::submit('Change',['class'=>'btn-sm btn btn-primary']) !!}
            <button type="button" class="btn-sm btn btn-default pull-right"  data-dismiss="modal">Close</button>
          </div>
       {!! Form::close() !!}
    </div>
  </div>
</div>
