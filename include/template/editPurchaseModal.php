<!-- Edit Purchase Modal -->
<div class="modal" id="editPurchaseModal"  style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Edit Purchase Record</h4> <small>(Items with * are optional)</small>
			</div>

			<div class="modal-body">
				<div class="container">
					<form class="form-horizontal" role="form" id="editPurchaseForm" action="" method="post">

						<input id="pPurchase_id" class="hidden" type="text">

						<div id="pPurchaseorder_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Purchase Order</label>
							<div class="col-xs-3">
								<input type="text" class="form-control" id="pPurchaseorder" placeholder="Purchase Order" maxlength="10">
							</div>
						</div>

						<div id="pPurchaseorder_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

						<div id="pPurchasedate_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Purchase Date</label>
							<div class="col-xs-3">
								<input type="text" class="form-control" id="pPurchasedate" placeholder="YYYY-MM-DD" maxlength="10">
							</div>
						</div>

						<div id="pPurchasedate_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

						<div id="pPurchasedby_input" class="form-group">
							<label class="col-xs-2 control-label text-right">Purchased By</label>
							<div class="col-xs-3">
								<div class="btn-group">
									<button id="pPurchaserbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
										<span id="pPurchasertype">Choose Purchaser</span> <span class="caret"></span>
									</button>
									<ul id="pPurchasermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
										<li><a href="#">Other</a></li>
										<li class="divider"></li>
									</ul>
								</div>
								<input id='pNewPurchaser' class='form-control' placeholder='Create New Purchaser' style='margin-top:10px'>
							</div>
						</div>

						<div id="pPurchasedby_error" class="input_error form-group" style="margin-bottom:20px;color:red">
							<div class="col-xs-offset-2 col-xs-4"></div>
						</div>

					</form>
				</div>
			</div>

			<div class="modal-footer"> 
				<button type="button" class="btn btn-default" data-dismiss="modal" >Cancel</button>
				<button id="submitpurchase" type="button" class="btn btn-primary">Submit</button>
			</div>
		</div>
	</div>
</div>

<script>
// this resets form data in the modal on closing
$( '#editPurchaseModal' ).on( 'hidden.bs.modal', function(){
	// reset all form inputs
    $( this ).find( '#editPurchaseForm' )[0].reset();

	// reset all hidden forms
	$( this ).find( '.form-group' ).not( '#pPurchaseorder_input, #pPurchasedate_input, #pPurchasedby_input' ).add( '#pNewPurchaser' ).hide();

	// remove all error styles
	$( this ).find( '.has-error' ).removeClass( 'has-error' );
	$( this ).find( '.btn-danger' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );
});

$( '#submitpurchase' ).on( 'click', function() {

// prepare inputs from menus

	// purchase order
	var purchase_order = $( '#pPurchaseorder' ).val();

	// purchase date
	if ( $( '#pPurchasedate' ).val() == "" )
	{
		$( '#pPurchasedate_error' ).show().children().html( "Purchase date is required!" );
		$( '#pPurchasedate_input' ).addClass( 'has-error' );
	}

	else
	{
		$( '#pPurchasedate_error' ).hide();
		$( '#pPurchasedate_input' ).removeClass( 'has-error' );

		// set variable
		var purchase_date = $( '#pPurchasedate' ).val();
	}

	// purchased by
	if ( $( '#pPurchasertype' ).text() == "Other" )
	{
		$( '#pPurchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		if ( $( '#pNewPurchaser' ).val() == "" )
		{
			$( '#pPurchasedby_input' ).addClass( 'has-error' );
			$( '#pPurchasedby_error' ).show().children().html( "Purchaser is required!" );
		}

		else
		{
			$( '#pPurchasedby_error' ).hide();
			$( 'pPurchasedby_input' ).removeClass( 'has-error' );

			// set variable
			var purchased_by = $( '#pNewPurchaser' ).val();
		}
	}

	else
	{
		$( '#pPurchasedby_error' ).hide();
		$( '#pPurchasedby_input' ).removeClass( 'has-error' );
		$( '#pPurchaserbutton' ).addClass( 'btn-default' ).removeClass( 'btn-danger' );

		// set variable
		var purchased_by = $( '#pPurchasertype' ).text();
	}		

	// check if any errors exist
	if ( !$( '#editPurchaseModal' ).find( '.form-group' ).hasClass( 'has-error' ) )
	{
		// set other variables
		var purchase_id = $( '#pPurchase_id' ).val();

		// collect input-data into json
		var input = { "purchase_id" : purchase_id,
						"purchase_order" : purchase_order,
						"purchase_date" : purchase_date,
						"purchased_by" : purchased_by };

		console.log( input );

		user_input = JSON.stringify( input );

		$.ajax({
			type: "POST",
			url: "include/edit_purchase.php",
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

					$( '#editPurchaseModal' ).modal( 'hide' );
				}
			},
			error: function(){
				alert( "There was a problem in the database!" );
			}
		});
	}
});
</script>
