<div class="container">
  <form class="form-horizontal" role="form" id="locationForm" action="" method="post">
    <h4>Location Information: <small>(Items with * are optional)</small></h4>

    <div class="form-group">
      <label class="col-xs-2 control-label text-right">Department</label>
      <div class="col-xs-3">
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    			<span id="departmenttype">Choose Department </span><span class="caret"></span>
			</button>
			<ul id="departmentmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
			</ul>
		</div>
      </div>
    </div>

    <div class="form-group" id="otherdepartment">
      <label class="col-xs-2 control-label text-right">New Department Name</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="department_input" maxlength="30">
      </div>
    </div>


    <div class="form-group">
      <label class="col-xs-2 control-label text-right">Location</label>
      <div class="col-xs-3">
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    			<span id="locationtype">Choose Location </span><span class="caret"></span>
			</button>
			<ul id="locationmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
				<li><a href='#'>On Campus </a></li>
				<li><a href='#'>Off Campus </a><li>

			</ul>
		</div>
      </div>
    </div>

    <div class="form-group" id="building_input">
      <label class="col-xs-2 control-label text-right">Building & Room #</label>
      <div class="col-xs-3">
		<div class="btn-group">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    			<span id="buildingtype">Choose Building </span><span class="caret"></span>
			</button>
			<ul id="buildingmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
			</ul>
		</div>
	 </div>
   </div>

    <div class="form-group" id="otherbuilding">
      <label class="col-xs-2 control-label text-right">New Building</label>
      <div class="col-xs-1">
        <input type="text" class="form-control" id="building_input" maxlength="2">
      </div>
    </div>

    <div class="form-group" id="room_num_input">
      <label class="col-xs-2 control-label text-right">Room Number</label>
      <div class="col-xs-2">
        <input type="text" class="form-control" id="room_num" placeholder="Enter Room Number">
      </div>
    </div>


  </form>
</div>

<script>
// initially hide otherdepartment input
$( '#otherdepartment, #room_num_input, #otherbuilding' ).hide();


// department dropdown
	$.ajax({
		type: "POST",
		url: "../populate_menus.php",
		data: { query : "department" },
		success: function( result ){
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#departmentmenu').append( "<li><a href='#'>" + results[i] + " </a></li>" );
			});

			$('#departmentmenu').append( "<li><a href='#'>Other </a></li>" );

			$("#departmentmenu>li>a").on( 'click', function(){
				if ( $( this ).text() == "Other " )
					$( '#otherdepartment' ).show();

				else
					$( '#otherdepartment' ).hide();

	  			$( '#departmenttype').html( $( this ).text() );
			});
		}
	});

// location dropdown
$("#locationmenu>li>a").on( 'click', function(){
     if ($( this ).text() == "On Campus ")
        $('#building_input, #room_num_input').show();

     else
        $('#building_input, #room_num_input, #otherbuilding').hide();

	$( '#locationtype').html( $( this ).text() );
});

// building dropdown
$("#buildingmenu>li>a").on( 'click', function(){
	$( '#buildingtype').html( $( this ).text() );
});

	$.ajax({
		type: "POST",
		url: "../populate_menus.php",
		data: { query : "building" },
		success: function( result ){
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#buildingmenu').append( "<li><a href='#'>" + results[i] + " </a></li>" );
			});

			$('#buildingmenu').append( "<li><a href='#'>Other </a></li>" );

			$("#buildingmenu>li>a").on( 'click', function(){
				if ( $( this ).text() == "Other " )
					$( '#otherbuilding' ).show();

				else
					$( '#otherbuilding' ).hide();

	  			$( '#buildingtype').html( $( this ).text() );
			});
		}
	});




</script>
