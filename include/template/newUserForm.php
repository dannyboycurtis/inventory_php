<div class="container">
	<form class="form-horizontal" role="form" id="userForm" action="" method="post">

		<div  id="selectusertype_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Type of User</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="usertypebutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="usertype">Choose Type</span> <span class="caret"></span>
					</button>
					<ul id="usertypemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Faculty/Staff</a></li>
						<li><a href="#">Lab Workstation</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div id="selectusertype_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id='selectlab_input' class="form-group">
			<label class="col-xs-2 control-label text-right">Lab Name</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id='selectlabbutton' type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="labtype">Choose Lab</span> <span class="caret"></span>
					</button>
					<ul id="labmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
				</div>
			</div>
		</div>

		<div id="selectlab_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="newlab_input" class="form-group">
			<label class="col-xs-2 control-label text-right">New Lab Name</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="newlabname" placeholder="Create New Lab Name" maxlength="30">
			</div>
		</div>

		<div id="newlab_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id='selectusers_input' class="form-group">
			<label class="col-xs-2 control-label text-right">Users</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="selectusersbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						Choose Users <span class="caret"></span>
					</button>
					<ul id="usermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
				</div>
				<ul id='userlist' class='list-unstyled' style='margin-top:10px'></ul>
			</div>
		</div>

		<div id='newuser_input' class="form-group">
			<label class="col-xs-2 control-label text-right">Add New User</label>
			<div class="col-xs-3">
				<div class='btn-group'>
					<input class='form-control' id='newuserfname' placeholder='First Name'>
					<input class='form-control' id='newuserlname' placeholder='Last Name' style='margin-top:10px'>
					<input class='form-control' id='newuseremail' placeholder='Email Address*' style='margin-top:10px'>
					<input class='form-control' id='newuserphone' placeholder='Campus Extension*' style='margin-top:10px'>
				</div>
			</div>
		</div>

		<div id="newuser_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div class="form-group" id='usersnotavailable'>
			&nbsp;&nbsp;&nbsp;&nbsp; Please Note: users are not available for this equipment type!
		</div>

	</form>
</div>

<script>
$( '#newuserphone' ).mask( '99999', {placeholder:" "} );

// initially hides certain input boxes
$( '#userForm' ).find( '.form-group' ).hide();

$( '#usersnotavailable' ).show();

// this brings up text boxes based on user type
$( '#usertypemenu>li>a' ).on( 'click', function(){
	if ( $( this ).text() == "Faculty/Staff")
	{
		$( '#selectusers_input' ).show();
		$( '#newuser_input' ).find( 'input' ).val( '' );
		$( '#selectlab_input, #newlab_input, #newlab_error, #selectlab_error' ).removeClass( 'has-error' ).hide();
	}

     else
	{
		$( '#userlist' ).empty();
		$('#selectusers_input, #selectusers_error, #newuser_input, #newuser_error').removeClass( 'has-error' ).hide();
		$( '#selectlab_input' ).show();
	}

	$( '#usertype' ).html( $( this ).text() ); 
   });

// users dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "users" },
	success: function( result ){
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );
			$( '#usermenu' ).html( "<li><a href='#'>Add New User</a></li><li class='divider'></li>" );
			$.each( results, function( i ){
				$( '#usermenu' ).append( "<li><span class=' hidden uid'>" + results[i].userid + "</span><a href='#'>" + results[i].fname + " " + results[i].lname + " </a></li>" );
			});

			$( "#usermenu>li>a" ).on( 'click', function(){
				if ( $( this ).text() == 'Add New User' )
					$( '#newuser_input, #newuser_error' ).show();

				else
				{
					$( '#newuser_input, #newuser_error' ).hide();
					$( '#newuserfname, #newuserlname, #newuseremail, #newuserphone' ).empty();
	
					var uid = $( this ).siblings( '.uid' ).text();

	  				$( '#userlist').append( "<li><span class='hidden user_id'>" + uid + "</span><i class='fa fa-minus-square' style='cursor:pointer'></i> " + $(this).text() + "</li>");

					$( '#userlist>li>i').on( 'click', function(){
						$( this ).parents( 'li' ).remove();
					});
				}
			});
		} 
	}	
});

// labs dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "labs" },
	success: function( result ){
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#labmenu').append( "<li><span class='hidden uid'>" + results[i].userid + "</span><a href='#'>" + results[i].fname + "</a></li>" );
			});
			$( '#labmenu' ).append( "<li class='divider'></li><li><a href='#'>Other</a></li>" );

			$("#labmenu>li>a").on( 'click', function(){
				if ( $( this ).text() == 'Other' )
					$( '#newlab_input, #newlab_error' ).show();

				else
				{
					$( '#newlab_input, #selectlab_error, #newlab_error' ).hide();
					$( '#labmenu>li' ).removeClass( 'selectedlab' );
					$( this ).parent( "li" ).addClass( 'selectedlab' );
				}

	  			$( '#labtype').html( $( this ).text() );
			});
		}
	}
});
</script>
