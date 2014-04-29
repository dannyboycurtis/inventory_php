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


function list_all_computers()
{
	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_computers.php",
		data: { query : "all" },
		success: function( result ) {
			createTable_computers( $.parseJSON( result ) );
			$('#processingModal').modal('toggle');
		}
	});
}

function list_all_labs()
{
	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_labs.php",
		data: { query : "all" },
		success: function( result ) {
			createTable_computers( $.parseJSON( result ) );
			$('#processingModal').modal('toggle');
		}
	});
}


function createTable( role, headers )
{
// search panel
	filterBox = $( "<input>" )
		.addClass( "form-control search" )
		.attr({ "type" : "text",
				"placeholder" : "Filter Results",
				"data-column" : "all" });

	optionsBtn = $( "<button>" )
		.addClass( "btn btn-info" )
		.attr({ "id" : "optionsBtn",
				"style" : "margin-left: 5px" })
		.html( "<i class='fa fa-search'></i>&nbsp;Options" );

	reportBtn = $( "<button>" )
		.addClass( "btn btn-info" )
		.attr({ "id" : "reportBtn",
				"style" : "margin-left: 5px" })
		.html( "<i class='fa fa-file-o'></i>&nbsp;Create Report" );

	searchPanel = $( "<div>" )
		.addClass( "form-inline" )
		.append( [filterBox, optionsBtn, reportBtn ]);

	panelHead = $( "<div>" )
		.addClass( "panel-heading" )
		.append( searchPanel );

// table
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

	if ( role > 2 )
	{
	headerRow.push( $( "<th>" )
		.attr({ "id" : "delete_selected",
				"scope" : "col",
				"style" : "padding-left: 5px" })
		.html( "<i class='fa fa-trash-o'></i>" ) );
	}

	$.each( headers, function(){
		headerRow.push( $( "<th>" )
			.attr( "scope", "col" )
			.html( this ) );
	});

	table = $( "<table>" )
		.addClass( "tablesorter" )		
		.attr( "id", "results_table" );

	thead = $( "<thead>" )
		.appendTo( table );

	tr = $( "<tr>" )
		.append( headerRow )
		.appendTo( thead );

	tbody = $( "<tbody>" )
		.appendTo( table );

	panelBody = $( "<div>" ).addClass( "panel-body" )
							.append( table );

// pager panel
	pagerPanel = $( "<div>" )
		.addClass( "pager pagination center-block" )
		.attr({ "id" : "pager",
				"style" : "margin: 0px" });

	firstBtn = $( "<button>" )
		.addClass( "btn btn-info first" )
		.html( "<i class='fa fa-angle-double-left fa-lg'></i>" );

	prevBtn = $( "<button>" )
		.addClass( "btn btn-info prev" )
		.html( "<i class='fa fa-angle-left fa-lg'></i>" );

	pageDisplay = $( "<button>" )
		.addClass( "btn btn-info active pagedisplay" );

	nextBtn = $( "<button>" )
		.addClass( "btn btn-info next" )
		.html( "<i class='fa fa-angle-right fa-lg'></i>" );

	lastBtn = $( "<button>" )
		.addClass( "btn btn-info last" )
		.html( "<i class='fa fa-angle-double-right fa-lg'></i>" );

	buttonGroup = $( "<div>" )
		.addClass( "btn-group" )
		.append( [firstBtn, prevBtn, pageDisplay, nextBtn, lastBtn] )
		.appendTo( pagerPanel );

	panelFoot = $( "<div>" )
		.addClass( "panel-footer" )
		.append( pagerPanel );

// full panel
	panel = $( "<div>" )
		.addClass( "panel panel-default" )
		.append( [panelHead, panelBody, panelFoot] );

return panel;
}

function checkRole()
{
    return $.ajax({
        type: "GET",
        url: "include/check_role.php",
        async: false
    }).responseText;
}


