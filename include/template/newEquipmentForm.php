<div class="container">
	<form class="form-horizontal" role="form" id="equipmentForm" action="">

		<div id="tag_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Tag Number</label>
			<div class="col-xs-1">
				<input type="text" class="form-control" id="tag_num" maxlength="5">
			</div>
		</div>

		<div id="tag_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="serial_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Serial Number</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="serial" maxlength="30">
			</div>
		</div>

		<div id="serial_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="makemodel_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Make & Model</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="makebutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="maketype">Choose Make</span> <span class="caret"></span>
					</button>
					<ul id="makemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Other</a></li>
						<li class="divider"></li>
					</ul>
				</div>

				<div class="btn-group">
					<button id="modelbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="modeltype">Choose Model</span> <span class="caret"></span>
					</button>
					<ul id="modelmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Other </a></li>
						<li class="divider"></li>
					</ul>
				</div>
				<input id='newMake' class='form-control' placeholder='Create New Make' style='margin-top:10px'>
				<input id='newModel' class='form-control' placeholder='Create New Model' style='margin-top:10px'>
			</div>
		</div>

		<div id="makemodel_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

	    <div id="eqtype_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Type of Equipment</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="eqtypebutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="eqtype">Choose Type</span> <span class="caret"></span>
					</button>
					<ul id="eqtypemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Computer or Tablet</a></li>
						<li><a href="#">Network Printer</a></li>
						<li><a href="#">Other Equipment</a></li>
					</ul>
				</div>
			</div>
		</div>

		<div id="eqtype_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="eqtype_submenu">
			<div id="description_input" class="form-group">
				<label class="col-xs-2 control-label text-right">Description</label>
				<div class="col-xs-3">
			        <input type="text" class="form-control" id="description" maxlength="100">
				</div>
			</div>

			<div id="description_error" class="input_error form-group" style="margin-bottom:20px;color:red">
				<div class="col-xs-offset-2 col-xs-4"></div>
			</div>

			<div id="hostname_input" class="form-group">
				<label class="col-xs-2 control-label text-right">Hostname</label>
				<div class="col-xs-3">
					<input type="text" class="form-control" id="hostname" maxlength="15">
				</div>
			</div>

			<div id="hostname_error" class="input_error form-group" style="margin-bottom:20px;color:red">
				<div class="col-xs-offset-2 col-xs-4"></div>
			</div>

			<div id="os_input" class="form-group">
				<label class="col-xs-2 control-label text-right">Operating System</label>
				<div class="col-xs-3">
					<div class="btn-group">
						<button id="osbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
							<span id="ostype">Choose OS</span> <span class="caret"></span>
						</button>
						<ul id="osmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
							<li><a href='#'>New Operating System</a></li>
							<li class="divider"></li>
						</ul>
					</div>
				</div>
			</div>

			<div id="otheros_input" class="form-group">
				<label class="col-xs-2 control-label text-right">New OS Name</label>
				<div class="col-xs-3">
					<input type="text" class="form-control" id="otheros" maxlength="45">
				</div>
			</div>

			<div id="os_error" class="input_error form-group" style="margin-bottom:20px;color:red">
				<div class="col-xs-offset-2 col-xs-4"></div>
			</div>

			<div id="printer_input" class="form-group">
				<label class="col-xs-2 control-label text-right">Printer*</label>
				<div class="col-xs-3">
					<input type="text" class="form-control" id="eq_printer" maxlength="45">
				</div>
			</div>

			<div id="printer_error" class="input_error form-group" style="margin-bottom:20px;color:red">
				<div class="col-xs-offset-2 col-xs-4"></div>
			</div>

		</div>

	</form>
</div>

<script>
$( '#tag_num' ).mask( '99999', {placeholder: " "} );

// initially hides certain input boxes
$( '#equipmentForm' ).find( '.form-group' ).not( '#tag_input, #serial_input, #makemodel_input, #eqtype_input' ).hide();
$( '#newMake, #newModel' ).hide();

// this displays inputs based on equipment type
$( '#eqtypemenu>li>a' ).on( 'click', function(){
	if ( $( this ).text() == "Other Equipment" )
	{
		// hide all type-specific inputs except description, remove error styles
		$( '#eqtype_submenu' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#osbutton, #usertypebutton, #selectlabbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		$( '#description_input' ).show();
		$( '#usertab>a' ).removeAttr( 'style' );

		// Disable software selection, enables user selection
		$( '#softwareForm, #userForm' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#softwarenotavailable, #selectusertype_input' ).show();
     } 

	else if ( $( this ).text() == "Computer or Tablet" )
	{
		// hide all type-specific inputs except os, hostname and printer, remove error styles
		$( '#eqtype_submenu' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#osbutton, #usertypebutton, #selectlabbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		$( '#hostname_input, #os_input, #printer_input' ).show();
		$( '#usertab>a' ).removeAttr( 'style' );

		// enable software and user selection
		$( '#softwareForm, #userForm' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#selectsoftware_input, #selectusertype_input' ).show();
	}

	else if ( $( this ).text() == "Network Printer" )
	{
		// hide all type-specific inputs except hostname, remove error styles
		$( '#eqtype_submenu' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#osbutton, #usertypebutton, #selectlabbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		$( '#hostname_input' ).show();
		$( '#usertab>a' ).removeAttr( 'style' );

		// disable software and user selection
		$( '#softwareForm, #userForm' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#softwarenotavailable, #usersnotavailable' ).show();
	}

	else
	{
		// hide all type-specific inputs
		$( '#eqtype_submenu' ).find( '.form-group' ).removeClass( 'has-error' ).hide();

		// disable software and user selection
		$( '#softwareForm, #userForm' ).find( '.form-group' ).removeClass( 'has-error' ).hide();
		$( '#softwarenotavailable, #usersnotavailable' ).show();
	}
	
	$( '#eqtype' ).html( $( this ).text() ); 
});

// make and model dropdowns
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "make" },
	success: function( result ) {
		results = $.parseJSON( result );
		$.each( results, function( i ){
			$('#makemenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
		});

		$("#makemenu>li>a").on( 'click', function(){
	  		$( '#maketype').html( $( this ).text() );

			if ( $( '#maketype' ).html() == 'Other' )
			{
				$( '#modeltype' ).html( "Other" );
				$( '#newMake, #newModel' ).show();
			}

			else
			{
				$( '#newMake, #newModel' ).hide();
				$( '#modeltype' ).html( "Choose Model" );
				$( '#modelmenu' ).html( "<li><a href='#'>Other</a></li><li class='divider'></li>" );

				$.ajax({
					type: "POST",
					url: "include/populate_menus.php",
					data: { query : "model_from_make", make : $('#maketype').html() },
					success: function( result ) {
						results = $.parseJSON( result );

						$.each( results, function( i ){
							$('#modelmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
						});

						$("#modelmenu>li>a").on( 'click', function(){
							if ( $( this ).text() == 'Other' )
								$( '#newModel' ).show();						
								
							else
								$( '#newModel' ).hide();	

	  						$( '#modeltype').html( $( this ).text() );
						});
					}
				});
			}
		});
	}
});

// OS dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "os" },
	success: function( result ){
		results = $.parseJSON( result );
		$.each( results, function( i ){
			$('#osmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
		});

		$("#osmenu>li>a").on( 'click', function(){
			if ( $( this ).text() == "New Operating System" )
				$( '#otheros_input' ).show();

			else
				$( '#otheros_input' ).hide();

  			$( '#ostype').html( $( this ).text() );
		});
	}
});
</script>
