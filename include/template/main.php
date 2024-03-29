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
								<p> For purchase dates, please use the following format: YYYY-MM-DD</p>
							</div><!-- col-xs-5 -->
							<div class="col-xs-7">

							</div>

					
						</div><!-- row -->
						<hr>
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
	<div class="panel panel-default" style="overflow:visible">
		<div id="report_panel" class="panel-collapse collapse">
			<div class="panel-body">

				<div id="equipmentreportform" class="reportform">
					<form class="form-inline" role="form">
  						<div class="form-group" style="margin-left: 60px">
    						<label><h4>Include: &nbsp;&nbsp;</h4></label>
							<div class="checkbox">
								<label>
									<input id='eqreportpurchase' type="checkbox"> Purchase Information &nbsp;&nbsp;
								</label>
							</div>
							<?php if ( $_SESSION['role'] > 1 ) : ?>
								<div class="checkbox">
									<label>
										<input id='eqreportnetwork' type="checkbox"> Network Information &nbsp;&nbsp;
									</label>
								</div>
							<?php endif; ?>
							<div class="checkbox">
								<label>
									<input id='eqreportuser' type="checkbox"> Users &nbsp;&nbsp;
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input id='eqreportsoftware' type="checkbox"> Software &nbsp;&nbsp;
								</label>
							</div>
							<button id="equipmentreportsubmit" type="submit" class="btn btn-primary">Generate Report</button>
						</div>
					</form>
				</div>
<!--
				<div id="softwarereportform" class="reportform">
					<form class="form-inline" role="form">
  						<div class="form-group" style='margin-left:60px'>
    						<label><h4>Include: &nbsp;&nbsp;</h4></label>
							<div class="checkbox">
								<label>
									<input id='swreportlicense' type="checkbox"> License Number &nbsp;&nbsp;
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input id='swreportequipment' type="checkbox"> Equipment Installed On &nbsp;&nbsp;
								</label>
							</div>
							<button id="softwarereportsubmit" type="submit" class="btn btn-primary">Generate Report</button>
						</div>
					</form>
				</div>

				<div id="purchasesreportform" class="reportform">
					<form class="form-inline" role="form">
  						<div class="form-group" style='margin-left:60px'>
    						<label><h4>Include: &nbsp;&nbsp;</h4></label>
							<div class="checkbox">
								<label>
									<input id='preportequipment' type="checkbox" checked> Equipment &nbsp;&nbsp;
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input id='preportsoftware' type="checkbox" checked> Software &nbsp;&nbsp;
								</label>
							</div>
							<button id="purchasesreportsubmit" type="submit" class="btn btn-primary">Generate Report</button>
						</div>
					</form>
				</div>
-->
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

$( '.reportform' ).hide();

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
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
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
						if ( result.charAt( 0 ) == "<" )
							window.location.reload();

						else
						{
							results = $.parseJSON( result );

							$.each( results, function( i ){
								$('#modelsearchmenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
							});

							$("#modelsearchmenu>li>a").on( 'click', function(){
  								$( '#modelsearchtype').html( $( this ).text() );
							});
						}
					}
				});
			});
		}
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
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$( '#departmentsearchmenu' ).append( "<li><a href='#'>" + results[i] + "</a></li>" );
			});

			$("#departmentsearchmenu>li>a").on( 'click', function(){
  				$( '#departmentsearchtype').html( $( this ).text() );
			});
		}
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
$( "#psearchmenu>li>a" ).on( 'click', function(){
	$( '#psearchtype' ).html( $( this ).text() );
});

