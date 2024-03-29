<!-- Add Software Modal -->
<div class="modal" id="addSoftwareModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Software Record</h4> <small>(Items with * are optional)</small>
			</div>

			<div class="modal-body">
				<ul class="nav nav-pills" id="addSwRecordTab">
					<li id="swSoftwaretab" class="active"><a href="#swSoftwareInfo" data-toggle="tab">Software</a></li>
					<li id="swPurchasetab"><a href="#swPurchaseInfo" data-toggle="tab">Purchase</a></li>
					<li id="swOthertab"><a href="#swOtherInfo" data-toggle="tab">Other</a></li>
				</ul>
				<br>
				<div class="tab-content">
					<div class="tab-pane active" id="swSoftwareInfo">
						<?php include "newSwSoftwareForm.php"; ?>
					</div>
					<div class="tab-pane" id="swPurchaseInfo">
						<?php include "newSwPurchaseForm.php"; ?>
					</div>
					<div class="tab-pane" id="swOtherInfo">
						<?php include "newSwOtherForm.php"; ?>
					</div>
				</div>

			</div>

			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
				<button id="submitsoftware" type="button" class="btn btn-primary">Submit</button>
			</div>

		</div>
	</div>
</div>

<script>
$( '#addSoftwareModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#swPurchaseForm' )[0].reset();
    $( this ).find( '#addSoftwareForm' )[0].reset();
    $( this ).find( '#swOtherForm' )[0].reset();

	// reset all hidden forms
	$( this ).find( '.form-group' ).not( '#softwarename_input, #licensenum_input, #licensetype_input, #numberoflicenses_input, #swPurchaseorder_input, #swNotes_input' ).add( '#swNewPurchase' ).hide();

	// reset notes
	$( '#swNotes' ).empty();

	// reset texts displayed in menus
	$( '#licensetype' ).text( "Choose Type" );
	$( '#swPurchasetype' ).text( "Choose Purchase Order" );
	$( '#swPurchasertype' ).text( "Choose Purchaser" );

	// remove all error styles
	$( this ).find( '.has-error' ).removeClass( 'has-error' );
	$( this ).find( '.btn-danger' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	$( '#addSwRecordTab>li>a' ).removeAttr( 'style' );

	// reset active tab to equipmenttab
	$( '#addSwRecordTab a:first' ).tab( 'show' );

	// enable all inputs
	$( this ).find( 'input' ).attr( 'disabled', false );

	$( '#swPurchasemenu>li' ).removeClass( 'selectedpurchaser' );

	// enable all dropdowns
	$( this ).find( 'button' ).attr( 'data-toggle', 'dropdown').removeClass( 'active' );

	// reset modal-title
	$( this ).find( '.modal-title' ).text( "Add Software Record" );
});


