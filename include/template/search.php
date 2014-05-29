<div class="panel-group" style="overflow:visible">

	<!-- equipment search panel -->
	<div class="panel panel-default" style="overflow:visible">
		<div class="panel-heading">
			<h4 class="panel-title">Search Equipment</h4>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-5">
					<div class="input-group">
	      				<div class="input-group-btn">
	        				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<span id="searchtype">Property Tag</span> <span class="caret"></span>
							</button>
	        				<ul id="searchmenu" class="dropdown-menu">
	          					<li><a href="#">Property Tag</a></li>
	          					<li><a href="#">Serial Number</a></li>
	          					<li><a href="#">Hostname</a></li>
	          					<li><a href="#">IP Address</a></li>
	          					<li><a href="#">MAC Address</a></li>
								<li><a href="#">Purchase Date</a></li>
	        				</ul>
						</div><!-- btn-group -->
	      				<input id="searchinput" type="text" class="form-control" placeholder="Search">
						<span class="input-group-btn">
	        				<button id="executesearch" class="btn btn-primary" type="button">
								<i class="fa fa-search"></i>
							</button>
	      				</span>
					</div><!-- input-group -->
					<span class="help-block">Select type of search and enter keywords</span>
					<p> For purchase dates, please use the following format: YYYY-MM-DD</p>
				</div>
				<div class="col-xs-offset-1 col-xs-5">			
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
					<span class="help-block">Select make and model</span>
</div>

			</div>
		</div>
	</div>

	<?php if ( $_SESSION['role'] > 1 ) : ?>
	<!-- software search panel -->
	<div class="panel panel-default" style="overflow:visible">
		<div class="panel-heading">
			<h4 class="panel-title">Search Software</h4>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-3 form-inline">
					<input class="form-control" type="text" placeholder="Search Software">
	        		<button id="sw_search" class="btn btn-primary" type="button">
						<i class="fa fa-search"></i>
					</button>
	 			</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<!-- purchases search panel -->
	<div class="panel panel-default" style="overflow:visible">
		<div class="panel-heading">
			<h4 class="panel-title">Search Purchases</h4>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-5">
					<div class="input-group">
      					<div class="input-group-btn">
        					<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
								<span id="searchtype">Purchase Order</span> <span class="caret"></span>
							</button>
        					<ul id="searchmenu" class="dropdown-menu">
        	  					<li><a href="#">Purchase Order</a></li>
								<li><a href="#">Purchase Date</a></li>
        					</ul>
						</div><!-- btn-group -->
      					<input id="searchinput" type="text" class="form-control" placeholder="Search">
						<span class="input-group-btn">
        					<button id="executesearch" class="btn btn-primary" type="button">
								<i class="fa fa-search"></i>
							</button>
      					</span>
					</div><!-- input-group -->
					<span class="help-block">Select type of search and enter keywords</span>
					<p> For purchase dates, please use the following format: YYYY-MM-DD</p>
 				</div>
			</div>
		</div>
	</div>

	<!-- user search panel -->
	<div class="panel panel-default" style="overflow:visible">
		<div class="panel-heading">
			<h4 class="panel-title">Search Users</h4>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-7 form-inline">
					<input class="form-control" type="text" placeholder="First Name">
					<input class="form-control" type="text" placeholder="Last Name">
    	    		<button id="executesearch" class="btn btn-primary" type="button">
						<i class="fa fa-search"></i>
					</button>
				</div>
			</div>
		</div>
	</div>

</div>

<script>
$("#searchmenu>li>a").on( 'click', function(){
	$( '#searchtype').html( $( this ).text() );
	$( '#searchinput' ).val( "" );
});

$("#locationsearchmenu>li>a").on( 'click', function(){
	$( '#locationsearchtype').html( $( this ).text() );
});

$( '#executesearch' ).on( 'click', function(){
	var choice = $( '#searchtype' ).text();

	if ( choice == 'Property Tag' )
		list_equipment( $( '#searchinput' ).val(), "tag_num" );
	if ( choice == 'Serial Number' )
		list_equipment( $( '#searchinput' ).val(), "serial" );
	if ( choice == 'Hostname' )
		list_equipment( $( '#searchinput' ).val(), "hostname" );
	if ( choice == 'IP Address' )
		list_equipment( $( '#searchinput' ).val(), "ip" );
	if ( choice == 'MAC Address' )
		list_equipment( $( '#searchinput' ).val(), "mac" );
	if ( choice == 'Users' )
		list_users( $( '#searchinput' ).val() );
	if ( choice == 'Purchase Order' )
		list_purchases( $( '#searchinput' ).val(), "purchaseorder");
	if ( choice == 'Purchase Date' )
		list_purchases( $( '#searchinput' ).val(), "purchasedate" );
	if ( choice == 'Software' )
		list_software( $( '#searchinput' ).val() );
});

// additional search filter handlers

$( '#makemodelsearch' ).on( 'click', function(){
	if ( $( '#makesearchtype' ).text() != "Make" && $( '#modelsearchtype' ).text() != "Model" )
	{
		var makemodel = $( '#makesearchtype' ).text() + "/" + $( '#modelsearchtype' ).text();
		list_equipment( makemodel, "makemodel" );
	}

	else if ( $( '#makesearchtype' ).text() != "Make" && $( '#modelsearchtype' ).text() == "Model" )
	{
		var make = $( '#makesearchtype' ).text();
		list_equipment( make, "make" );

	}
});

$( '#departmentsearch' ).on( 'click', function(){
	if ( $( '#departmentsearchtype' ).text() != "Department" )
	{
		var department = $( '#departmentsearchtype' ).text();
		list_equipment( department, "department" );
	}
});

$( '#purchasedbysearch' ).on( 'click', function(){
	if ( $( '#purchasedbysearchtype' ).text() != "Purchaser" )
	{
		var purchaser = $( '#purchasedbysearchtype' ).text();
		list_equipment( purchaser, "purchasedby" );
	}
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

// purchased by dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "purchased_by" },
	success: function( result ){
		results = $.parseJSON( result );
		$.each( results, function( i ){
			$('#purchasedbysearchmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
		});

		$("#purchasedbysearchmenu>li>a").on( 'click', function(){
  			$( '#purchasedbysearchtype').html( $( this ).text() );
		});
	}
});


</script>
