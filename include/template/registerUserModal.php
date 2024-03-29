<!-- Register User Modal -->
<div class="modal" id="registerUserModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Register New Inventory User</h4>
			</div>

			<div class="modal-body">
				<div class="container">
					<form class="form-horizontal" role="form" id="registerUserForm" action="" method="post">

						<div id="regUsername_input" class="form-group">
							<label class="col-xs-2 control-label text-right">New Username</label>
							<div class="col-xs-3">
								<div class='btn-group'>
									<input type='text' class='form-control' id='regUsername'>
								</div>
							</div>
						</div>

						<div id="regUsername_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

					    <div id="regRole_input" class="form-group">
						<label class="col-xs-2 control-label text-right">User Role</label>
							<div class="col-xs-3">
								<div class="btn-group">
									<button id="regRolebutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span id="regRoletype">Choose Role</span> <span class="caret"></span>
									</button>
									<ul id="regRolemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
										<li><a href="#">Level 1</a></li>
										<li><a href="#">Level 2</a></li>
										<li><a href="#">Level 3</a></li>
									</ul>
								</div>
							</div>
						</div>

						<div id="regPassword_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Password</label>
							<div class="col-xs-3">
								<div class='btn-group'>
									<input type='password' class='form-control' id='regNewPassword'>
								</div>
							</div>
						</div>

						<div id="regPassword_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

						<div id="regConfirm_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Confirm Password</label>
							<div class="col-xs-3">
								<div class='btn-group'>
									<input type='password' class='form-control' id='regConfirmPassword'>
								</div>
							</div>
						</div>

						<div id="regConfirm_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

						<div class="form-group">
							<div class="col-xs-offset-2 col-xs-4">
								User Roles:<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level 1: May view all non-software records
											  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level 2: May view/add/edit all records
											  <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Level 3: May view/add/edit/delete all records
							</div>
						</div>


					</form>
				</div>
			</div>

			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
				<button id="submitregistration" type="button" class="btn btn-primary">Submit</button>
			</div>

		</div>
	</div>
</div>

<script>
$( '.input_error' ).hide();

$( '#registerUserModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#registerUserForm' )[0].reset();

	// reset all hidden forms
	$( '.input_error' ).hide();

	// reset user role button
	$( '#regRoletype' ).html( "Choose Role" );
	$( '#regRolebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

	// remove all error styles
	$( this ).find( '.has-error' ).removeClass( 'has-error' );
});


$( "#regRolemenu>li>a").on( 'click', function(){
	$( '#regRoletype' ).html( $( this ).text() );
});


$( '#submitregistration' ).on( 'click', function(){

// check for valid inputs

	// username
	var usernameRegex = /^\w+$/; 

	if ( $( '#regUsername' ).val() == "" )
	{
		$( '#regUsername_error' ).show().children().html( "Username required!" );
		$( '#regUsername_input' ).addClass( 'has-error' );
	}

	else if ( !$( '#regUsername' ).val().match( usernameRegex ) )
	{
		$( '#regUsername_error' ).show().children().html( "Username contains invalid characters!" );
		$( '#regUsername_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#regUsername_error' ).hide();
		$( '#regUsername_input' ).removeClass( 'has-error' );

		// set variable
		var user = $( '#regUsername' ).val();
	}

	if ( $( '#regRoletype' ).text() == "Choose Role" )
	{
		$( '#regRole_error' ).show().children().html( "User role required!" );
		$( '#regRole_input' ).addClass( 'has-error' );
		$( '#regRolebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else
	{
		$( '#regRole_error' ).hide();
		$( '#regRole_input' ).removeClass( 'has-error' );
		$( '#regRolebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// set variable
		var role = $( '#regRoletype' ).text();

		if ( role == "Level 1" )
			role = 1;

		else if ( role == "Level 2" )
			role = 2;

		else if ( role == "Level 3" )
			role = 3;
	}

	// password
    var passwordRegex = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}/;
	
	if ( $( '#regNewPassword' ).val().length < 8 )
	{
		$( '#regPassword_error' ).show().children().html( "Password must be at least 8 characters!" );
		$( '#regPassword_input' ).addClass( 'has-error' );
	}

	else if ( !$( '#regNewPassword' ).val().match( passwordRegex ) )
	{
		$( '#regPassword_error' ).show().children().html( "Password must contain upper and lower-case letters" );
		$( '#regPassword_input' ).addClass( 'has-error' );
	}

	else if ( $( '#regNewPassword' ).val() == "" || $( '#regConfirmPassword' ).val() == "" )
	{
		$( '#regPassword_error' ).hide();
		$( '#regPassword_input' ).removeClass( 'has-error' );

		$( '#regConfirm_error' ).show().children().html( "Both fields is required!" );
		$( '#regConfirm_input' ).addClass( 'has-error' );
	}

	else if ( $( '#regNewPassword' ).val() != $( '#regConfirmPassword' ).val() )
	{
		$( '#regPassword_error' ).hide();
		$( '#regPassword_input' ).removeClass( 'has-error' );

		$( '#regConfirm_error' ).show().children().html( "Passwords do not match!" );
		$( '#regPassword_input, #regConfirm_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#regPassword_error, #regConfirm_error' ).hide();
		$( '#regPassword_input, #regConfirm_input' ).removeClass( 'has-error' );

		// prepare password for submission
		var p = hex_sha512( $( '#regNewPassword' ).val() );
	}

	if ( !$( '#registerUserModal' ).find( '.form-group' ).hasClass( 'has-error' ) )
	{
		$.ajax({
			type: "POST",
			url: "include/register_user.php",
			data: { p: p, user: user, role: role },
			success: function( result ){
				if ( result.charAt( 0 ) == "<" )
					window.location.reload();

				else
				{
					if ( result == 1 )
						alert( "User successfully registered." );

					else
						alert( "Error: " + result );

					$( '#registerUserModal' ).modal( 'hide' );

					list_inventoryusers();
				}
			}
		});
	}
});
</script>
