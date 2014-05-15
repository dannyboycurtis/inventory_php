<!-- Processing Modal -->
<div class="modal" id="processingModal" style="padding-top:200px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body text-center">
        <i class="fa fa-clock-o"></i> Processing...
      </div>

    </div>
  </div>
</div>


<!-- Search Modal -->
<div class="modal" id="searchModal" style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body text-center">
        Search
      </div>

    </div>
  </div>
</div>

<!-- Add Equipment Modal -->
<div class="modal" id="addEquipmentModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">


    <div class="modal-content">
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h4 class="modal-title">Add Equipment Record <small>(Items with * are optional)</small>
	</div>
      <div class="modal-body">
        <ul class="nav nav-pills" id="addRecordTab">
          <li class="active"><a href="#equipmentInfo" data-toggle="pill">Equipment </a></li>
		  <li><a href="#purchaseInfo" data-toggle="tab">Purchase </a></li>
		  <li><a href="#locationInfo" data-toggle="tab">Location </a></li>
          <li><a href="#netInfo" data-toggle="tab">Network </a></li>
          <li><a href="#userInfo" data-toggle="tab">Users </a></li>
          <li><a href="#softwareInfo" data-toggle="tab">Software </a></li>
          <li><a href="#otherInfo" data-toggle="tab">Other </a></li>
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
              <?php include "newSoftwareForm.php"; ?>
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
  $('#addEquipmentModal').on('hidden.bs.modal', function(){
    $(this).find('#equipmentForm')[0].reset();
    $(this).find('#purchaseForm')[0].reset();
	$(this).find('#locationForm')[0].reset();
    $(this).find('#userForm')[0].reset();
    $(this).find('#networkForm')[0].reset();
    $(this).find('#softwareForm')[0].reset();
    $(this).find('#otherForm')[0].reset();
    $('#addRecordTab a:first').tab('show');
    $('#description_input, #hostname_input, #os_input, #printer_input').hide();
	$( '#newPurchase, #newPurchaser' ).hide();
    $('#building_input, #room_num_input, #otherbuilding, #otherdepartment').hide();
    $('#purchased_by_input').hide();
	$( '#newMake, #newModel' ).hide();
	$( '#selectusertype_input, #selectusers, #newuser_input, #selectsoftware_input' ).hide();
	$( '#usersnotavailable, #softwarenotavailable' ).show();
	$( '#userlist, #softwarelist' ).empty();
	$( '#maketype' ).text( "Choose Make " );
	$( '#modeltype' ).text( "Choose Model " );
	$( '#eqtype' ).text( "Choose Type " );
	$( '#usertype' ).text( "Choose Type " );
	$( '#usermenu' ).text( "Choose Users " );
	$( '#ostype' ).text( "Choose OS " );
	$( '#purchasetype' ).text( "Choose Purchase Order " );
	$( '#purchasertype' ).text( "Choose Purchaser " );
	$( '#departmenttype' ).text( "Choose Department " );
	$( '#locationtype' ).text( "Choose Location " );
	$( '#buildingtype' ).text( "Choose Building " );
	$( '#softwaretype' ).text( "Choose Software " );
  });

