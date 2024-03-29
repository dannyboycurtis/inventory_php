<!-- Add Equipment Modal -->
<div class="modal" id="addEquipmentModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Add Equipment Record</h4> <small>(Items with * are optional)</small>
			</div>

			<div class="modal-body">
				<ul class="nav nav-pills" id="addEqRecordTab">
					<li id="equipmenttab" class="active"><a href="#equipmentInfo" data-toggle="tab">Equipment</a></li>
					<li id="eqPurchasetab"><a href="#purchaseInfo" data-toggle="tab">Purchase</a></li>
					<li id="locationtab"><a href="#locationInfo" data-toggle="tab">Location</a></li>
					<li id="usertab"><a href="#userInfo" data-toggle="tab">Users</a></li>
					<li id="eqSoftwaretab"><a href="#softwareInfo" data-toggle="tab">Software</a></li>
					<li id="networktab"><a href="#netInfo" data-toggle="tab">Network</a></li>
					<li id="eqOthertab"><a href="#otherInfo" data-toggle="tab">Other</a></li>
				</ul>
				<br>
				<div class="tab-content">
					<div class="tab-pane active" id="equipmentInfo">
						<?php include "newEquipmentForm.php"; ?>
					</div>
					<div class="tab-pane" id="purchaseInfo">
						<?php include "newPurchaseForm.php"; ?>
					</div>
					<div class="tab-pane" id="locationInfo">
						<?php include "newLocationForm.php"; ?>
					</div>
					<div class="tab-pane" id="userInfo">
						<?php include "newUserForm.php"; ?>
					</div>
					<div class="tab-pane" id="softwareInfo">
						<?php include "newEqSoftwareForm.php"; ?>
					</div>
					<div class="tab-pane" id="netInfo">
						<?php include "newNetworkForm.php"; ?>
					</div>
					<div class="tab-pane" id="otherInfo">
						<?php include "newOtherForm.php"; ?>
					</div>
				</div>
			</div>

			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
				<button id="submitequipment" type="button" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
</div>

<script>
// this resets form data in the modal on closing
$( '#addEquipmentModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#equipmentForm' )[0].reset();
    $( this ).find( '#purchaseForm' )[0].reset();
	$( this ).find( '#locationForm' )[0].reset();
    $( this ).find( '#userForm' )[0].reset();
    $( this ).find( '#networkForm' )[0].reset();
    $( this ).find( '#softwareForm' )[0].reset();
    $( this ).find( '#otherForm' )[0].reset();

	// reset all hidden forms
	$( this ).find( '.form-group' ).not( '#tag_input, #serial_input, #makemodel_input, #eqtype_input, #purchaseorder_input, #department_input, #location_input, #softwarenotavailable, #usersnotavailable, #mac_input, #ip_input, #wmac_input, #notes_input' ).add( '#newPurchase, #newMake, #newModel' ).hide();

	// reset user and software lists
	$( '#userlist, #softwarelist' ).empty();

	// reset notes
	$( '#notes' ).empty();

	// reset texts displayed in menus
	$( '#maketype' ).text( "Choose Make" );
	$( '#modeltype' ).text( "Choose Model" );
	$( '#eqtype' ).text( "Choose Type" );
	$( '#usertype' ).text( "Choose Type" );
	$( '#ostype' ).text( "Choose OS" );
	$( '#purchasetype' ).text( "Choose Purchase Order" );
	$( '#purchasertype' ).text( "Choose Purchaser" );
	$( '#departmenttype' ).text( "Choose Department" );
	$( '#locationtype' ).text( "Choose Location" );
	$( '#buildingtype' ).text( "Choose Building" );

	// remove all error styles
	$( this ).find( '.has-error' ).removeClass( 'has-error' );
	$( this ).find( '.btn-danger' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	$( '#addEqRecordTab>li>a' ).removeAttr( 'style' );

	// reset active tab to equipmenttab
	$( '#addEqRecordTab a:first' ).tab( 'show' );

	// enable all inputs
	$( this ).find( 'input' ).attr( 'disabled', false );

	$( '#purchasemenu>li' ).removeClass( 'selectedpurchaser' );

	// enable all dropdowns
	$( this ).find( 'button' ).attr( 'data-toggle', 'dropdown').removeClass( 'active' );

	// reset modal-title
	$( this ).find( '.modal-title' ).text( "Add Equipment Record" );
});

