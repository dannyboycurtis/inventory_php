<div class="panel-group">

	<!-- search_panel -->
	<div class="panel panel-default" style="overflow:visible">
		<div id="search_panel" class="panel-collapse collapse in">
			<div class="panel-body">

				<div class="panel panel-default" style="overflow:visible">
					<div class="panel-heading"><h4 class="panel-title">Search Equipment</h4></div>
					<div class="panel-body">
						<div class="row">
	  						<div class="col-xs-5">
								<div class="input-group">
	      							<div class="input-group-btn">
	        							<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
											<span id="eqsearchtype">Property Tag</span> <span class="caret"></span>
										</button>
	        							<ul id="eqsearchmenu" class="dropdown-menu">
	        	  							<li><a href="#">Property Tag</a></li>
	        	  							<li><a href="#">Serial Number</a></li>
	        	  							<li><a href="#">Hostname</a></li>
	        	  							<li><a href="#">IP Address</a></li>
	        	  							<li><a href="#">MAC Address</a></li>
											<li><a href="#">Purchase Date</a></li>
	        							</ul>
									</div><!-- btn-group -->
	      							<input id="eqsearchinput" type="text" class="form-control" placeholder="Search">
									<span class="input-group-btn">
	        							<button id="eqexecutesearch" class="btn btn-primary" type="button">
											<i class="fa fa-search"></i>
										</button>
	      							</span>
								</div><!-- input-group -->
								<span class="help-block">Select type of search and enter keywords</span>

							</div><!-- col-xs-5 -->
							<div class="col-xs-7">
								<p class="form-control-static"> Note: for purchase dates, please use the following format: YYYY-MM-DD</p>
							</div>

					
						</div><!-- row -->
						<h4>Additional Search Options:</h4>
						<div class="row">
							<div class="col-xs-4">
								<label> Make and Model</label>
								<div id="makemodel_search" class="form-group form-inline">
									<div class="btn-group">
										<button id="makesearchbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span id="makesearchtype">Make</span> <span class="caret"></span>
										</button>
										<ul id="makesearchmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
									</div>

									<div class="btn-group">
										<button id="modelsearchbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span id="modelsearchtype">Model</span> <span class="caret"></span>
										</button>
										<ul id="modelsearchmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
									</div>

									<div class="btn-group">
										<button id="makemodelsearch" type="button" class="btn btn-primary">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="col-xs-4">
								<label> Department</label>
								<div id="department_search" class="form-group form-inline">
									<div class="btn-group">
										<button id="departmentsearchbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span id="departmentsearchtype">Department</span> <span class="caret"></span>
										</button>
										<ul id="departmentsearchmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
									</div>

									<div class="btn-group">
										<button id="departmentsearch" type="button" class="btn btn-primary">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</div>

							<div class="col-xs-4">
								<label> Location</label>
								<div id="location_search" class="form-group form-inline">
									<div class="btn-group">
										<button id="locationsearchbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
											<span id="locationsearchtype">Location</span> <span class="caret"></span>
										</button>
										<ul id="locationsearchmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
											<li><a href="#">On Campus</a></li>
											<li><a href="#">Off Campus</a></li>
										</ul>
									</div>

									<div class="btn-group">
										<button id="locationsearch" type="button" class="btn btn-primary">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</div>

						</div>


					</div>
				</div>

				<div class="panel panel-default" style="overflow:visible">
					<div class="panel-heading"><h4 class="panel-title">Search Software</h4></div>
					<div class="panel-body">
						<div class="row">
		  					<div class="col-xs-5">
								<div class="input-group">
		      						<input id="swsearchinput" type="text" class="form-control" placeholder="Search">
									<span class="input-group-btn">
		        						<button id="swexecutesearch" class="btn btn-primary" type="button">
											<i class="fa fa-search"></i>
										</button>
		      						</span>
								</div><!-- input-group -->
							</div><!-- col-xs-5 -->
						</div><!-- row -->
					</div>
				</div>

				<div class="panel panel-default" style="overflow:visible">
					<div class="panel-heading"><h4 class="panel-title">Search Purchases</h4></div>
					<div class="panel-body">
						<div class="row">
		  					<div class="col-xs-5">
								<div class="input-group">
		      						<div class="input-group-btn">
		        						<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
											<span id="psearchtype">Purchase Order</span> <span class="caret"></span>
										</button>
		        						<ul id="psearchmenu" class="dropdown-menu">
		          							<li><a href="#">Purchase Order</a></li>
											<li><a href="#">Purchase Date</a></li>
		        						</ul>
									</div><!-- btn-group -->
		      						<input id="psearchinput" type="text" class="form-control" placeholder="Search">
									<span class="input-group-btn">
		        						<button id="pexecutesearch" class="btn btn-primary" type="button">
											<i class="fa fa-search"></i>
										</button>
		      						</span>
								</div><!-- input-group -->
								<span class="help-block">Select type of search and enter keywords</span>
								<p> For purchase dates, please use the following format: YYYY-MM-DD</p>
							</div><!-- col-xs-5 -->
						</div><!-- row -->
					</div>
				</div>

			</div><!-- panel-body -->
		</div><!-- #search_panel -->
	</div><!-- panel -->

	<!-- report_panel -->
	<div class="panel panel-default">
		<div id="report_panel" class="panel-collapse collapse">
			<div class="panel-body">
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
			</div>
		</div>
	</div>

	<!-- table_panel -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<div id="table_panel_head" class="row"></div>
		</div>
		<div id="table_panel" class="panel-collapse collapse">
			<div class="panel-body">
				<table id="results_table" class="tablesorter">
					<thead><tr></tr></thead>
					<tbody></tbody>
				</table>
			</div>
			<div id="pager" class="panel-footer pager" style="margin: 0px">
				<div class="row">
					<div class="col-xs-3"></div>
					<div class="col-xs-6">
						<div class="center-block">
							<div class="btn-group">
								<button class="btn btn-info first">
									<i class="fa fa-angle-double-left fa-lg"></i>
								</button>
								<button class="btn btn-info prev">
									<i class="fa fa-angle-left fa-lg"></i>
								</button>
								<button class="btn btn-info active pagedisplay">
								</button>
								<button class="btn btn-info next">
									<i class="fa fa-angle-right fa-lg"></i>
								</button>
								<button class="btn btn-info last">
									<i class="fa fa-angle-double-right fa-lg"></i>
								</button>
							</div>
						</div>
					</div><!-- col-xs-6 -->
					<div class="col-xs-3"><div class="pull-right" style="margin-top: 10px">
						Records per page
   					<select class="pagesize">
      				<option selected="selected" value="10">10</option>
      				<option value="15">15</option>
      				<option value="20">20</option>
      				<option value="9999">All</option>
    				</select>
					</div>
				</div>
			</div>
		</div>
	</div><!-- table_panel -->