$( '#submitsoftware' ).on( 'click', function() {

// prepare inputs from menus

// software tab

	// software name
	if ( $( '#software_name' ).val() == "" )
	{
		$( '#softwarename_error' ).show().children().html( "Software name required!" );
		$( '#softwarename_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#softwarename_error' ).hide();
		$( '#softwarename_input' ).removeClass( 'has-error' );

		// set variable
		var software_name = $( '#software_name' ).val();
	}

	// license number
	if ( $( '#license_num' ).val() == "" )
	{
		$( '#licensenum_error' ).show().children().html( "License number required!" );
		$( '#licensenum_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#licensenum_error' ).hide();
		$( '#licensenum_input' ).removeClass( 'has-error' );

		// set variable
		var license_num = $( '#license_num' ).val();
	}

	// license type
	if ( $( '#licensetype' ).text() == "Choose Type" )
	{
		$( '#licensetype_error' ).show().children().html( "License type required!" );
		$( '#licensetype_input' ).addClass( 'has-error' );
		$( '#licensetypebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else
	{
		$( '#licensetype_error' ).hide();
		$( '#licensetype_input' ).removeClass( 'has-error' );
		$( '#licensetypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// set variable
		var license_type = $( '#licensetype' ).text();
	}

	// number of licenses

	var numberPattern = /^([1-9]|[1-9][0-9]|[1-9][0-9][0-9]|1000)$/

	if ( $( '#number_of_licenses' ).val() == "" )
	{
		$( '#numberoflicenses_error' ).show().children().html( "Number of licenses required!" );
		$( '#numberoflicenses_input' ).addClass( 'has-error' );
	}

	else if ( !$( '#number_of_licenses' ).val().match( numberPattern ) )
	{
		$( '#numberoflicenses_error' ).show().children().html( "Valid number required!" );
		$( '#numberoflicenses_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#numberoflicenses_error' ).hide();
		$( '#numberoflicenses_input' ).removeClass( 'has-error' );

		// set variable
		var number_of_licenses = $( '#number_of_licenses' ).val();
	}
	

// purchase tab

	// purchase order
	if ( $( '#swPurchasetype' ).text() == "Choose Purchase Order" )
	{
		$( '#swPurchaseorder_error' ).show().children().html( "Purchase order required!" );
		$( '#swPurchasedby_error, #swPurchasedate_error' ).hide();
		$( '#swPurchaseorder_input' ).addClass( 'has-error' );
		$( '#swPurchaseorderbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else
	{
		$( '#swPurchaseorder_error' ).hide();
		$( '#swPurchaseorder_input' ).removeClass( 'has-error' );
		$( '#swPurchaseorderbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#swPurchasetype' ).text() == "New Purchase Order" )
		{
			if ( $( '#swNewPurchase' ).val() != "" )
			{		
				var purchase_order = $( '#swNewPurchase' ).val();
			}
		}

		else
			var purchase_id = $( '#swPurchasemenu' ).find( '.selectedpurchaser' ).children( '.swpid' ).text();

		// purchase date
		if ( $( '#swPurchasedate' ).val() == "" )
		{
			$( '#swPurchasedate_error' ).show().children().html( "Purchase date is required!" );
			$( '#swPurchasedate_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#swPurchasedate_error' ).hide();
			$( '#swPurchasedate_input' ).removeClass( 'has-error' );

			// set variable
			var purchase_date = $( '#swPurchasedate' ).val();
		}

		// purchased by
		if ( $( '#swPurchasertype' ).text() == "Choose Purchaser" )
		{
			$( '#swPurchasedby_error' ).show().children().html( "Purchaser is required!" );
			$( '#swPurchasedby_input' ).addClass( 'has-error' );
			$( '#swPurchaserbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#swPurchasertype' ).text() == "Other" )
		{
			$( '#swPurchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			if ( $( '#swNewPurchaser' ).val() == "" )
			{
				$( '#swPurchasedby_input' ).addClass( 'has-error' );
				$( '#swPurchasedby_error' ).show().children().html( "Purchaser is required!" );
			}

			else
			{
				$( '#swPurchasedby_error' ).hide();
				$( 'swPurchasedby_input' ).removeClass( 'has-error' );

				// set variable
				var purchased_by = $( '#swNewPurchaser' ).val();
			}
		}

		else
		{
			$( '#swPurchasedby_error' ).hide();
			$( '#swPurchasedby_input' ).removeClass( 'has-error' );
			$( '#swPurchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			// set variable
			var purchased_by = $( '#swPurchasertype' ).text();
		}	
	}	


// set tab color on error
	if ( $( '#addSoftwareForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#swSoftwaretab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#swSoftwaretab>a' ).removeAttr( 'style' );

	if ( $( '#swPurchaseForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#swPurchasetab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#swPurchasetab>a' ).removeAttr( 'style' );

	// check if any errors exist
	if ( !$( '#addSoftwareModal' ).find( '.form-group' ).hasClass( 'has-error' ) )
	{
		// set all other variables
		if ( $( '#swNotes' ).val() != "" )
		var notes = $( '#swNotes' ).val();

		if ( $( '#swPurchasetype' ).text() == "New Purchase Order" )
		{
			var new_purchase = { "purchase_order" : purchase_order,
									"purchase_date" : purchase_date,
									"purchased_by" : purchased_by };

		}

		if ( $( '#addSoftwareModal' ).find( 'h4' ).text() == 'Edit Software Record' )
			var operationtype = "update";

		else
			var operationtype = "insert";

		if ( $( '#software_id' ).val() != "" )
			var software_id = $( '#software_id' ).val();

		// collect input-data into json
		var input = { "software_id" : software_id,
						"software_name" : software_name,
						"license_num" : license_num,
						"license_type" : license_type,
						"number_of_licenses" : number_of_licenses,
						"purchase_id" : purchase_id,
						"new_purchase" : new_purchase,
						"notes" : notes,
						"operation" : operationtype };

		console.log( input );

		user_input = JSON.stringify( input );

		$.ajax({
			type: "POST",
			url: "include/add_software.php",
			data: { data : user_input },
			success: function( result ){
				if ( result.charAt( 0 ) == "<" )
					window.location.reload();

				else
				{
					// update table
					var results = $.parseJSON( result );
					alert( results.message );
					returnToQuery( results.query, results.querytype );

					$( '#addSoftwareModal' ).modal( 'hide' );
				}
			},
			error: function(){
				alert( "There was a problem in the database!" );
			}
		});
	}
});

</script>
