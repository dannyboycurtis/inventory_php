<div class="container">
  <form class="form-horizontal" role="form" id="softwareForm" action="" method="post">
    <h4>Software Information: <small>(Items with * are optional)</small></h4>

    <div class="form-group" id='selectsoftware'>
      <label class="col-xs-2 control-label text-right">Software</label>
      <div class="col-xs-3">
        <div class="btn-group">
  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    			Choose Software <span class="caret"></span>
  			</button>
  			<ul id="softwaremenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
		</div>
		<ul id='softwarelist' class='list-unstyled' style='margin-top:10px'></ul>
      </div>
    </div>

    <div class="form-group" id='softwarenotavailable'>
&nbsp;&nbsp;&nbsp;&nbsp; Please Note: software is not available for this equipment type!
    </div>

  </form>
</div>
<script>
  	// initially hides certain input boxes
	$( '#selectsoftware' ).hide();

	$( '#softwarenotavailable' ).show();
   // this brings up text boxes based on equipment type
  $('#usertypemenu>li>a').on( 'click', function(){
     if ( $( this ).text() == "Faculty/Staff ")
       $('#selectusers').show();

     else
       $('#selectusers, #newuser').hide();

	$( '#usertype' ).html( $( this ).text() ); 
   });

// software dropdown
	$.ajax({
		type: "POST",
		url: "include/populate_menus.php",
		data: { query : "software" },
		success: function( result ){
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#softwaremenu').append( "<li><span class='hidden'>" + results[i].softwareid + "</span><a href='#'>" + results[i].software_name + ", " + results[i].licensetype + " </a></li>" );
			});

			$("#softwaremenu>li>a").on( 'click', function(){
	  			$( '#softwarelist').append( "<li><i class='fa fa-minus-square' style='cursor:pointer'></i> " + $(this).text() + "</li>");
				$( '#softwarelist>li>i').on( 'click', function(){
							$( this ).parents( 'li' ).remove();
				});

			});
		} 
	});


</script>