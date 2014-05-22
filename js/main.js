function checkRole()
{
    return $.ajax({
        type: "GET",
        url: "include/check_role.php",
        async: false
    }).responseText;
}

function delete_record( record_id, type, record_row )
{
		x = confirm( "This will permanently delete the record.\nClick OK to proceed." );
		if ( x == true )
		{
			$.ajax({
				type: "POST",
				url: "include/delete_record.php",
				data: { record_id : record_id, type : type },
				success: function( result ) {
					$( record_row ).next( '.tablesorter-childRow' ).addBack().remove();
					$( '#results_table' ).trigger( 'update' );
				}
			});
		}

}

function list_equipment( query )
{
	headers = [ "Property Tag", "Serial Number", "Make & Model", "Purchase Date", "Location", "Department", "Users" ];

	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_equipment.php",
		data: { query : query },
		success: function( result ) {
			var role = checkRole();

			createHeaders( role, headers );

			$('#search_panel:visible, #filter_panel:visible, #report_panel:visible').collapse('hide');
	
			$('#table_panel').collapse('show');

			$('#results_table').trigger('filterReset');

			$('#results_table>tbody').empty();

			populateTable_equipment( $.parseJSON( result ) );

			setupTablesorter( role );

			$('#processingModal').modal('toggle');	
		
			$('#search_panel:visible #report_panel:visible').collapse('hide');
			$('#table_panel').collapse('show');
		}
	});
}

function list_users( query )
{
	headers = [ "First Name", "Last Name", "Email Address", "Campus Extension" ];

	$('#processingModal').modal('toggle');

	$.ajax({
		type: "POST",
		url: "include/list_users.php",
		data: { query : query },
		success: function( result ) {
			var role = checkRole();

			createHeaders( role, headers );

			$('#search_panel:visible, #filter_panel:visible, #report_panel:visible').collapse('hide');
	
			$('#table_panel').collapse('show');

			$('#results_table').trigger('filterReset');

			$('#results_table>tbody').empty();

			populateTable_users( $.parseJSON( result ) );

			setupTablesorter( role );

			$('#processingModal').modal('toggle');
		
			$('#search_panel:visible #report_panel:visible').collapse('hide');
			$('#table_panel').collapse('show');
		}
	});
}

function list_purchases( query )
{
	headers = [ "Purchase Order", "Purchase Date", "Purchased By" ];

	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_purchases.php", 
		data: { query: query },
		success: function( result ) {
			var role = checkRole();

			createHeaders( role, headers );

			$('#search_panel:visible, #filter_panel:visible, #report_panel:visible').collapse('hide');
	
			$('#table_panel').collapse('show');

			$('#results_table').trigger('filterReset');

			$('#results_table>tbody').empty();

			populateTable_purchases( $.parseJSON( result ) );

			setupTablesorter( role );

			$('#processingModal').modal('toggle');
		
			$('#search_panel:visible #report_panel:visible').collapse('hide');
			$('#table_panel').collapse('show');
		}
	});
}

function list_software( query )
{
	headers = [ "Software Name", "License Number", "License Type", "License Quantity", "Notes" ];

	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_software.php",
		data: { query: query },
		success: function( result ) {
			var role = checkRole();

			createHeaders( role, headers );

			$('#search_panel:visible, #filter_panel:visible, #report_panel:visible').collapse('hide');
	
			$('#table_panel').collapse('show');

			$('#results_table').trigger('filterReset');

			$('#results_table>tbody').empty();

			populateTable_software( $.parseJSON( result ) );

			setupTablesorter( role );

			$('#processingModal').modal('toggle');
		
			$('#search_panel:visible #report_panel:visible').collapse('hide');
			$('#table_panel').collapse('show');
		}
	});
}


