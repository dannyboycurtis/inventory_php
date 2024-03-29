<div class="container">
	<form class="form-horizontal" role="form" id="addSoftwareForm" action="">

		<input id= "software_id" type="hidden"> 

		<div id="softwarename_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Software Name</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="software_name" maxlength="45">
			</div>
		</div>

		<div id="softwarename_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="licensenum_input" class="form-group">
			<label class="col-xs-2 control-label text-right">License Number</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="license_num" maxlength="45">
			</div>
		</div>

		<div id="licensenum_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="licensetype_input" class="form-group">
			<label class="col-xs-2 control-label text-right">License Type</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="licensetypebutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="licensetype">Choose Type</span> <span class="caret"></span>
					</button>
					<ul id="licensetypemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Single User</a></li>
						<li><a href="#">Single Computer</a></li>
						<li><a href="#">Volume License</a><li>
						<li><a href="#">Floating License</a><li>
					</ul>
				</div>
			</div>
		</div>

		<div id="licensetype_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="numberoflicenses_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Number of Licenses</label>
			<div class="col-xs-1">
				<input type="text" class="form-control" id="number_of_licenses" maxlength="4">
			</div>
		</div>

		<div id="numberoflicenses_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

	</form>
</div>

<script>
$("#licensetypemenu>li>a").on( 'click', function(){
	if ( $( this ).text() == "Single User" || $( this ).text() == "Single Computer" )
	{
		$( '#number_of_licenses' ).attr( 'disabled', true ).val( '1' );
	}

	else
		$( '#number_of_licenses' ).removeAttr( 'disabled' ).val( "" );


	$( '#licensetype').html( $( this ).text() );
});

</script>

