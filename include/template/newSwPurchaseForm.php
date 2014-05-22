<div class="container">
	<form class="form-horizontal" role="form" id="swPurchaseForm" action="" method="post">

		<div id="swPurchaseorder_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Purchase Order</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="swPurchaseorderbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="swPurchasetype">Choose Purchase Order</span> <span class="caret"></span>
					</button>
					<ul id="swPurchasemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">New Purchase Order</a></li>
						<li class="divider"></li>
					</ul>
				</div>
				<input id='swNewPurchase' class='form-control' placeholder='New Purchase Order' style='margin-top:10px' maxlength="30">
			</div>
		</div>

		<div id="swPurchaseorder_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="swPurchasedate_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Purchase Date</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="swPurchasedate" placeholder="YYYY-MM-DD" maxlength="10">
			</div>
		</div>

		<div id="swPurchasedate_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="swPurchasedby_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Purchased By</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="swPurchaserbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="swPurchasertype">Choose Purchaser</span> <span class="caret"></span>
					</button>
					<ul id="swPurchasermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Other</a></li>
						<li class="divider"></li>
					</ul>
				</div>
				<input id='swNewPurchaser' class='form-control' placeholder='Create New Purchaser' style='margin-top:10px'>
			</div>
		</div>

		<div id="swPurchasedby_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

	</form>
</div>

<script>
$( '#swPurchasedate' ).mask( "9999-99-99", {placeholder:" "});

// initially hides certain input boxes
$( '#swPurchaseForm' ).find( '.form-group' ).not( '#swPurchaseorder_input' ).hide();
$( '#swNewPurchase' ).hide();

// purchased by dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "purchased_by" },
	success: function( result ){
		results = $.parseJSON( result );
		$.each( results, function( i ){
			$('#swPurchasermenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
		});

		$("#swPurchasermenu>li>a").on( 'click', function(){
			if ( $( this ).text() == 'Other' )
				$( '#swNewPurchaser' ).show();

			else
				$( '#swNewPurchaser' ).hide();

  			$( '#swPurchasertype').html( $( this ).text() );
		});
	}
});

// purchase order dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "purchase_order" },
	success: function( result ){
		results = $.parseJSON( result );
		$.each( results, function( i ){
			var purchaseresults = "<li>";
			purchaseresults += "<span style='display:none' class='pid'>" + results[i].purchaseid + "</span>";
			purchaseresults += "<span style='display:none' class='pdate'>" + results[i].purchasedate + "</span>";
			purchaseresults += "<span style='display:none' class='pby'>" + results[i].purchasedby + "</span>";
			purchaseresults += "<a href='#'>" + results[i].purchaseorder + "</a></li>";

			$( '#swPurchasemenu' ).append( purchaseresults );
		});

		$( "#swPurchasemenu>li>a" ).on( 'click', function(){
			if ( $( this ).text() == 'New Purchase Order' )
			{
				$( '#swNewPurchase, #swPurchasedate_input, #swPurchasedby_input' ).show();
				$( '#swPurchasedate' ).attr( 'disabled', false ).val( '' );
				$( '#swPurchasertype' ).html( "Choose Purchaser" )
				$( '#swPurchaserbutton' ).attr( 'data-toggle', 'dropdown').removeClass( 'active' );
				$( '#swNewPurchaser' ).hide();
			}

  			else
			{
				$( '#swPurchasemenu>li' ).removeClass( 'selectedpurchaser' );
				$( this ).parent( "li" ).addClass( 'selectedpurchaser' );

				$( '#swPurchasedate').val( $( this ).parents().children( '.pdate').text() ).attr( 'disabled', true );
				$( '#swPurchasertype' ).html( $( this ).parents().children( '.pby' ).text() ).parents().addClass( 'active' );
				$( '#swPurchasertype' ).parents().removeAttr('data-toggle');

				$( '#swNewPurchaser, #swNewPurchase' ).hide();
				$( '#swPurchasedate_input, #swPurchasedby_input' ).show();
			}

			$( '#swPurchasetype').html( $( this ).text() );
		});
	}
});
</script>