function setupTablesorter( role )
{
	$('#results_table').trigger("destroy");
	
	$( '.parent_row>td' ).not('.select,.trash,.edit').on( 'click', function(){
		$( this ).closest( 'tr' ).nextUntil( 'tr.tablesorter-hasChildRow' ).find( 'td' ).toggle();
	});
	
	$( '.select>i').on( 'click', function(){
		$(this).toggleClass( 'fa-check-square-o fa-square-o');
	});

	$( '#select_all').on( 'click', function(){
		$(this).toggleClass( 'checked unchecked');

		if ( $(this).hasClass( 'checked' ) )
		{
			$('.parent_row:visible').find('.select > i')
				.removeClass('fa-square-o')
				.addClass('fa-check-square-o');

			$('#select_all').html( '<i class="fa fa-check-square-o"></i>');

		}
		else if ( $(this).hasClass( 'unchecked' ) )
		{
			$('.parent_row:visible').find('.select > i')
				.removeClass('fa-check-square-o')
				.addClass('fa-square-o');

			$('#select_all').html( '<i class="fa fa-square-o"></i>');
		}
	});

	var options = {
		widthFixed : true,
		cssChildRow : 'tablesorter-childRow',
		headerTemplate : '{content} {icon}',
		widgets: [ 'filter' ],
		headers: { 0 : { sorter: false },
					'#edit_selected' : { sorter : false },
					'#trash_selected' : { sorter : false }
		},
		widgetOptions: {
			filter_external : '.search',
			filter_childRows : false,
			filter_columnFilters : false,
			filter_ssFilter : 'tablesorter-filter'
		}
	};

	var pagerOptions = {
		container: $(".pager"),
		page: 0,
		size: 15,
		output: ' <b>( Results: {filteredRows} )  Showing Results {startRow} to {endRow}</b> ',
    cssPageDisplay: '.pagedisplay',
    cssPageSize: '.pagesize',
		cssNext: '.next',
    cssPrev: '.prev',
    cssFirst: '.first',
    cssLast: '.last'
	};


	$('#table_panel_head').html( '<div class="col-xs-3"><input class="form-control search" type="text" placeholder="Filter Results" data-column="all"></div><div class="col-xs-9"><button id="createReportBtn" class="pull-right btn btn-info collapse in" data-toggle="collapse" href="#report_panel"><i class="fa fa-file"></i>&nbsp;&nbsp;Create Report</button></div>' );

	$('#results_table').tablesorter( options )
		.tablesorterPager(pagerOptions)
		.bind( 'sortStart', function(){
			$(this).trigger('pageSet', 0 );
		})
		.bind( 'pagerComplete', function(){
			if ( $( '.select:visible' ).find( 'i' ).hasClass( 'fa-square-o' ) )
			{
				$( '#select_all>i' ).addClass( 'fa-square-o' ).removeClass( 'fa-check-square-o' );
				$( '#select_all' ).addClass( 'unchecked' ).removeClass( 'checked' );
			}

			else
			{
				$( '#select_all>i' ).addClass( 'fa-check-square-o' ).removeClass( 'fa-square-o' );
				$( '#select_all' ).addClass( 'checked' ).removeClass( 'unchecked' );
			}
		});

	$('.tablesorter-childRow td').hide();

	$( '.search' ).on( 'keyup', function(){
		$( '.tablesorter-childRow td' ).hide();
	});

	$( '#results_table>tbody' ).on( 'mouseover', function(){
		$( '#search_panel:visible, #report_panel:visible' ).collapse( 'hide' );
	});

	$( '#table_panel_head>div>input' ).on( 'click', function(){
		$( '#search_panel:visible, #report_panel:visible' ).collapse( 'hide' );
	});

	$( '#createReportBtn' ).on( 'click', function(){
		$( '#search_panel:visible' ).collapse( 'hide' );
	});

	$( '#searchBtn' ).on( 'click', function(){
		$( '#report_panel:visible' ).collapse( 'hide' );
	});

	// Deletes record from database
	$( '.trash>i').on( 'click', function(){
		var record_row = $( this ).closest( '.parent_row');
		var record_id = $( this ).parents().siblings( '.select' ).children( 'span' ).html();

		delete_record( record_id, 'equipment', record_row );
	});

	
	$( '.view_equipment' ).on( 'click', function(){
		list_equipment( $( this ).html() );
	});

	$( '.view_purchase' ).on( 'click', function(){
		list_purchases( $( this ).html() );
	});

}



function createHeaders( role, headers )
{
	var headerRow = new Array();	

	headerRow.push( $( "<th>" )
		.addClass( "unchecked" )
		.attr({ "id" : "select_all",
				"scope" : "col",
				"style" : "padding-left: 5px" })
		.html( "<i class='fa fa-square-o'></i>" ) );

	if ( role > 1 )
	{
	headerRow.push( $( "<th>" )
		.attr({ "id" : "edit_selected",
				"scope" : "col",
				"style" : "padding-left: 5px" })
		.html( "<i class='fa fa-cog'></i>" ) );
	}

	if ( role > 2 && headers[0] != "Purchase Order" )
	{
	headerRow.push( $( "<th>" )
		.attr({ "id" : "trash_selected",
				"scope" : "col",
				"style" : "padding-left: 5px" })
		.html( "<i class='fa fa-trash-o'></i>" ) );
	}

	$.each( headers, function(){
		headerRow.push( $( "<th>" )
			.attr( "scope", "col" )
			.html( this ) );
	});

	$( '#results_table>thead>tr').html( headerRow );

}