// equipment report handler
$( '#equipmentreportsubmit' ).on( 'click', function(){
	if ( $( '#numberselected' ).html() == "0" )
		alert( "No records selected!" );

	else
	{
		var records = new Array();

		$( '#results_table' ).find( '.select > i.fa-check-square-o' ).each( function(){
			var tag = $( this ).parent( '.select' ).children( 'span' ).html();
			records.push( tag );
		});

		var results = new Array();

		for ( var i = 0; i < records.length; i++ )
		{
			$.ajax({
				type: "POST",
				url: "include/get_equipment.php",
				data: { query : records[i] },
				async: false,
				success: function( result ){
					if ( result.charAt( 0 ) == "<" )
						window.location.reload();

					else
						results.push( $.parseJSON( result ) );
				}
			});
		}

		//console.log( results );

		var doc = new jsPDF();

		var k = 25;

		doc.setFontSize(14);
		
		var date = new Date();

		var title = "Equipment Report:  " + date.toDateString() + "  ( " + records.length + " items )";

		doc.text( 20, 10, title );

		for( var i = 0; i < results.length; i++ )
		{
			if ( results[i][0].location == 'off' )
				var location = "Off Campus"; 

			else
				var location = results[i][0].building + " " + results[i][0].room_num; 
			
			doc.setFontSize(12);
			doc.setFontStyle("bold");
			doc.text( 20, k, "Tag # " + results[i][0].tag + "  [" + results[i][0].eqtype + "]" );

			doc.setFontStyle("normal");
			doc.setFontSize(11);

			var j = 5;
			doc.text( 25, k + j, "Serial:  " + results[i][0].serial );
			doc.text( 100, k + j, "Department:  " + results[i][0].department );

			j = j + 5;
			doc.text( 25, k + j, "Location:  " + location );
			doc.text( 100, k + j, "Make & Model:  " + results[i][0].make + " " + results[i][0].model );

			j = j + 5;

			if ( results[i][0].eqtype == "computer" )
			{
				doc.text( 25, k + j, "OS:  " + results[i][0].os );

				if ( results[i][0].hostname )
					doc.text( 100, k + j, "Hostname:  " + results[i][0].hostname );
			}

			else if ( results[i][0].eqtype == "printer" )
				doc.text( 25, k + j, "Hostname:  " + results[i][0].hostname );

			else
				doc.text( 25, k + j, "Description:  " + results[i][0].description );

			if ( $( '#eqreportpurchase' ).is( ':checked' ) )
			{
				j = j + 5;
				doc.text( 25, k + j, "Purchase Date:  " + results[i][0].purchase_date );
				doc.text( 100, k + j, "Purchased By:  " + results[i][0].purchased_by );

				if ( results[i][0].purchase_order )
				{
					j = j + 5;
					doc.text( 25, k + j, "Purchase Order:  " + results[i][0].purchase_order );
				}
			}

			if ( $( '#eqreportnetwork' ).is( ':checked' ) )
			{
				j = j + 5;

				if ( !( results[i][0].mac ) && !( results[i][0].wmac ) && !( results[i][0].ip ) )
					doc.text( 25, k + j, "No Network Information Available!" );

				else
				{
					var l = 25;
					if ( results[i][0].mac )
					{
						doc.text( l, k + j, "MAC:  " + results[i][0].mac );

						if ( !results[i][0].ip )
							l = l + 75;

						else
							l = l + 60;
					}

					if ( results[i][0].wmac )
					{
						doc.text( l, k + j, "WMAC:  " + results[i][0].wmac );
						l = l + 60;
					}

					if ( results[i][0].ip )
						doc.text( l, k + j, "IP:  " + results[i][0].ip );
				}
			}

			if ( $( '#eqreportuser' ).is( ':checked' ) && results[i][0].users )
			{
				var q = j;

				q = q + 5;
				doc.text( 25, k + q, "Users:" );

				for( var f = 0; f < results[i][0].users.length; f++ )
				{
					q = q + 5;
					doc.text( 30, k + q, results[i][0].users[f].firstname + " " + results[i][0].users[f].lastname );
				}
				var userlength = q - j;
			}

			if ( $( '#eqreportsoftware' ).is( ':checked' ) && results[i][0].software )
			{
				var q = j;

				q = q + 5;
				doc.text( 100, k + q, "Software:" );

				for( var f = 0; f < results[i][0].software.length; f++ )
				{
					q = q + 5;
					doc.text( 105, k + q, results[i][0].software[f].name );
				}
				var softwarelength = q - j;
			}

			if ( softwarelength >= userlength )
				j = j + softwarelength;

			else
				j = j + userlength;

			k = k + j + 10;
			if ( k >= 240 )
			{
				doc.addPage();
				k = 25;
			}
		}

		doc.output( 'save', "equipment_report.pdf" );

	}
});

