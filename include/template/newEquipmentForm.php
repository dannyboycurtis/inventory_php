<div class="container">
  <form class="form-horizontal" role="form" id="newEquipmentForm" action="">
    <h4>Equipment Information: <small>(Items with * are optional)</small></h4>

    <div class="form-group">
      <label class="col-xs-2 control-label text-right">Tag Number</label>
      <div class="col-xs-1">
        <input type="text" class="form-control" id="tag_num" maxlength="5">
      </div>      
    </div>

    <div class="form-group">
		<label class="col-xs-2 control-label text-right">Serial Number</label>
		<div class="col-xs-3">
			<input type="text" class="form-control" id="serial" maxlength="30"> 
		</div>
	</div>

	<div class="form-group">
		<label class="col-xs-2 control-label text-right">Make</label>
		<div class="col-xs-3">
			<div class="btn-group">
  				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    				<span id="maketype">Choose Make </span><span class="caret"></span>
  				</button>
  				<ul id="makemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
					<li><a href="#">Other </a></li>
   					<li class="divider"></li>
  				</ul>
			</div>
		<input id='newMake' class='form-control' placeholder='Create New Make' style='margin-top:10px'>
      </div>
    </div>
   
	<div class="form-group">
    	<label class="col-xs-2 control-label text-right">Model</label>
    	<div class="col-xs-3">
			<div class="btn-group">
  				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    				<span id="modeltype">Choose Model </span><span class="caret"></span>
  				</button>
  				<ul id="modelmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
    				<li><a href="#">Other </a></li>
    				<li class="divider"></li>
  				</ul>
			</div>
		<input id='newModel' class='form-control' placeholder='Create New Model' style='margin-top:10px'>
      </div>
    </div>

    <div class="form-group">
      <label class="col-xs-2 control-label text-right">Type of Equipment</label>
      <div class="col-xs-3">

			<div class="btn-group">
  				<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    				<span id="eqtype">Choose Type </span><span class="caret"></span>
  				</button>
  				<ul id="eqtypemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
    				<li><a href="#">Computer or Tablet </a></li>
    				<li><a href="#">Network Printer </a></li>
    				<li><a href="#">Other Equipment </a></li>
  				</ul>
			</div>

      </div>
    </div>

    <div class="form-group" id="description_input">
      <label class="col-xs-2 control-label text-right">Description</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="description" maxlength="100">
      </div>
    </div>

    <div class="form-group" id="hostname_input">
      <label class="col-xs-2 control-label text-right">Hostname</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="hostname" maxlength="30">
      </div>
    </div>

    <div class="form-group" id="os_input">
      <label class="col-xs-2 control-label text-right">Operating System</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="os" maxlength="30">
      </div>
    </div>

    <div class="form-group" id="printer_input">
      <label class="col-xs-2 control-label text-right">Printer*</label>
      <div class="col-xs-3">
        <input type="text" class="form-control" id="eq_printer">
      </div>
    </div>

  </form>
</div>
<script>
  	// initially hides certain input boxes
	$( '#newMake, #newModel, #description_input, #hostname_input, #os_input' ).hide();

   // this brings up text boxes based on equipment type
  $('#eqtypemenu>li>a').on( 'click', function(){
     if ( $( this ).text() == "Other Equipment ")
     {
       $('#description_input').show();
       $('#hostname_input, #os_input, #printer_input').hide();

     } 
     else if ( $( this ).text() == "Computer or Tablet ")
     {
       $('#hostname_input, #os_input, #printer_input').show();
       $('#description_input').hide();
     }
     else if ( $( this ).text() == "Network Printer ")
     {
       $('#hostname_input').show();
       $('#os_input, #description_input, #printer_input').hide();
     }
     else
       $('#hostname_input, #os_input, #description_input, #printer_input').hide();

		$( '#eqtype' ).html( $( this ).text() ); 
   });





// make and model dropdowns
	$.ajax({
		type: "POST",
		url: "../populate_menus.php",
		data: { query : "make" },
		success: function( result ) {
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#makemenu').append( "<li><a href='#'>" + results[i] + " </a></li>" );
			});

			$("#makemenu>li>a").on( 'click', function(){
	  		$( '#maketype').html( $( this ).text() );

				if ( $( '#maketype' ).html() == 'Other ' )
				{
					$( '#modeltype' ).html( "Other " );
					$( '#newMake, #newModel' ).show();
				}

				else
				{
					$( '#newMake, #newModel' ).hide();
					$( '#modeltype' ).html( "Choose Model " );
					$( '#modelmenu' ).html( "<li><a href='#'>Other </a></li><li class='divider'></li>" );

					$.ajax({
						type: "POST",
						url: "../populate_menus.php",
						data: { query : "model_from_make", make : $('#maketype').html() },
						success: function( result ) {
							results = $.parseJSON( result );

							$.each( results, function( i ){
								$('#modelmenu').append( "<li><a href='#'>" + results[i] + " </a></li>" );
							});

							$("#modelmenu>li>a").on( 'click', function(){
								if ( $( this ).text() == 'Other ' )
									$( '#newModel' ).show();						
								
								else
									$( '#newModel' ).hide();	

		  						$( '#modeltype').html( $( this ).text() );
							});
						}
					});


				}
			});
		}
	});
</script>
