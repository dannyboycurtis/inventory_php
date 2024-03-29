<!-- Edit User Modal -->
<div class="modal" id="editUserModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit User Record</h4> <small>(Items with * are optional)</small>
			</div>

			<div class="modal-body">
				<div class="container">
				<form class="form-horizontal" role="form" id="editUserForm" action="" method="post">

				<input id="user_id" class="hidden" type="text">

				<div id='fname_input' class="form-group">
					<label class="col-xs-2 control-label text-right">First Name</label>
					<div class="col-xs-3">
						<div class='btn-group'>
							<input class='form-control' id='f_name' placeholder='First Name'>
						</div>
					</div>
				</div>

				<div id="fname_error" class="input_error form-group" style="margin-bottom:20px;color:red">
					<div class="col-xs-offset-2 col-xs-4"></div>
				</div>

				<div id='lname_input' class="form-group">
					<label class="col-xs-2 control-label text-right">Last Name</label>
					<div class="col-xs-3">
						<div class='btn-group'>
							<input class='form-control' id='l_name' placeholder='Last Name'>
						</div>
					</div>
				</div>

				<div id="lname_error" class="input_error form-group" style="margin-bottom:20px;color:red">
					<div class="col-xs-offset-2 col-xs-4"></div>
				</div>

				<div id='email_input' class="form-group">
					<label class="col-xs-2 control-label text-right">Email Address*</label>
					<div class="col-xs-3">
						<div class='btn-group'>
							<input class='form-control' id='email' placeholder='Email Address'>
						</div>
					</div>
				</div>

				<div id="email_error" class="input_error form-group" style="margin-bottom:20px;color:red">
					<div class="col-xs-offset-2 col-xs-4"></div>
				</div>

				<div id='phone_input' class="form-group">
					<label class="col-xs-2 control-label text-right">Campus Extension*</label>
					<div class="col-xs-3">
						<div class='btn-group'>
							<input class='form-control' id='phone' placeholder='Campus Ext.'>
						</div>
					</div>
				</div>

				<div id="phone_error" class="input_error form-group" style="margin-bottom:20px;color:red">
					<div class="col-xs-offset-2 col-xs-4"></div>
				</div>

				<div id="user_error" class="input_error form-group" style="margin-bottom:20px;color:red">
					<div class="col-xs-offset-2 col-xs-4"></div>
				</div>

			</form>
			</div>
			</div>

			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
				<button id="submituser" type="button" class="btn btn-primary">Submit</button>
			</div>

		</div>
	</div>
</div>

<script>
$( '.input_error' ).hide();

$( '#editUserModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#editUserForm' )[0].reset();

	// reset all hidden forms
	$( this ).find( '.form-group' ).not( '#fname_input, #lname_input, #email_input, #phone_input' ).hide();

	// remove all error styles
	$( this ).find( '.has-error' ).removeClass( 'has-error' );
	$( this ).find( '.btn-danger' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
});


$( '#submituser' ).on( 'click', function() {

// prepare inputs

	// first name
	if ( $( '#f_name' ).val() == "" )
	{
		$( '#fname_error' ).show().children().html( "First name required!" );
		$( '#fname_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#fname_error' ).hide();
		$( '#fname_input' ).removeClass( 'has-error' );

		// set variable
		var f_name = $( '#f_name' ).val();
	}

	// last name
	if ( $( '#l_name' ).val() == "" )
	{
		$( '#lname_error' ).show().children().html( "Last name required!" );
		$( '#lname_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#lname_error' ).hide();
		$( '#lname_input' ).removeClass( 'has-error' );

		// set variable
		var l_name = $( '#l_name' ).val();
	}

	// check if any errors exist
	if ( !$( '#editUserModal' ).find( '.form-group' ).hasClass( 'has-error' ) )
	{
		// set all other variables
		var user_id = $( '#user_id' ).val();

		if ( $( '#email' ).val() != "" )
		var email = $( '#email' ).val();

		if ( $( '#phone' ).val() != "" )
		var phone = $( '#phone' ).val();

		// collect input-data into json
		var input = { "user_id" : user_id,
						"f_name" : f_name,
						"l_name" : l_name,
						"email" : email,
						"phone" : phone };

		console.log( input );

		user_input = JSON.stringify( input );

		$.ajax({
			type: "POST",
			url: "include/edit_user.php",
			data: { data : user_input },
			success: function( result ){
				if ( result.charAt( 0 ) == "<" )
					window.location.reload();

				else
				{
					// update table
					var results = $.parseJSON( result );
	
					alert( results.message );

					returnToQuery( results.query, results.querytype );

					$( '#editUserModal' ).modal( 'hide' );
				}
			},
			error: function(){
				alert( "There was a problem in the database!" );
			}
		});
	}
});

</script>
