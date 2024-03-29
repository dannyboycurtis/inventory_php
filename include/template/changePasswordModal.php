<!-- Change Password Modal -->
<div class="modal" id="changePasswordModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>

			<div class="modal-body">
				<div class="container">
					<form class="form-horizontal" role="form" id="changePasswordForm" action="" method="post">

						<input id='changePasswordUser' class='hidden' type='text'> 

						<div id="password_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Enter New Password</label>
							<div class="col-xs-3">
								<div class='btn-group'>
									<input type='password' class='form-control' id='newPassword'>
								</div>
							</div>
						</div>

						<div id="password_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

						<div id="confirm_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Confirm Password</label>
							<div class="col-xs-3">
								<div class='btn-group'>
									<input type='password' class='form-control' id='confirmPassword'>
								</div>
							</div>
						</div>

						<div id="confirm_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

						<div class="form-group">
							<div class="col-xs-offset-2 col-xs-4">
								Password must:<br>&nbsp;&nbsp;&nbsp;&nbsp;be at least 8 characters
											  <br>&nbsp;&nbsp;&nbsp;&nbsp;have at least 1 number
											  <br>&nbsp;&nbsp;&nbsp;&nbsp;contain upper & lower-case letters
							</div>
						</div>

					</form>
				</div>
			</div>

			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
				<button id="submitpassword" type="button" class="btn btn-primary">Submit</button>
			</div>

		</div>
	</div>
</div>

<script>
$( '.input_error' ).hide();

$( '#changePasswordModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#changePasswordForm' )[0].reset();

	// reset all hidden forms
	$( '.input_error' ).hide();

	// remove all error styles
	$( this ).find( '.has-error' ).removeClass( 'has-error' );
});

$( '#submitpassword' ).on( 'click', function(){
    var passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
	
	if ( $( '#newPassword' ).val().length < 8 )
	{
		$( '#password_error' ).show().children().html( "Password must be at least 8 characters!" );
		$( '#password_input' ).addClass( 'has-error' );
	}

	else if ( !$( '#newPassword' ).val().match( passwordRegex ) )
	{
		$( '#password_error' ).show().children().html( "Password must contain upper and lower-case letters" );
		$( '#password_input' ).addClass( 'has-error' );
	}

	else if ( $( '#newPassword' ).val() == "" || $( '#confirmPassword' ).val() == "" )
	{
		$( '#password_error' ).hide();
		$( '#password_input' ).removeClass( 'has-error' );

		$( '#confirm_error' ).show().children().html( "Both fields is required!" );
		$( '#confirm_input' ).addClass( 'has-error' );
	}

	else if ( $( '#newPassword' ).val() != $( '#confirmPassword' ).val() )
	{
		$( '#password_error' ).hide();
		$( '#password_input' ).removeClass( 'has-error' );

		$( '#confirm_error' ).show().children().html( "Passwords do not match!" );
		$( '#password_input, #confirm_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#password_error, #confirm_error' ).hide();
		$( '#password_input, #confirm_input' ).removeClass( 'has-error' );

		// prepare password for submission
		var p = hex_sha512( $( '#newPassword' ).val() );

		if ( $( '#changePasswordUser' ).val() != "" )
			var user = $( '#changePasswordUser' ).val();

		$.ajax({
			type: "POST",
			url: "include/change_password.php",
			data: { p: p, user: user },
			success: function( result ){
				if ( result.charAt( 0 ) == "<" )
					window.location.reload();

				else
				{
					if ( result == "1" )
						alert( "Password successfully changed." );

					else
						alert( "There was a problem changing the password!" );

					$( '#changePasswordModal' ).modal( 'hide' );
				}
			}
		});
	}
});
</script>
