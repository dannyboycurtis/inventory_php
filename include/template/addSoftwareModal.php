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
					<li id="swSoftwaretab" class="active"><a href="#swSoftwareInfo" data-toggle="tab">Equipment</a></li>
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
$( '#addEquipmentModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#swPurchaseForm' )[0].reset();
    $( this ).find( '#addSoftwareForm' )[0].reset();
    $( this ).find( '#swOtherForm' )[0].reset();

	// reset all hidden forms
	$( this ).find( '.form-group' ).not( '#swPurchaseorder_input, #swNotes_input' ).add( '#swNewPurchase' ).hide();

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

	// enable all dropdowns
	$( this ).find( 'button' ).attr( 'data-toggle', 'dropdown').removeClass( 'active' );

	// reset modal-title
	$( this ).find( '.modal-title' ).text( "Add Software Record" );
});


</script>