/*

// purchases report handler
$( '#purchasesreportsubmit' ).on( 'click', function(){
	if ( $( '#purchasesreportform' ).find( '.numberselected' ).html() == "0" )
		alert( "No records selected!" );

	else
	{
		var purchases = new Array();

		$( '#results_table' ).find( '.select > i.fa-check-square-o' ).each( function(){
			var purchase = { "purchase_order" : $( this ).parent( '.select' ).siblings( '.porder' ).text(),
								"purchase_date" : $( this ).parent( '.select' ).siblings( '.pdate' ).text(),
								"purchased_by" : $( this ).parent( '.select' ).siblings( '.pby' ).text() };

			var equipment = new Array();

			$( this ).closest( 'tr' ).next( 'tr' ).find( '.purchase_eq' ).each( function(){
				var eq = { "tag" : $( this ).children( '.view_equipment' ).text(),
							"serial" : $( this ).children( '.serial' ).text(),
							"makemodel" : $( this ).children( '.makemodel' ).text(),
							"location" : $( this ).children( '.location' ).text() };

				equipment.push( eq );
			});


			var software = new Array();

			$( this ).closest( 'tr' ).next( 'tr' ).find( '.purchase_sw' ).each( function(){
				var sw = { "name" : $( this ).children( '.softwarename' ).text(),
							"type" : $( this ).children( '.licensetype' ).text(),
							"quantity" : $( this ).children( '.licensequantity' ).text() };

				software.push( sw );
			});

			purchase.eq = equipment;
			purchase.sw = software;

			purchases.push( purchase );
		});

		console.log( "purchasereport\n" + purchases );
		var doc = new jsPDF();

		var k = 25;

		doc.setFontSize(14);
		
		var date = new Date();

		var title = "Purchase Report:  " + date.toDateString() + "  ( " + purchases.length + " items )";

		doc.text( 20, 10, title );

		for( var i = 0; i < purchases.length; i++ )
		{
			var j = 5;
			doc.setFontSize( 12 );
			doc.setFontStyle( 'bold' );
			doc.text( 20, k, "Purchase Order:  " + purchases[i].purchase_order );

			doc.setFontSize( 11 );
			doc.setFontStyle( 'normal' );
			doc.text( 25, k + j, "Purchase Date:  " + purchases[i].purchase_date );
			doc.text( 100, k + j, "Purchased by:  " + purchases[i].purchased_by );

			j = j + 5;
			doc.text( 25, k + j, "Equipment: " );

			for ( var l = 0; l < purchases[i].eq.length; l++ )
			{
					j = j + 5;
					doc.text( 30, k + j, "Tag # " + purchases[i].eq[l].tag + ":  " + purchases[i].eq[l].makemodel );
					j = j + 5;
					doc.text( 35, k + j, "Serial: " + purchases[i].eq[l].serial );
					doc.text( 100, k + j, "Location:  " + purchases[i].eq[l].location );
			}

			for ( var l = 0; l < purchases[i].sw.length; l++ )
			{
					j = j + 5;
					doc.text( 30, k + j, "Software Name:  " + purchases[i].sw[l].name );
					j = j + 5;
					doc.text( 35, k + j, "License Type:  " + purchases[i].sw[l].type );
					doc.text( 100, k + j, "License Quantity:  " + purchases[i].sw[l].quantity );
			}

			k = k + j + 10;
			if ( k >= 240 )
			{
				doc.addPage();
				k = 25;
			}
		}

		doc.output( 'save', "purchases_report.pdf" );
	}
}); */

</script>