</div><!-- panel-group -->

<script>
$( '#report_panel, #table_panel' ).parent().hide();

$( '#search_panel, #report_panel' ).on( 'show.bs.collapse', function(){
	$( this ).parent().show();
});

$( '#report_panel' ).on( 'hidden.bs.collapse', function(){
	$( this ).parent().hide();
});

$( '#search_panel' ).on( 'hidden.bs.collapse', function(){
	$( this ).parent().hide();
	$( '#search_panel' ).find( 'input' ).val( "" );
	$( '#eqsearchtype' ).text( "Property Tag" );
	$( '#makesearchtype' ).text( "Make" );
	$( '#modelsearchtype' ).text( "Model" );
	$( '#departmentsearchtype' ).text( "Department" );
	$( '#locationsearchtype' ).text( "Location" );
	$( '#psearchtype' ).text( "Purchase Order" );
});


// equipment primary search handler
$( '#eqexecutesearch' ).on( 'click', function(){
	var choice = $( '#eqsearchtype' ).text();

	if ( choice == 'Property Tag' )
		list_equipment( $( '#eqsearchinput' ).val(), "tag_num" );
	if ( choice == 'Serial Number' )
		list_equipment( $( '#eqsearchinput' ).val(), "serial" );
	if ( choice == 'Hostname' )
		list_equipment( $( '#eqsearchinput' ).val(), "hostname" );
	if ( choice == 'IP Address' )
		list_equipment( $( '#eqsearchinput' ).val(), "ip" );
	if ( choice == 'MAC Address' )
		list_equipment( $( '#eqsearchinput' ).val(), "mac" );
	if ( choice == 'Purchase Date' )
		list_equipment( $( '#eqsearchinput' ).val(), "purchasedate" );

});

