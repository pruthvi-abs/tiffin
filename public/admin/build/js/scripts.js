// Global variable Domain Name.

var url='https://www.neoinventions.com/dailytiffin/';
//Fade out bootstrap alert.

$(".alert").not(".noalert").fadeTo(2000, 500).slideUp(800, function(){
    $(".alert").slideUp(500);
});

// Open popup for change password.

$("#changepassword").click(function(){

	$("#changePasswordModal").modal('show');
	$("#message").removeClass().html('');
	$("#passwordmatch").html('');
	$("#changePasswordForm")[0].reset();;

});


// Submit change password form.

$("#changePasswordForm").submit(function(){

	if($(this).valid())
	{
		$.ajax({
					type:'POST',
					url:url+'changePassword',
					data:$(this).serialize(),
					success:function(data)
					{
						if(data.error==1)
						{
							$("#message").removeClass().addClass('alert alert-success').html(data.message);
							$("#passwordmatch").html('');
							$("#changePasswordForm")[0].reset();
						}
						else
						{
							$("#message").removeClass().addClass('alert alert-danger').html(data.message);
							$("#passwordmatch").html(data.passwordmatch);
						}
					}
		      });
	}
	return false;
});