$( '#submitequipment' ).on( 'click', function() {

// prepare inputs from menus

// equipment tab

	// tag num
	if ( $( '#tag_num' ).val() == "" )
	{
		$( '#tag_error' ).show().children().html( "Property tag number is required!" );
		$( '#tag_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#tag_error' ).hide();
		$( '#tag_input' ).removeClass( 'has-error' );
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
	}

	// make and model
	if ( $( '#maketype' ).text() == "Choose Make " && $( '#modeltype' ).text() == "Choose Model " )
	{
		$( '#makemodel_error' ).show().children().html( "Make and model are required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton, #modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#modeltype' ).text() == "Choose Model " )
	{
		$( '#makemodel_error' ).show().children().html( "Model is required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		$( '#modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( ( $( '#maketype' ).text() == "Other " && $( '#newMake' ).val() == "" )
				&& ( $( '#modeltype' ).text() == "Other " && $( '#newModel' ).val() == "" ) )
	{
		$( '#makemodel_error' ).show().children().html( "Make and model are required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton, #modelbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#maketype' ).text() == "Other " && $( '#newMake' ).val() == "" )
	{
		$( '#makemodel_error' ).show().children().html( "Make is required!" );
		$( '#makemodel_input' ).addClass( 'has-error' );
		$( '#makebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#modeltype' ).text() == "Other " && $( '#newModel' ).val() == "" )
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
	}

	// eq type
	if ( $( '#eqtype' ).text() == "Choose Type " )
	{
		$( '#eqtype_error' ).show().children().html( "Equipment type is required!" );
		$( 'eqtype_input' ).addClass( 'has-error' );
		$( '#eqtypebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#eqtype' ).text() == "Computer or Tablet " )
	{
		$( '#eqtype_error, #description_error' ).hide();
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
		}

		// os
		if ( $( '#ostype' ).text() == "Choose OS " )
		{
			$( '#os_error' ).show().children().html( "OS is required!" );
			$( '#os_input' ).addClass( 'has-error' );
			$( '#osbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#ostype' ).text() == "Other " && $( '#otheros' ).val() == "" )
		{
			$( '#os_error' ).show().children().html( "OS is required!" );
			$( '#otheros_input' ).addClass( 'has-error' );
		}

		else
		{
			$( '#os_input, #otheros_input' ).removeClass( 'has-error' );
			$( '#osbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
		}
	}

	else if ( $( '#eqtype' ).text() == "Network Printer " )
	{
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
		}

	}

	else if ( $( '#eqtype' ).text() == "Other Equipment " )
	{
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
		}
	}

	else
	{
		$( '#eqtype_error, #description_error, #hostname_error, #os_error' ).hide();
		$( '#eqtype_input' ).removeClass( 'has-error' );
	}

// purchase tab

	// purchase date
	if ( $( '#purchasedate' ).text() == "" )
	{
		$( '#purchasedate_error' ).show().children().html( "Purchase date is required!" );
		$( '#purchasedate_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#purchasedate_error' ).hide();
		$( '#purchasedate_input' ).removeClass( 'has-error' );
	}

	// purchased by
	if ( $( '#purchasertype' ).text() == "Choose Purchaser" )
	{
		$( '#purchasedby_error' ).show().children().html( "Purchaser is required!" );
		$( '#purchasedby_input' ).addClass( 'has-error' );
		$( '#purchaserbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#purchasertype' ).text() == "Other " )
	{
		$( '#purchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#newPurchaser' ).val() == "" )
		{
			$( '#purchasedby_error' ).show().children().html( "Purchaser is required!" );
		}

		else
		{
			$( '#purchasedby_error' ).hide();
			$( 'purchasedby_input' ).removeClass( 'has-error' );
		}
	}

	else
	{
		$( '#purchasedby_error' ).hide();
		$( '#purchasedby_input' ).removeClass( 'has-error' );
		$( '#purchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	}
			
// location tab

	// department
	if ( $( '#departmenttype' ).text() == "Choose Department " )
	{
		$( '#department_error' ).show().children().html( "Department is required!" );
		$( '#department_input' ).addClass( 'has-error' );
		$( '#departmentbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#departmenttype' ).text() == "Other " )
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
		}
	}

	else
	{
		$( '#department_error, #otherdepartment_error' ).hide();
		$( '#department_input, #otherdepartment_input' ).removeClass( 'has-error' );
		$( '#departmentbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	}

	// location
	if ( $( '#locationtype' ).text() == "Choose Location " )
	{
		$( '#location_error' ).show().children().html( "Location is required!" );
		$( '#location_input' ).addClass( 'has-error' );
		$( '#locationbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
	}

	else if ( $( '#locationtype' ).text() == "On Campus " )
	{
		$( '#location_error' ).hide();
		$( '#location_input' ).removeClass( 'has-error' );
		$( '#locationbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#buildingtype' ).text() == "Choose Building " )
		{
			$( '#building_error' ).show().children().html( "Building is required!" );
			$( '#building_input' ).addClass( 'has-error' );
			$( '#buildingbutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#buildingtype' ).text() == "Other " && $( '#otherbuilding' ).val() == "" )
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
		}
	}

	else
	{
		$( '#location_error, #building_error, #otherbuilding_error, #room_num_error' ).hide();
		$( '#location_input, #building_input, #otherbuilding_input, #room_num_input' ).removeClass( 'has-error' );
		$( '#locationbutton, #buildingbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
	}

// users/software tabs

	if ( $( '#eqtype' ).text() == "Computer or Tablet " )
	{
		// User type
		if ( $( '#usertype' ).text() == "Choose Type " )
		{
			$( '#selectusertype_error' ).show().children().html( "User type required!" );
			$( '#selectusertype_input' ).addClass( 'has-error' );
			$( '#usertypebutton' ).addClass( 'btn-danger' ).removeClass( 'btn-default' );
		}

		else if ( $( '#usertype' ).text() == "Faculty/Staff " )
		{
			$( '#selectusertype_error' ).hide();
			$( '#selectusertype_input' ).removeClass( 'has-error' );
			$( '#usertypebutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

			if ( $( '#newuserfname:visible' ).val() == "" && $( '#newuserlname:visible' ).val() == "" )
			{
				$( '#newuser_error' ).show().children().html( "First and last name required!" );
				$( '#newuser_input' ).addClass( 'has-error' );
			}
			
			else if ( $( '#newuserfname:visible' ).val() == "" )
			{
				$( '#newuser_error' ).show().children().html( "First name required!" );
				$( '#newuser_input' ).addClass( 'has-error' );
			}

			else if ( $( '#newuserlname:visible' ).val() == "" )
			{
				$( '#newuser_error' ).show().children().html( "Last name required!" );
				$( '#newuser_input' ).addClass( 'has-error' );
			}

			else
			{
				$( '#newuser_error' ).hide();
				$( '#newuser_input' ).removeClass( 'has-error' );
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


	// collect input-data into json
	


});

</script>