// equipment primary search dropdown
$("#eqsearchmenu>li>a").on( 'click', function(){
	$( '#eqsearchtype').html( $( this ).text() );
});


// make and model search handler
$( '#makemodelsearch' ).on( 'click', function(){
	if ( $( '#makesearchtype' ).text() != "Make" && $( '#modelsearchtype' ).text() != "Model" )
	{
		var makemodel = $( '#makesearchtype' ).text() + "/" + $( '#modelsearchtype' ).text();
		list_equipment( makemodel, "makemodel" );
	}

	else if ( $( '#makesearchtype' ).text() != "Make" && $( '#modelsearchtype' ).text() == "Model" )
		list_equipment( $( '#makesearchtype' ).text(), "make" );
});


// make and model dropdowns
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "make" },
	success: function( result ) {
		results = $.parseJSON( result );
		$.each( results, function( i ){
			$('#makesearchmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
		});

		$("#makesearchmenu>li>a").on( 'click', function(){
	  		$( '#makesearchtype').html( $( this ).text() );

			$.ajax({
				type: "POST",
				url: "include/populate_menus.php",
				data: { query : "model_from_make", make : $('#makesearchtype').html() },
				success: function( result ) {
					results = $.parseJSON( result );

					$.each( results, function( i ){
						$('#modelsearchmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
					});

					$("#modelsearchmenu>li>a").on( 'click', function(){
  						$( '#modelsearchtype').html( $( this ).text() );
					});
				}
			});
		});
	}
});

// department search handler
$( '#departmentsearch' ).on( 'click', function(){
	if ( $( '#departmentsearchtype' ).text() != "Department" )
	{
		var department = $( '#departmentsearchtype' ).text();
		list_equipment( department, "department" );
	}
});

// department dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "department" },
	success: function( result ){
		results = $.parseJSON( result );
		$.each( results, function( i ){
			$( '#departmentsearchmenu' ).append( "<li><a href='#'>" + results[i] + "</a></li>" );
		});

		$("#departmentsearchmenu>li>a").on( 'click', function(){
  			$( '#departmentsearchtype').html( $( this ).text() );
		});
	}
});

// location search handler
$( '#locationsearch' ).on( 'click', function(){
	if ( $( '#locationsearchtype' ).text() != "Location" )
	{
		var location = $( '#locationsearchtype' ).text();
		if ( location == "Off Campus" )
			location = "off";

		else if ( location == "On Campus" )
			location = "on";

		list_equipment( location, "location" );
	}
});

// location dropdown
$("#locationsearchmenu>li>a").on( 'click', function(){
	$( '#locationsearchtype').html( $( this ).text() );
});

// software search handler
$( '#swexecutesearch' ).on( 'click', function(){
	if ( $( '#swsearchinput' ).val() != "" )
		list_software( $( '#swsearchinput' ).val() );
});


// purchases primary search handler
$( '#pexecutesearch' ).on( 'click', function(){
	var choice = $( '#psearchtype' ).text();

	if ( choice == 'Purchase Order' )
		list_purchases( $( '#psearchinput' ).val(), "purchaseorder");
	if ( choice == 'Purchase Date' )
		list_purchases( $( '#psearchinput' ).val(), "purchasedate" );
});

// purchase primary search dropdown
$("#psearchmenu>li>a").on( 'click', function(){
	$( '#psearchtype').html( $( this ).text() );
});

</script>