function populateTable_equipment( results )
{
	var role = checkRole();

	var tableRows = new Array();

	if ( !results )
		return;

	$.each( results, function(){
		row = "";
		row += "<tr class='parent_row'>";
		row += "<td class='select' rowspan='2'><span style='display:none'>" + this.tag + "</span>";
		row += "<i class='fa fa-square-o'></i></td>";
	
		if ( role > 1 )
			row += "<td class='edit' rowspan='2'><i class='fa fa-cog'></i></td>";

		if ( role > 2 )
			row += "<td class='trash' rowspan='2'><i class='fa fa-trash-o'></i></td>";

		row += "<td class='table_tag'>" + this.tag + "</td>";
		row += "<td class='table_serial'>" + this.serial + "</td>";
		row += "<td class='table_makemodel'>" + this.makemodel + "</td>";
		row += "<td class='table_purchasedate'>" + this.purchase_date + "</td>";
		row += "<td class='table_location'>" + this.location + "</td>";
		row += "<td class='table_department'>" + this.department + "</td><td class='table_users'>";

		if ( this.users )
		{
			$.each( this.users, function( i ){
				if ( this.lastname )
					row += this.firstname + " " + this.lastname + "<br>";
				else
					row += this.firstname + "<br>";
			});
		}
		row += "</td></tr><tr class='tablesorter-childRow'><td colspan='10'>";
		row += '<div class="panel panel-default panel-body"><div class="row"><div class="col-xs-3">';

		row += '<b>Purchase Order:&nbsp;&nbsp;</b>';
		if ( this.purchase_order )
			row += "<span class='view_purchase table_purchaseorder' style='cursor: pointer' title='View this purchase order'>" + this.purchase_order + "</span>";

		row += '<br><b>Purchased By:&nbsp;&nbsp;</b><span class="table_purchasedby">';
		if ( this.purchased_by )
			row += this.purchased_by;

		row += '</span></div><div class="col-xs-3">';

		row += '<b>Hostname:&nbsp;&nbsp;</b><span class="table_hostname">';
		if ( this.hostname )
			row += this.hostname;

		row += '</span><br><b>OS:&nbsp;&nbsp;</b><span class="table_os">';
		if ( this.os )
			row += this.os;

		row += '</span><br><b>Printer:&nbsp;&nbsp;</b><span class="table_printer">';
		if ( this.eq_printer )
			row += this.eq_printer;

		row += '</span></div>';

		if ( role > 1 )
		{
			row += '<div class="col-xs-3">';

			row += '<b>MAC:&nbsp;&nbsp;</b><span class="table_mac">';
			if ( this.mac )
				row += this.mac;

			row += '</span><br><b>WMAC:&nbsp;&nbsp;</b><span class="table_wmac">';
			if ( this.wmac )
				row += this.wmac;

			row += '</span><br><b>IP:&nbsp;&nbsp;</b><span class="table_ip">';
			if ( this.ip )		
				row += this.ip;
			
			row += '</span></div>';
		}

		row += '<div class="col-xs-3">';
		row += '<b>Software:</b><br>';

		if ( this.software )
		{
			$.each( this.software, function( i ){
				row += this.name + "<br>";
			});
		}

		row += '</div></div>';

		if ( this.description )
			row += '<hr><div class="row"><div class="col-xs-12"><b>Description:&nbsp;&nbsp;</b><span class="table_description">' + this.description + '</span></div></div>';

		if ( this.eq_notes )
			row += '<hr><div class="row"><div class="col-xs-12"><b>Notes:&nbsp;&nbsp;</b>' + this.eq_notes + '</div></div>';

		row += '</div></td></tr>';

		tableRows.push( row );		

	});
		
	$( '#results_table>tbody' ).html( tableRows.join( "" ) );


	// edit equipment modal
	$( '.edit>i').on( 'click', function(){
		var tag = $( this ).parents().siblings( '.select' ).children( 'span' ).html();

		// retrieve information about record, add to modal forms
		$.ajax({
			type: "POST",
			url: "include/get_equipment.php",
			data: { query : tag },
			success: function( result ){

				console.log( result );
				result = $.parseJSON( result );
				$( '#tag_num' ).attr( 'disabled', true ).val( result[0].tag );
				$( '#serial' ).val( result[0].serial );
				$( '#maketype' ).text( result[0].make );
				$( '#modeltype' ).text( result[0].model );

				if ( result[0].eqtype == "computer" )
				{
					$( '#eqtype' ).text( "Computer or Tablet" );
					$( '#hostname_input' ).show();
					$( '#hostname_input>label' ).text( "Hostname*" );
					$( '#hostname' ).val( result[0].hostname );
					$( '#os_input' ).show();
					$( '#ostype' ).text( result[0].os );
					$( '#printer_input' ).show();
					$( '#eq_printer' ).val( result[0].printer );

					$( '#softwarenotavailable' ).hide();
					$( '#selectsoftware_input' ).show();

					// set software values
					if ( result[0].software )
					{
						$.each( results[0].software, function( i ){
							$( '#softwarelist' ).append( "<li><span class='hidden software_id'>" + this.softwareid + "</span><i class='fa fa-minus-square' style='cursor:pointer'></i> " + this.name + ", " + this.licensetype + "</li>" );
						});

						$( '#softwarelist>li>i').on( 'click', function(){
							$( this ).parents( 'li' ).remove();
						});
					}
				}

				else if ( result[0].eqtype == "printer" )
				{
					$( '#eqtype' ).text( "Network Printer" );
					$( '#hostname_input' ).show();
					$( '#hostname' ).val( result[0].hostname );
				}

				else if ( result[0].eqtype == "other" )
				{
					$( '#eqtype' ).text( "Other Equipment" );
					$( '#description_input' ).show();
					$( '#description' ).val( result[0].description );		
				}

				$( '.pid' ).each( function(){
					if ( $( this ).text() == result[0].purchase_id )
						$( this ).parent( 'li' ).addClass( 'selectedpurchaser' );
				});

				if ( result[0].purchase_order )
					$( '#purchasetype' ).text( result[0].purchase_order );

				else
					$( '#purchasetype' ).text( "Not Available" );
				
				$( '#purchasedate_input' ).show();
				$( '#purchasedate' ).attr( 'disabled', true ).val( result[0].purchase_date );
				$( '#purchasedby_input' ).show().find( '#newPurchaser' ).hide();
				$( '#purchasertype' ).text( result[0].purchased_by ).parent().removeAttr( 'data-toggle' ).addClass( 'active' );
				
				$( '#departmenttype' ).text( result[0].department );

				if ( result[0].location == "off" )
					$( '#locationtype' ).text( "Off Campus" );

				else if ( result[0].location == "on" )
				{
					$( '#location_input' ).show();
					$( '#locationtype' ).text( "On Campus" );
					$( '#building_input' ).show();
					$( '#buildingtype' ).text( result[0].building );
					$( '#room_num_input' ).show();
					$( '#room_num' ).val( result[0].room_num );
				}

				// set user information
				if ( result[0].users )
				{
					$( '#selectusertype_input' ).show();
					$( '#usersnotavailable' ).hide();
					
					// check if eq is of type Faculty/staff
					if ( result[0].users[0].lastname )
					{
						$( '#usertype' ).text( "Faculty/Staff" );
						$( '#selectusers_input' ).show();

						$.each( result[0].users, function( i ){
							$( '#userlist' ).append( "<li><span class='hidden user_id'>" + this.userid + "</span><i class='fa fa-minus-square' style='cursor:pointer'></i> " + this.firstname + " " + this.lastname + "</li>");
						});

						$( '#userlist>li>i').on( 'click', function(){
							$( this ).parents( 'li' ).remove();
						});

					}

					// eq is of type lab workstation
					else
					{
						$( '#usertype' ).text( "Lab Workstation" );
						$( '#selectlab_input' ).show();
										
						$( '.uid' ).each( function(){
							if ( $( this ).text() == result[0].users[0].userid )
								$( this ).parent( 'li' ).addClass( 'selectedlab' );
						});

						$( '#labtype' ).text( result[0].users[0].firstname );
					}
				}

				// set network information
				$( '#mac' ).val( result[0].mac );
				$( '#wmac' ).val( result[0].wmac );
				$( '#ip' ).val( result[0].ip );

				// set notes
				$( '#notes' ).val( result[0].eq_notes );
			}
		});

		$( '#addEquipmentModal' ).modal( 'show' ).find( '.modal-title' ).text( "Edit Equipment Record" );
	});


}

