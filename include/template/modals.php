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

<?php if( $_SESSION['role'] > 1 )
{

	include_once "include/template/addEquipmentModal.php";
	include_once "include/template/addSoftwareModal.php";
	include_once "include/template/editUserModal.php";
	include_once "include/template/editPurchaseModal.php";
}
?>
