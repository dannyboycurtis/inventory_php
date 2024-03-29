<div class="container">
	<form class="form-horizontal" role="form" id="purchaseForm" action="" method="post">

		<div id="purchaseorder_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Purchase Order</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="purchaseorderbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="purchasetype">Choose Purchase Order</span> <span class="caret"></span>
					</button>
					<ul id="purchasemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">New Purchase Order</a></li>
						<li class="divider"></li>
					</ul>
				</div>
				<input id='newPurchase' class='form-control' placeholder='New Purchase Order' style='margin-top:10px' maxlength="30">
			</div>
		</div>

		<div id="purchaseorder_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="purchasedate_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Purchase Date</label>
			<div class="col-xs-3">
				<input type="text" class="form-control" id="purchasedate" placeholder="YYYY-MM-DD" maxlength="10">
			</div>
		</div>

		<div id="purchasedate_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>

		<div id="purchasedby_input" class="form-group">
			<label class="col-xs-2 control-label text-right">Purchased By</label>
			<div class="col-xs-3">
				<div class="btn-group">
					<button id="purchaserbutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span id="purchasertype">Choose Purchaser</span> <span class="caret"></span>
					</button>
					<ul id="purchasermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
						<li><a href="#">Other</a></li>
						<li class="divider"></li>
					</ul>
				</div>
				<input id='newPurchaser' class='form-control' placeholder='Create New Purchaser' style='margin-top:10px'>
			</div>
		</div>

		<div id="purchasedby_error" class="input_error form-group" style="margin-bottom:20px;color:red">
			<div class="col-xs-offset-2 col-xs-4"></div>
		</div>
		<input id="eqPurchaseId" style="display:none" type='hidden'>
	</form>
</div>

<script>
$( '#purchasedate' ).mask( "9999-99-99", {placeholder:" "});

// initially hides certain input boxes
$( '#purchaseForm' ).find( '.form-group' ).not( '#purchaseorder_input' ).hide();
$( '#newPurchase' ).hide();

// purchased by dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "purchased_by" },
	success: function( result ){
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#purchasermenu').append( "<li><a href='#'>" + results[i] + "</a></li>" );
			});

			$("#purchasermenu>li>a").on( 'click', function(){
				if ( $( this ).text() == 'Other' )
					$( '#newPurchaser' ).show();

				else
					$( '#newPurchaser' ).hide();

  				$( '#purchasertype').html( $( this ).text() );
			});
		}
	}
});

// purchase order dropdown
$.ajax({
	type: "POST",
	url: "include/populate_menus.php",
	data: { query : "purchase_order" },
	success: function( result ){
		if ( result.charAt( 0 ) == "<" )
			window.location.reload();

		else
		{
			results = $.parseJSON( result );

			if ( results )
			{
				$.each( results, function( i ){
					var purchaseresults = "<li>";
					purchaseresults += "<span style='display:none' class='eqpid'>" + results[i].purchaseid + "</span>";
					purchaseresults += "<span style='display:none' class='pdate'>" + results[i].purchasedate + "</span>";
					purchaseresults += "<span style='display:none' class='pby'>" + results[i].purchasedby + "</span>";
					purchaseresults += "<a href='#'>" + results[i].purchaseorder + "</a></li>";

					$( '#purchasemenu' ).append( purchaseresults );
				});
			}

			$( "#purchasemenu>li>a" ).on( 'click', function(){
				if ( $( this ).text() == 'New Purchase Order' )
				{
					$( '#newPurchase, #purchasedate_input, #purchasedby_input' ).show();
					$( '#purchasedate' ).attr( 'disabled', false ).val( '' );
					$( '#purchasertype' ).html( "Choose Purchaser" )
					$( '#purchaserbutton' ).attr( 'data-toggle', 'dropdown').removeClass( 'active' );
					$( '#newPurchaser' ).hide();
				}

  				else
				{
					$( '#eqPurchaseId' ).val( $( this ).parents().children( '.eqpid' ).text() );
					//$( '#purchasemenu>li' ).removeClass( 'selectedpurchaser' );
					//$( this ).parent( "li" ).addClass( 'selectedpurchaser' );

					$( '#purchasedate').val( $( this ).parents().children( '.pdate').text() ).attr( 'disabled', true );
					$( '#purchasertype' ).html( $( this ).parents().children( '.pby' ).text() ).parents().addClass( 'active' );
					$( '#purchasertype' ).parents().removeAttr('data-toggle');

					$( '#newPurchaser, #newPurchase' ).hide();
					$( '#purchasedate_input, #purchasedby_input' ).show();
				}

				$( '#purchasetype').html( $( this ).text() );
			});
		}
	}
});
</script>