function createTable_computers( results )
{
	var role = checkRole();

	headers = ["Property Tag", "Serial Number", "Make & Model", "Purchase Date", "Location", "Department", "Users"];
	$( '#main_content' ).html( createTable( role, headers ) );

	var tableRows = new Array();

	$.each( results, function(){
		row = "";
		row += "<tr class='parent_row'>";
		row += "<td class='select' rowspan='2'><i class='fa fa-square-o'></i></td>";
	
		if ( role > 1 )
			row += "<td class='edit' rowspan='2'><i class='fa fa-cog'></i></td>";

		if ( role > 2 )
			row += "<td class='trash' rowspan='2'><i class='fa fa-trash-o'></i></td>";

		row += "<td>" + this.tag + "</td>";
		row += "<td>" + this.serial + "</td>";
		row += "<td>" + this.makemodel + "</td>";
		row += "<td>" + this.purchase_date + "</td>";
		row += "<td>" + this.location + "</td>";
		row += "<td>" + this.department + "</td><td>";

		if ( this.users )
		{
			$.each( this.users, function( i ){
				row += this.firstname + " " + this.lastname;
				if ( this.count >= i )
					row += ", ";
			});
		}
		row += "</td></tr><tr class='tablesorter-childRow'><td colspan='10'>";
		row += '<div class="panel panel-default panel-body"><div class="row"><div class="col-xs-3">';

		row += '<b>Purchase Order:&nbsp;&nbsp;</b>';
		if ( this.purchase_order )
			row += this.purchase_order;

		row += '<br><b>Purchased By:&nbsp;&nbsp;</b>';
		if ( this.purchased_by )
			row += this.purchased_by;

		row += '</div><div class="col-xs-3">';

		row += '<b>Hostname:&nbsp;&nbsp;</b>';
		if ( this.hostname )
			row += this.hostname;

		row += '<br><b>OS:&nbsp;&nbsp;</b>';
		if ( this.os )
			row += this.os;

		row += '<br><b>Printer:&nbsp;&nbsp;</b>';
		if ( this.eq_printer )
			row += this.eq_printer;

		row += '</div>';

		if ( role > 1 )
		{
			row += '<div class="col-xs-3">';

			row += '<b>MAC:&nbsp;&nbsp;</b>';
			if ( this.mac )
				row += this.mac;

			row += '<br><b>WMAC:&nbsp;&nbsp;</b>';
			if ( this.wmac )
				row += this.wmac;

			row += '<br><b>IP:&nbsp;&nbsp;</b>';
			if ( this.ip )		
				row += this.ip;
			
			row += '</div>';
		}

		row += '<div class="col-xs-3">';
		row += '<b>Software:</b><br>';

		if ( this.software )
		{
			$.each( this.software, function( i ){
				row += this.software_name;
				if ( this.count >= i )
					row += "<br>";
			});
		}

		row += '</div></div>';

		if ( this.eq_notes )
			row += '<hr><div class="row"><div class="col-xs-12"><b>Notes:&nbsp;&nbsp;</b>' + this.eq_notes + '</div></div>';

		row += '</div></td></tr>';

		tableRows.push( row );		

	});
		
	$( '#results_table>tbody' ).html( tableRows.join( "" ) );

	ignoreHeaders = {
			0: { sorter: false } };

	if ( role > 1 )
		ignoreHeaders += { 1: { sorter: false } };

	if ( role > 2 )
		ignoreHeaders += { 2: { sorter: false } };

	setupTablesorter( ignoreHeaders );
}



function setupTablesorter( ignoreHeaders )
{
	$( '.parent_row>td' ).not('.select,.trash,.edit').on( 'click', function(){
		$( this ).closest( 'tr' ).nextUntil( 'tr.tablesorter-hasChildRow' ).find( 'td' ).toggle();
	});

	$( '.select').on( 'click', function(){
		$(this).children('i').toggleClass( 'fa-check-square-o fa-square-o');
	});

	$( '#select_all').on( 'click', function(){
		$(this).toggleClass( 'checked unchecked');

		if ( $(this).hasClass( 'checked' ) )
		{
			$('.parent_row:visible').find('.select > i')
				.removeClass('fa-square-o')
				.addClass('fa-check-square-o');

			$('#select_all>div').html( '<i class="fa fa-check-square-o"></i>');

		}
		else if ( $(this).hasClass( 'unchecked' ) )
		{
			$('.parent_row:visible').find('.select > i')
				.removeClass('fa-check-square-o')
				.addClass('fa-square-o');

			$('#select_all>div').html( '<i class="fa fa-square-o"></i>');
		}
	});

	var options = {
		widthFixed : true,
		cssChildRow : 'tablesorter-childRow',
		headerTemplate : '{content} {icon}',
		widgets: [ 'filter' ],
		widgetOptions: {
			filter_external : '.search',
			filter_childRows : true,
			filter_columnFilters : false,
			filter_ssFilter : 'tablesorter-filter'
		}
	};

	options.headers = ignoreHeaders;

	var pagerOptions = {
		container: $(".pager"),
		page: 0,
		size: 20,
		output: '[ Results: {filteredRows} ][ Showing Results {startRow} to {endRow} ]',
    cssPageDisplay: '.pagedisplay',
    cssPageSize: '.pagesize',
		cssNext: '.next',
    cssPrev: '.prev',
    cssFirst: '.first',
    cssLast: '.last'



	};

	$('#results_table').tablesorter( options )
		.tablesorterPager(pagerOptions)
		.bind( 'sortStart', function(){
			$(this).trigger('pageSet', 0 );
		});

	$('.tablesorter-childRow td').hide();

	$( '.search' ).on( 'keyup', function(){
		$( '.tablesorter-childRow td' ).hide();
	});



}





function list_labs()
{
	//$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_labs.php",
		success: function( result ) {
			$( '#main_content' ).html( result );
			//$('#processingModal').modal('toggle');
		}
	});
}

function list_printers()
{
	//$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_printers.php",
		success: function( result ) {
			$( '#main_content' ).html( result );
			//$('#processingModal').modal('toggle');
		}
	});
}

function list_users()
{
	//$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_users.php",
		success: function( result ) {
			$( '#main_content' ).html( result );
			//$('#processingModal').modal('toggle');
		}
	});
}

function list_purchases()
{
	//$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_purchases.php",
		success: function( result ) {
			$( '#main_content' ).html( result );
			//$('#processingModal').modal('toggle');
		}
	});
}

function list_software()
{
	//$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_software.php",
		success: function( result ) {
			$( '#main_content' ).html( result );
			//$('#processingModal').modal('toggle');
		}
	});
}


