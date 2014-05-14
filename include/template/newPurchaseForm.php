<div class="container">
  <form class="form-horizontal" role="form" id="purchaseForm" action="" method="post">
    <h4>Purchase Information: <small>(Items with * are optional)</small></h4>

	<div class="form-group">
		<label class="col-xs-2 control-label text-right">Purchase Order</label>
		<div class="col-xs-3">
			<div class="btn-group">
  				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    				<span id="purchasetype">Choose Purchase Order</span> <span class="caret"></span>
  				</button>
  				<ul id="purchasemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
					<li><a href="#">New Purchase Order </a></li>
   					<li class="divider"></li>
  				</ul>
			</div>
		<input id='newPurchase' class='form-control' placeholder='Create New Purchase Order' style='margin-top:10px'>
      </div>
    </div>


    <div class="form-group">
      <label class="col-xs-2 control-label text-right">Purchase Date</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="purchasedate" placeholder="YYYY-MM-DD">
      </div>
    </div>


	<div class="form-group">
		<label class="col-xs-2 control-label text-right">Purchased By</label>
		<div class="col-xs-3">
			<div class="btn-group">
  				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    				<span id="purchasertype">Choose Purchaser</span> <span class="caret"></span>
  				</button>
  				<ul id="purchasermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
					<li><a href="#">Other </a></li>
   					<li class="divider"></li>
  				</ul>
			</div>
		<input id='newPurchaser' class='form-control' placeholder='Create New Purchaser' style='margin-top:10px'>
      </div>

    </div>
   


    <div class="form-group" id="purchased_by_input">
      <label class="col-xs-2 control-label text-right">Name of Purchaser</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="purchased_by_other"> 
      </div>   
    </div>




  </form>
</div>

<script>

$( '#newPurchase' ).hide();
$( '#newPurchaser' ).hide();

// purchased by dropdown
	$.ajax({
		type: "POST",
		url: "include/populate_menus.php",
		data: { query : "purchased_by" },
		success: function( result ){
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#purchasermenu').append( "<li><a href='#'>" + results[i] + " </a></li>" );
			});

			$("#purchasermenu>li>a").on( 'click', function(){
				if ( $( this ).text() == 'Other ' )
					$( '#newPurchaser' ).show();

				else
					$( '#newPurchaser' ).hide();

	  			$( '#purchasertype').html( $( this ).text() );
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
				$('#purchasemenu').append( purchaseresults );
			});

			$("#purchasemenu>li>a").on( 'click', function(){
				if ( $( this ).text() == 'New Purchase Order ' )
				{
					$( '#newPurchase' ).show();
					$( '#purchasedate' ).attr( 'disabled', false ).val( '' );
					$( '#purchasedby' ).val( 'default' );
					$( '#purchasertype' ).html( "Choose Purchaser " )
										 .parents( 'button' ).attr( 'data-toggle', 'dropdown')
															 .removeClass( 'active' );
					$( '#newPurchaser' ).hide();
				}
	  			else
				{
					$( '#purchasedate').val( $( this ).parents().children( '.pdate').text() ).attr( 'disabled', true );
					$( '#purchasertype' ).html( $( this ).parents().children( '.pby' ).text() ).parents().addClass( 'active' );
					$( '#purchasertype' ).parents().removeAttr('data-toggle');
					$( '#newPurchaser' ).hide();
					$( '#newPurchase' ).hide();
				}

				$( '#purchasetype').html( $( this ).text() );
			});
		}
	});
</script>