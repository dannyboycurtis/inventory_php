function get_list( type )
{
	url = "include/list_" + type + ".php";
	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: url,
		data: { type: type },
		success: function( result ) {
			$( '#main_content' ).html( result );
			$('#processingModal').modal('toggle');
		}
	});

}



function createSearchBar()
{
	searchbar = "<div id='searchbar' class='form-inline'>";
	searchbar += "<input class='form-control search pull-left' type='text' placeholder='Filter Results' data-column='all'>";
	searchbar += "<button class='btn btn-info pull-left' id='searchOptions_button' style='margin-left: 5px;'>";
	searchbar += "<span class='glyphicon glyphicon-search'></span>&nbsp; Options</button>";

	searchbar += "<button class='btn btn-info pull-right' id='printReport_button' style='margin-left: 5px;'>";
	searchbar += "<span class='glyphicon glyphicon-file'></span>&nbsp; Print Report</button>";


	pager = "<div id='pager' class='pager btn-group' style='margin:0;'><button class='btn first btn-info'><i class='fa fa-angle-double-left fa-lg'></i></button>";
	pager += "<button class='btn prev btn-info'><i class='fa fa-angle-left fa-lg'></i></button>";
	pager += "<div class='btn active pagedisplay btn-info'></div>";
	pager += "<button class='btn next btn-info'><i class='fa fa-angle-right fa-lg'></i></button>";
	pager += "<button class='btn last btn-info'><i class='fa fa-angle-double-right fa-lg'></i></button></div>";
	pager += "&nbsp;&nbsp<select class='pagesize'><option value='10'>10</option><option selected='selected' value='20'>20</option><option value='40'>40</option><option value='9999'>All</option></select></div></div>";

	searchbar += pager + "</div>";

	return searchbar;
}


function list_computers()
{
	$('#processingModal').modal('toggle');
	$.ajax({
		type: "POST",
		url: "include/list_computers.php",
		success: function( result ) {
			createTable_computers( $.parseJSON( result ) );
			$('#processingModal').modal('toggle');
		}
	});
}

function createTable_computers( results )
{
	table = "<div class='panel panel-default'><div class='panel-heading'>" + createSearchBar() + "</div><table id='custom_table' class='tablesorter'><thead><tr>";
	table += "<th scope='col'>Property Tag</th><th scope='col'>Serial Number</th>";
	table += "<th scope='col'>Make & Model</th><th scope='col'>Location</th>";
	table += "<th scope='col'>Department</th><th scope='col'>Users</th></tr></thead><tbody></tbody></table>";
	
	$('#main_content').html( table );

	row = "";
	$.each( results, function(){
		row += "<tr class='toggle'><td>" + this.tag;
		row += "</td><td>" + this.serial;
		row += "</td><td>" + this.makemodel;
		row += "</td><td>" + this.location;
		row += "</td><td>" + this.department + "</td><td>";

		$.each( this.users, function( i ){
			row += this.firstname + " " + this.lastname;
			if ( this.count >= i )
				row += ", ";
		});

		row += "</td></tr><tr class='tablesorter-childRow'><td colspan='10'>TO BE FILLED WITH EXTRA INFORMATION</td></tr>";
	});
		
	$( '#custom_table>tbody' ).append( row );

	$( '#custom_table>tbody>tr' ).not( '.tablesorter-childRow' ).addClass( 'parent_row' );

	$( '.parent_row' ).on( 'click', function(){
		$(this).closest('tr').nextUntil( 'tr.tablesorter-hasChildRow' ).find( 'td' ).toggle();
	});

	pager = "<div id='pager' class='pager pagination center-block panel-footer'>";
	pager += "<div class='btn-group'><button class='btn first btn-info'><i class='fa fa-angle-double-left fa-lg'></i></button>";
	pager += "<button class='btn prev btn-info'><i class='fa fa-angle-left fa-lg'></i></button>";
	pager += "<button class='btn active pagedisplay btn-info'></button>";
	pager += "<button class='btn next btn-info'><i class='fa fa-angle-right fa-lg'></i></button>";
	pager += "<button class='btn last btn-info'><i class='fa fa-angle-double-right fa-lg'></i></button></div>";
	pager += "&nbsp;&nbsp<select class='pagesize'><option value='10'>10</option><option selected='selected' value='20'>20</option><option value='40'>40</option><option value='9999'>All</option></select></div></div>";


	$( '#main_content').append( pager );


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

	var pagerOptions = {
		container: $(".pager"),
		page: 0,
		size: 20,
		output: 'Showing Results {startRow} to {endRow} of {filteredRows}',
    cssPageDisplay: '.pagedisplay',
    cssPageSize: '.pagesize',
		cssNext: '.next',
    cssPrev: '.prev',
    cssFirst: '.first',
    cssLast: '.last'



	};

	$('#custom_table').tablesorter( options )
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