function populateTable_users( results )
{
	var role = checkRole();

	var tableRows = new Array();

	if ( !results )
		return;

	$.each( results, function(){
		row = "";
		row += "<tr class='parent_row'>";
		row += "<td class='select' rowspan='2'><span style='display:none'>" + this.userid + "</span>";
		row += "<i class='fa fa-square-o'></i></td>";
	
		if ( role > 1 )
			row += "<td class='edit' rowspan='2'><i class='fa fa-cog'></i></td>";

		if ( role > 2 )
			row += "<td class='trash' rowspan='2'><i class='fa fa-trash-o'></i></td>";

		row += "<td>" + this.firstname + "</td>";
		row += "<td>" + this.lastname + "</td>";
		if ( !this.email)
			this.email = "N/A";
		row += "<td>" + this.email + "</td>";
		if ( !this.phone )
			this.phone = "N/A";
		row += "<td>" + this.phone + "</td>";

		row += "</tr><tr class='tablesorter-childRow'><td colspan='10'>";
		row += '<div class="panel panel-group">';

		if ( this.equipment )
		{
			$.each( this.equipment, function( i ){
				row += "<div class='panel panel-default' style='padding: 5px'>";
				row += "&nbsp;&nbsp;&nbsp;<b>Tag: </b>";
				row += "<span class='view_equipment' style='cursor: pointer' title='View this equipment record'>" + this.tag;
				row += "</span><b> / Serial: </b>" + this.serial;
				row += "<b> / Make & Model: </b>" + this.makemodel;
				row += "<b> / Location: </b>" + this.location;
				row += "<b> / Department: </b>" + this.department;
				row += "</div>";
				if ( this.count >= i )
					row += "<br>";
			});
		}		
		
		row += '</div></td></tr>';

		tableRows.push( row );		

	});
		
	$( '#results_table>tbody' ).html( tableRows.join( "" ) );

	$( '.edit>i').on( 'click', function(){
		var tag = $(this).parents().siblings( '.select' ).children( 'span' ).html();
		/*******************************************************
		 Gather attributes, call edit_user modal
		*******************************************************/
		alert( "Edit " + tag );
	});
}


