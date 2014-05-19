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

<?php if( $_SESSION['role'] > 1 )
		 include_once "include/template/addEquipmentModal.php"; ?>
