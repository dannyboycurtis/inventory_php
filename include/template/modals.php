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


      <div class="modal-body">
        <ul class="nav nav-tabs" id="addRecordTab">
          <li class="active"><a href="#equipmentInfo" data-toggle="tab">Equipment </a></li>
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
        <button type="button" class="btn btn-primary disabled">Submit</button>
      </div>
    </div>
  </div>
</div>


<script>
  // this resets form data in the modal on closing
  $('.modal').on('hidden.bs.modal', function(){
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
	$( '#selectusertype, #selectusers, #newuser, #selectsoftware' ).hide();
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
</script>