function populateTable_purchases( results )
{
	var role = checkRole();

	var tableRows = new Array();

	if ( !results )
		return;

	$.each( results, function(){
		row = "";
		row += "<tr class='parent_row'>";
		row += "<td class='select' rowspan='2'><span style='display:none'>" + this.purchaseid + "</span>";
		row += "<i class='fa fa-square-o'></i></td>";
	
		if ( role > 1 )
			row += "<td class='edit' rowspan='2'><i class='fa fa-cog'></i></td>";

		if ( !this.purchaseorder )
			this.purchaseorder = "N/A";
		row += "<td>" + this.purchaseorder + "</td>";
		row += "<td>" + this.purchasedate + "</td>";
		row += "<td>" + this.purchasedby + "</td>";

		row += "</tr><tr class='tablesorter-childRow'><td colspan='10'>";
		row += '<div class="panel panel-group">';

		if ( this.equipment )
		{
			$.each( this.equipment, function( i ){
				row += "<div class='panel panel-default' style='padding: 5px'>";
				row += "&nbsp;&nbsp;&nbsp;<b>Tag: </b>";
				row += "<span class='view_equipment' style='cursor: pointer' title='View this equipment record'>" + this.tag;
				row += "</span><b> / Serial: </b>" + this.serial;
				row += "<b> / Make & Model: </b>" + this.makemodel;
				row += "<b> / Location: </b>" + this.location;
				row += "<b> / Department: </b>" + this.department;
				row += "</div>";
				if ( this.count >= i )
					row += "<br>";
			});
		}		
		
		if ( this.software )
		{
			$.each( this.software, function( i ){
				row += "<div class='panel panel-default' style='padding: 5px'>";
				row += "&nbsp;&nbsp;&nbsp;<b>Software Name: </b>" + this.s_name;
				row += "<b> / License Type: </b>" + this.type;
				row += "<b> / License Quantity: </b>" + this.quantity;
				row += "</div>";
				if ( this.count >= i )
					row += "<br>";
			});
		}		
		row += '</div></td></tr>';

		tableRows.push( row );		

	});
		
	$( '#results_table>tbody' ).html( tableRows.join( "" ) );

	$( '.edit>i').on( 'click', function(){
		var tag = $(this).parents().siblings( '.select' ).children( 'span' ).html();
		/*******************************************************
		 Gather attributes, call edit_purchase modal
		*******************************************************/
		alert( "Edit " + tag );
	});
}