$( '#submitequipment' ).on( 'click', function() {

// prepare inputs from menus

// equipment tab

	if ( $( '#addEquipmentModal' ).find( 'h4' ).text() == "Add Equipment Record" )
	{
		// set operation type
		var operationtype = "insert";

		// tag num	
		if ( $( '#tag_num' ).val() == "" )
		{
			$( '#tag_error' ).show().children().html( "Property tag number is required!" );
			$( '#tag_input' ).addClass( 'has-error' );
		}

		else
		{
			$.ajax({
				type: "POST",
				url: "include/check_tag.php",
				data: { tag : $( '#tag_num' ).val() },
				async: false,
				success: function( result ) {
					if ( result.charAt( 0 ) == "<" )
						window.location.reload();

					else
					{
						if ( result == "0" )
						{
							$( '#tag_error' ).show().children().html( "This property tag is already in use!" );
							$( '#tag_input' ).addClass( 'has-error' );
						}

						else
						{
							$( '#tag_error' ).hide();
							$( '#tag_input' ).removeClass( 'has-error' );
						}
					}
				}
			});

			if ( !$( '#tag_input' ).hasClass( 'has-error' ) )
			{
				// set variable
				var tag_num = $( '#tag_num' ).val();
			}
		}
	}

	else
	{
		// set operationtype for edit
		var operationtype = "update";

		// set variable
		var tag_num = $( '#tag_num' ).val();
	}

	// serial
	if ( $( '#serial' ).val() == "" )
	{
		$( '#serial_error' ).show().children().html( "Serial number is required!" );
		$( '#serial_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#serial_error' ).hide();
		$( '#serial_input' ).removeClass( 'has-error' );

		// set variable
		var serial = $( '#serial' ).val();
	}

	// make and model
	if ( $( '#maketype' ).text() == "Choose Make" && $( '#modeltype' ).text() == "Choose Model" )
	{
		$( '#makemodel_error' ).show().children().html( "Make and model are required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton, #modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#modeltype' ).text() == "Choose Model" )
	{
		$( '#makemodel_error' ).show().children().html( "Model is required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		$( '#modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( ( $( '#maketype' ).text() == "Other " && $( '#newMake' ).val() == "" ) && ( $( '#modeltype' ).text() == "Other " && $( '#newModel' ).val() == "" ) )
	{
		$( '#makemodel_error' ).show().children().html( "Make and model are required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton, #modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#maketype' ).text() == "Other" && $( '#newMake' ).val() == "" )
	{
		$( '#makemodel_error' ).show().children().html( "Make is required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#modeltype' ).text() == "Other" && $( '#newModel' ).val() == "" )
	{
		$( '#makemodel_error' ).show().children().html( "Model is required!" );	
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else
	{
		$( '#makemodel_error' ).hide();
		$( '#makemodel_input' ).removeClass( 'has-error' );
		$( '#makebutton, #modelbutton' ).removeClass( 'btn-danger' ).addClass( 'btn-default' );

		// set variables
		if ( $( '#maketype' ).text() == "Other" )
			var make = $( '#newMake' ).val();

		else
			var make = $( '#maketype' ).text();

		if ( $( '#modeltype' ).text() == "Other" )
			var model = $( '#newModel' ).val();

		else
			var model = $( '#modeltype' ).text();

	}

	// eq type
	if ( $( '#eqtype' ).text() == "Choose Type" )
	{
		$( '#eqtype_error' ).show().children().html( "Equipment type is required!" );
		$( '#eqtype_input' ).addClass( 'has-error' );
		$( '#eqtypebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#eqtype' ).text() == "Computer or Tablet" )
	{
		// set variable
		var eqtype = "computer";

		if ( $( '#eq_printer' ).val() )
			var printer = $( '#eq_printer').val();

		$( '#eqtype_error, #description_error' ).hide();
		$( '#eqtype_input' ).removeClass( 'has-error' );
		$( '#eqtypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// hostname
		if ( $( '#hostname' ).val() != "" )
			var hostname = $( '#hostname' ).val();

		// os
		if ( $( '#ostype' ).text() == "Choose OS" )
		{
			$( '#os_error' ).show().children().html( "OS is required!" );
			$( '#os_input' ).addClass( 'has-error' );
			$( '#osbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#ostype' ).text() == "New Operating System" && $( '#otheros' ).val() == "" )
		{
			$( '#os_error' ).show().children().html( "OS is required!" );
			$( '#otheros_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#os_input, #otheros_input' ).removeClass( 'has-error' );
			$( '#osbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			// set variable
			if ( $( '#ostype' ).text() == "New Operating System" )
				var os = $( '#otheros' ).val();


			else
				var os = $( '#ostype' ).text();
		}
	}

	else if ( $( '#eqtype' ).text() == "Network Printer" )
	{
		// set variable
		var eqtype = "printer";

		$( '#eqtype_error, #description_error, #os_error' ).hide();
		$( '#eqtype_input' ).removeClass( 'has-error' );
		$( '#eqtypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// hostname
		if ( $( '#hostname' ).val() == "" )
		{
			$( '#hostname_error' ).show().children().html( "Hostname is required!" );
			$( '#hostname_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#hostname_error' ).hide();
			$( '#hostname_input' ).removeClass( 'has-error' );

			// set variables
			var hostname = $( '#hostname' ).val();
		}
	}

	else if ( $( '#eqtype' ).text() == "Other Equipment" )
	{
		// set variable
		var eqtype = "other";

		$( '#eqtype_error, #hostname_error, #os_error' ).hide();
		$( '#eqtype_input' ).removeClass( 'has-error' );
		$( '#eqtypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// description
		if ( $( '#description' ).val() == "" )
		{
			$( '#description_error' ).show().children().html( "Description is required!" );
			$( '#description_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#description_error' ).hide();
			$( '#description_input' ).removeClass( 'has-error' );
			$( '#eqtypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			// set variables
			var description = $( '#description' ).val();
		}
	}

	else
	{
		$( '#eqtype_error, #description_error, #hostname_error, #os_error' ).hide();
		$( '#eqtype_input' ).removeClass( 'has-error' );
	}

	

// purchase tab

	// purchase order
	if ( $( '#purchasetype' ).text() == "Choose Purchase Order" )
	{
		$( '#purchaseorder_error' ).show().children().html( "Purchase order required!" );
		$( '#purchasedby_error, #purchasedate_error' ).hide();
		$( '#purchaseorder_input' ).addClass( 'has-error' );
		$( '#purchaseorderbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else
	{
		$( '#purchaseorder_error' ).hide();
		$( '#purchaseorder_input' ).removeClass( 'has-error' );
		$( '#purchaseorderbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#purchasetype' ).text() == "New Purchase Order" )
		{
			if ( $( '#newPurchase' ).val() != "" )
				var purchase_order = $( '#newPurchase' ).val();
		}

		else
			var purchase_id = $( '#eqPurchaseId' ).val();

		// purchase date
		if ( $( '#purchasedate' ).val() == "" )
		{
			$( '#purchasedate_error' ).show().children().html( "Purchase date is required!" );
			$( '#purchasedate_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#purchasedate_error' ).hide();
			$( '#purchasedate_input' ).removeClass( 'has-error' );

			// set variable
			var purchase_date = $( '#purchasedate' ).val();
		}

		// purchased by
		if ( $( '#purchasertype' ).text() == "Choose Purchaser" )
		{
			$( '#purchasedby_error' ).show().children().html( "Purchaser is required!" );
			$( '#purchasedby_input' ).addClass( 'has-error' );
			$( '#purchaserbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#purchasertype' ).text() == "Other" )
		{
			$( '#purchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			if ( $( '#newPurchaser' ).val() == "" )
			{
				$( '#purchasedby_input' ).addClass( 'has-error' );
				$( '#purchasedby_error' ).show().children().html( "Purchaser is required!" );
			}

			else
			{
				$( '#purchasedby_error' ).hide();
				$( 'purchasedby_input' ).removeClass( 'has-error' );

				// set variable
				var purchased_by = $( '#newPurchaser' ).val();
			}
		}

		else
		{
			$( '#purchasedby_error' ).hide();
			$( '#purchasedby_input' ).removeClass( 'has-error' );
			$( '#purchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			// set variable
			var purchased_by = $( '#purchasertype' ).text();
		}	
	}	

	
// location tab

	// department
	if ( $( '#departmenttype' ).text() == "Choose Department" )
	{
		$( '#department_error' ).show().children().html( "Department is required!" );
		$( '#department_input' ).addClass( 'has-error' );
		$( '#departmentbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#departmenttype' ).text() == "Other" )
	{
		$( '#department_error' ).hide();
		$( '#department_input' ).removeClass( 'has-error' );
		$( '#departmentbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#otherdepartment' ).val() == "" )
		{
			$( '#otherdepartment_error' ).show().children().html( "Department is required!" );
			$( '#otherdepartment_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#otherdepartment_error' ).hide();
			$( '#otherdepartment_input' ).removeClass( 'has-error' );

			// set variable
			var department = $( '#otherdepartment' ).val();
		}
	}

	else
	{
		$( '#department_error, #otherdepartment_error' ).hide();
		$( '#department_input, #otherdepartment_input' ).removeClass( 'has-error' );
		$( '#departmentbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// set variable
		var department = $( '#departmenttype' ).text();
	}

	// location
	if ( $( '#locationtype' ).text() == "Choose Location" )
	{
		$( '#location_error' ).show().children().html( "Location is required!" );
		$( '#location_input' ).addClass( 'has-error' );
		$( '#locationbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#locationtype' ).text() == "On Campus" )
	{
		// set variable
		var location = "on";

		$( '#location_error' ).hide();
		$( '#location_input' ).removeClass( 'has-error' );
		$( '#locationbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#buildingtype' ).text() == "Choose Building" )
		{
			$( '#building_error' ).show().children().html( "Building is required!" );
			$( '#building_input' ).addClass( 'has-error' );
			$( '#buildingbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#buildingtype' ).text() == "Other" && $( '#otherbuilding' ).val() == "" )
		{
			$( '#building_error' ).hide();
			$( '#building_input' ).removeClass( 'has-error' );
			$( '#buildingbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
			$( '#otherbuilding_error' ).show().children().html( "Building is required!" );
			$( '#otherbuilding_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#building_error, #otherbuilding_error' ).hide();
			$( '#building_input, #otherbuilding_input' ).removeClass( 'has-error' );
			$( '#buildingbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			// set variable
			if ( $( '#buildingtype' ).text() == "Other" )
				var building = $( '#otherbuilding' ).val().toUpperCase();

			else
				var building = $( '#buildingtype' ).text();
		}

		if ( $( '#room_num' ).val() == "" )
		{
			$( '#room_num_error' ).show().children().html( "Room number is required!" );
			$( '#room_num_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#room_num_error' ).hide();
			$( '#room_num_input' ).removeClass( 'has-error' );

			// set variable
			var room_num = $( '#room_num' ).val();
		}
	}

	else
	{
		// set variable
		var location = "off";

		$( '#location_error, #building_error, #otherbuilding_error, #room_num_error' ).hide();
		$( '#location_input, #building_input, #otherbuilding_input, #room_num_input' ).removeClass( 'has-error' );
		$( '#locationbutton, #buildingbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	}

// network tab
var macPattern = /^[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}:[0-9A-F]{2}$/;

// mac address
if ( $( '#mac' ).val() != "" )
{
	if ( !$( '#mac' ).val().toUpperCase().match( macPattern ) )
	{
		$( '#mac_error' ).show().children().html( 'Invalid characters in MAC address!' );
		$( '#mac_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#mac_error' ).hide();
		$( '#mac_input' ).removeClass( 'has-error' );

		// set variable
		var mac = $( '#mac' ).val().toUpperCase();
	}

}

else
{
	$( '#mac_error' ).hide();
	$( '#mac_input' ).removeClass( 'has-error' );

}

// wmac address
if ( $( '#wmac' ).val() != "" )
{
	if ( !$( '#wmac' ).val().toUpperCase().match( macPattern ) )
	{
		$( '#wmac_error' ).show().children().html( 'Invalid characters in wireless MAC address!' );
		$( '#wmac_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#wmac_error' ).hide();
		$( '#wmac_input' ).removeClass( 'has-error' );

		// set variable
		var wmac = $( '#wmac' ).val().toUpperCase();
	}
}

else
{
	$( '#wmac_error' ).hide();
	$( '#wmac_input' ).removeClass( 'has-error' );

}

var ipPattern = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;

// wmac address
if ( $( '#ip' ).val() != "" )
{
	if ( !$( '#ip' ).val().match( ipPattern ) )
	{
		$( '#ip_error' ).show().children().html( 'Invalid IP Address!' );
		$( '#ip_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#ip_error' ).hide();
		$( '#ip_input' ).removeClass( 'has-error' );

		// set variable
		var ip = $( '#ip' ).val();
	}

}

else
{
	$( '#ip_error' ).hide();
	$( '#ip_input' ).removeClass( 'has-error' );
}


// users tab 
	if ( eqtype == "computer" || eqtype == "other" )
	{
		// User type
		if ( $( '#usertype' ).text() == "Choose Type" )
		{
			$( '#selectusertype_error' ).show().children().html( "User type required!" );
			$( '#selectusertype_input' ).addClass( 'has-error' );
			$( '#usertypebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#usertype' ).text() == "Faculty/Staff" )
		{
			// set variables
			var users = new Array();
			$( '#userlist>li' ).each( function(){
				var user = $( this ).children( '.user_id' ).text();
				users.push( user );
			});

			$( '#selectusertype_error, #selectlab_error, #newlab_error' ).hide();
			$( '#selectusertype_input' ).removeClass( 'has-error' );
			$( '#usertypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
			
			if ( $( '#newuserfname:visible' ).val() == "" )
			{
				$( '#newuser_error' ).show().children().html( "First name required!" );
				$( '#newuser_input' ).addClass( 'has-error' );
			}

			else if ( $( '#newuserlname:visible' ).val() == "" )
			{
				$( '#newuser_error' ).show().children().html( "Last name required!" );
				$( '#newuser_input' ).addClass( 'has-error' );
			}

			else if ( $( '#userlist' ).html() == "" )
			{
				$( '#newuser_error' ).show().children().html( "User required!" );
				$( '#selectusers_input' ).addClass( 'has-error' );
				$( '#selectusersbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
			}

			else
			{
				$( '#newuser_error' ).hide();
				$( '#newuser_input' ).removeClass( 'has-error' );
				$( '#selectusers_input' ).removeClass( 'has-error' );
				$( '#selectusersbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

				// set variables
				var fname = $( '#newuserfname:visible' ).val();
				var lname = $( '#newuserlname:visible' ).val();

				if ( $( '#newuseremail:visible' ).val() != "" )
					var email = $( '#newuseremail:visible' ).val();

				if ( $( '#newuserphone:visible' ).val() != "" )
					var phone = $( '#newuserphone:visible' ).val();

				if ( fname && lname )
				var new_user = { "f_name" : fname, "l_name" : lname, "email" : email, "phone" : phone };

			}
		}

		else if ( $( '#usertype' ).text() == "Lab Workstation" )
		{
			$( '#selectusertype_error' ).hide();
			$( '#selectusertype_input' ).removeClass( 'has-error' );
			$( '#usertypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			$( '#userlist' ).empty();	

			if ( $( "#labtype" ).text() == "Choose Lab" )
			{
				$( "#selectlab_error" ).show().children().html( "Lab type required!" );
				$( "#selectlab_input" ).addClass( 'has-error' );
				$( "#selectlabbutton" ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
			}

			else if ( $( "#labtype" ).text() == "Other" )
			{
				$( "#selectlab_error" ).hide();
				$( "#selectlab_input" ).removeClass( 'has-error' );
				$( "#selectlabbutton" ).addClass( 'btn-default' ).removeClass( 'btn-danger' );				

				if ( $( "#newlabname" ).val() == "" )
				{
					$( "#newlab_error" ).show().children().html( "Lab name required!" );
					$( "#newlab_input" ).addClass( 'has-error' );
				}

				else
				{
					$( "#newlab_error" ).hide();
					$( "#newlab_input" ).removeClass( 'has-error' );

					// set variable
					var lab_name = $( "#newlabname" ).val();
				}
			}

			else
			{
				$( "#selectlab_error" ).hide();
				$( "#selectlab_input" ).removeClass( 'has-error' );
				$( "#selectlabbutton" ).addClass( 'btn-default' ).removeClass( 'btn-danger' );	

				// set variable
				var lab_id = $( "#labmenu>li.selectedlab" ).children( '.uid' ).text();
			}
		}

		else
		{
			$( '#selectusertype_error' ).hide();
			$( '#selectusertype_input' ).removeClass( 'has-error' );
			$( '#usertypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		}
	}

	else
	{
		$( '#selectusertyper_error, #newuser_error' ).hide();
		$( '#selectusertype_input, #newuser_input' ).removeClass( 'has-error' );
		$( '#usertypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	}

// set tab color on error
	if ( $( '#equipmentForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#equipmenttab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#equipmenttab>a' ).removeAttr( 'style' );

	if ( $( '#purchaseForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#eqPurchasetab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#eqPurchasetab>a' ).removeAttr( 'style' );

	if ( $( '#locationForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#locationtab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#locationtab>a' ).removeAttr( 'style' );

	if ( $( '#userForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#usertab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#usertab>a' ).removeAttr( 'style' );

	if ( $( '#networkForm' ).find( '.form-group' ).hasClass( 'has-error' ) )
		$( '#networktab>a').css({ "background-color" : "#c71c22", "border-color" : "#c71c22", "color" : "white"});

	else $( '#networktab>a' ).removeAttr( 'style' );

	// check if any errors exist
	if ( !$( '#addEquipmentModal' ).find( '.form-group' ).hasClass( 'has-error' ) )
	{
		// set all other variables
		if ( $( '#notes' ).val() != "" )
		var notes = $( '#notes' ).val();

		if ( eqtype == "computer" )
		{
			var software = new Array();
			$( '#softwarelist>li' ).each( function(){
				var sw = $( this ).children( '.software_id' ).text();
				software.push( sw );
			});
		}

		if ( $( '#purchasetype' ).text() == "New Purchase Order" )
		{
			var new_purchase = { "purchase_order" : purchase_order,
									"purchase_date" : purchase_date,
									"purchased_by" : purchased_by };

		}

		// collect input-data into json
		var input = { "tag_num" : tag_num,
							"serial" : serial,
							"make" : make,
							"model" : model,
							"eqtype" : eqtype,
							"hostname" : hostname,
							"os" : os,
							"description" : description,
							"printer" : printer,
							"purchase_id" : purchase_id,
							"new_purchase" : new_purchase,
							"department" : department,
							"location" : location,
							"building" : building,
							"room_num" : room_num,
							"mac" : mac,
							"ip" : ip,
							"wmac" : wmac,
							"users" : users,
							"new_user" : new_user,
							"lab_id" : lab_id,
							"lab_name" : lab_name,
							"software" : software,
							"notes" : notes,
							"operation" : operationtype };

		console.log( input );

		user_input = JSON.stringify( input );

		$.ajax({
			type: "POST",
			url: "include/add_equipment.php",
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

					$( '#addEquipmentModal' ).modal( 'hide' );
				}
			},
			error: function(){
				alert( "There was a problem in the database!" );
			}
		});
	}
});
</script>
