<div class="container">
	<form class="form-horizontal" role="form" id="locationForm" action="" method="post">

		<div id="department_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Department</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="departmentbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="departmenttype">Choose Department</span> <span class="caret"></span>
					</button>
					<ul id="departmentmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
				</div>
			</div>
		</div>

		<div id="department_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="otherdepartment_input" class="form-group">
			<label class="col-xs-2 control-label text-right">New Department Name</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="otherdepartment" maxlength="30">
			</div>
		</div>

		<div id="otherdepartment_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="location_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Location</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="locationbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="locationtype">Choose Location</span> <span class="caret"></span>
					</button>
					<ul id="locationmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href='#'>On Campus</a></li>
						<li><a href='#'>Off Campus</a><li>
					</ul>
				</div>
			</div>
		</div>

		<div id="location_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="building_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Building</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="buildingbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="buildingtype">Choose Building</span> <span class="caret"></span>
					</button>
					<ul id="buildingmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
				</div>
			</div>
		</div>

		<div id="building_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="otherbuilding_input" class="form-group">
			<label class="col-xs-2 control-label text-right">New Building</label>
			<div class="col-xs-1">
				<input type="text" class="form-control" id="otherbuilding" maxlength="2">
			</div>
		</div>

		<div id="otherbuilding_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="room_num_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Room Number</label>
			<div class="col-xs-2">
				<input type="text" class="form-control" id="room_num" placeholder="Enter Room Number" maxlength="8">
			</div>
		</div>

		<div id="room_num_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

	</form>
</div>

<script>
// initially hides certain input boxes
$( '#locationForm' ).find( '.form-group' ).not( '#department_input, #location_input' ).hide();

// department dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "department" },
	success: function( result ){
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$( '#departmentmenu' ).append( "<li><a href='#'>" + results[i] + "</a></li>" );
			});

			$( '#departmentmenu' ).append( "<li><a href='#'>Other</a></li>" );

			$("#departmentmenu>li>a").on( 'click', function(){
				if ( $( this ).text() == "Other" )
				{
					$( '#otherdepartment_input' ).removeClass( 'has-error' ).show();
					$( '#otherdepartment_error' ).hide();
				}

				else
					$( '#otherdepartment_input, #otherdepartment_error' ).hide();

	  			$( '#departmenttype').html( $( this ).text() );
			});
		}
	}
});

// location dropdown
$("#locationmenu>li>a").on( 'click', function(){
	if ($( this ).text() == "On Campus")
		$('#building_input, #room_num_input').show();

	else
	{
		$( '#locationForm' ).find( '.form-group' ).not( '#department_input, #location_input, #location_error, #otherdepartment_input, #otherdepartment_error' ).removeClass( 'has-error' ).hide();
		$( '#buildingbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		$( '#buildingtype' ).html( "Choose Building" );
	}

	$( '#locationtype').html( $( this ).text() );
});

// building dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "building" },
	success: function( result ){
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#buildingmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
			});

			$('#buildingmenu').append( "<li><a href='#'>Other</a></li>" );

			$("#buildingmenu>li>a").on( 'click', function(){
				if ( $( this ).text() == "Other" )
					$( '#otherbuilding_input' ).show();

				else
					$( '#otherbuilding_input, #otherbuilding_error' ).removeClass( 'has-error' ).hide();

	  			$( '#buildingtype').html( $( this ).text() );
			});
		}
	}
});
</script>