function populateTable_software( results )
{
	var role = checkRole();

	var tableRows = new Array();

	if ( !results )
		return;

	$.each( results, function(){
		row = "";
		row += "<tr class='parent_row'>";
		row += "<td class='select' rowspan='2'><span style='display:none'>" + this.softwareid + "</span>";
		row += "<i class='fa fa-square-o'></i></td>";
	
		if ( role > 1 )
			row += "<td class='edit' rowspan='2'><i class='fa fa-cog'></i></td>";

		if ( role > 2 )
			row += "<td class='trash' rowspan='2'><i class='fa fa-trash-o'></i></td>";

		row += "<td>" + this.softwarename + "</td>";
		row += "<td>" + this.licensenumber + "</td>";
		row += "<td>" + this.licensetype + "</td>";
		row += "<td>" + this.licensequantity + "</td>";
		row += "<td>" + this.licensenotes + "</td>";

		row += "</tr><tr class='tablesorter-childRow'><td colspan='10'>";
		row += '<div class="panel panel-group">';

		if ( this.equipment )
		{
			$.each( this.equipment, function( i ){
				row += "<div class='panel panel-default' style='padding: 5px'>";
				row += "&nbsp;&nbsp;&nbsp;<b>Tag: </b>";
				row += "<span class='view_equipment' style='cursor: pointer' title='View this equipment record'>" + this.tag;
				row += "</span><b> / Serial: </b>" + this.serial;
				row += "<b> / Make & Model: </b>" + this.makemodel;
				row += "<b> / Location: </b>" + this.location;
				row += "<b> / Department: </b>" + this.department;
				row += "</div>";
				if ( this.count >= i )
					row += "<br>";
			});
		}		

		row += '</div></td></tr>';

		tableRows.push( row );		

	});
		
	$( '#results_table>tbody' ).html( tableRows.join( "" ) );

	$( '.edit>i').on( 'click', function(){
		var tag = $( this ).parents().siblings( '.select' ).children( 'span' ).html();
		/*******************************************************
		 Gather attributes, call edit_software modal
		*******************************************************/
		alert( "Edit " + tag );
	});

}



//  Password hashing functions

function formhash( form, password )
{
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement( "input" );
 
    // Add the new element to our form. 
    form.appendChild( p );
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512( password.value );
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
 
    // Finally submit the form. 
    form.submit();
}
 
function regformhash( form, uid, password, conf, role )
{
    // Check each field has a value
    if ( uid.value == '' || password.value == '' ||  conf.value == '' || role.value == '' )
	{ 
        alert( 'You must provide all the requested details.' );
        return false;
    }
 
    // Check the username
    re = /^\w+$/; 
    if( !re.test( form.username.value ) )
	{ 
        alert( "Username must contain only letters, numbers and underscores." ); 
        form.username.focus();
        return false; 
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ( password.value.length < 6 )
	{
        alert( 'Passwords must be at least 6 characters long.  Please try again' );
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if ( !re.test( password.value ) )
	{
        alert( 'Passwords must contain at least one number, one lowercase and one uppercase letter.' );
        return false;
    }
 
    // Check password and confirmation are the same
    if ( password.value != conf.value )
	{
        alert( 'Passwords do not match!' );
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement( "input" );
 
    // Add the new element to our form. 
    form.appendChild( p );
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512( password.value );
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}

function pwdformhash( form, password, conf )
{
    // Check each field has a value
    if ( password.value == '' ||  conf.value == '' )
	{ 
        alert( 'You must provide all the requested details.' );
        return false;
    }
 
    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if ( password.value.length < 6 )
	{
        alert( 'Passwords must be at least 6 characters long.  Please try again' );
        form.password.focus();
        return false;
    }
 
    // At least one number, one lowercase and one uppercase letter 
    // At least six characters 
 
    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
    if ( !re.test( password.value ) )
	{
        alert( 'Passwords must contain at least one number, one lowercase and one uppercase letter.' );
        return false;
    }
 
    // Check password and confirmation are the same
    if ( password.value != conf.value )
	{
        alert( 'Passwords do not match!' );
        form.password.focus();
        return false;
    }
 
    // Create a new element input, this will be our hashed password field. 
    var p = document.createElement( "input" );
 
    // Add the new element to our form. 
    form.appendChild( p );
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512( password.value );
 
    // Make sure the plaintext password doesn't get sent. 
    password.value = "";
    conf.value = "";
 
    // Finally submit the form. 
    form.submit();
    return true;
}






