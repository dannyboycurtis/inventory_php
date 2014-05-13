<div class="container">
  <form class="form-horizontal" role="form" id="newLocationForm" action="" method="post">
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

    <div class="form-group">
      <label class="col-xs-4 col-md-2 control-label text-right">Location</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="location" placeholder="Select Location">
          <option disabled selected>Select Location...
          </option>
          <option value="oncampus">On campus
          </option>
          <option value="offcampus">Off campus
          </option>
        </select>
      </div>
    </div>

    <div class="form-group" id="building_input">
      <label class="col-xs-4 col-md-2 control-label text-right">Building</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <select class="form-control" id="building" placeholder="Select Building">
          <option disabled selected>Select Building...
          </option>
          <option>UH
          </option>
          <option>PA
          </option>
          <option>VA
          </option>
          <option>CE
          </option>
          <option>FO
          </option>
        </select>
      </div>
    </div>

    <div class="form-group" id="room_num_input">
      <label class="col-xs-4 col-md-2 control-label text-right">Room Number</label>
      <div class="col-xs-5 col-sm-4 col-md-3">
        <input type="text" class="form-control" id="room_num">
      </div>
    </div>

  </form>
</div>

<script>

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
	  			$( '#departmenttype').html( $( this ).text() );
			});
		}
	});
</script>
