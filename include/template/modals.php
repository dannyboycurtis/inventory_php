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
<div class="modal" id="addEquipmentModal" style="padding-top:40px" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
    	<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        		<h3 class="modal-title">Add Equipment Record</h3>
			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#basicstab" data-toggle="tab">Basic</a></li>
					<li><a href="#purchasetab" data-toggle="tab">Purchase</a></li>
					<li><a href="#networktab" data-toggle="tab">Network</a></li>
					<li><a href="#usertab" data-toggle="tab">Users</a></li>
					<li><a href="#softwaretab" data-toggle="tab">Software</a></li>
					<li><a href="#notestab" data-toggle="tab">Notes</a></li>
				</ul>
				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane active" id="basicstab">
						<br>
						<div class='row'>

							<div class='col-xs-4'>
								<h5>&nbsp;Make & Model:</h5>
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
								<br>
								<div class="btn-group" style='margin-top:10px'>
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
					</div><!-- end basicstab -->

					<div class="tab-pane" id="purchasetab">...</div>
					<div class="tab-pane" id="networktab">...</div>
					<div class="tab-pane" id="usertab">...</div>
					<div class="tab-pane" id="softwaretab">...</div>
					<div class="tab-pane" id="notestab">...</div>

				</div>
			</div>
    	</div>
	</div>
</div>


<script>

$( '#newMake, #newModel' ).hide();

// users dropdown
	$.ajax({
		type: "POST",
		url: "include/populate_menus.php",
		data: { query : "users" },
		success: function( result ){
			results = $.parseJSON( result );
			$( '#usermenu').html( "<li><a href='#'>Add New User</a></li><li class='divider'></li>");
			$.each( results, function( i ){
				$('#usermenu').append( "<li><span class='hidden'>" + results[i].userid + "</span><a href='#'>" + results[i].fname + " " + results[i].lname + " </a></li>" );
			});

			$("#usermenu>li>a").on( 'click', function(){
				if ( $( this ).text() == 'Add New User' )
					$( '#addUser' ).show();
				else
				{
	  				$( '#userlist').append( "<li><i class='fa fa-minus-square' style='cursor:pointer'></i> " + $(this).text() + "</li>");
						$( '#userlist>li>i').on( 'click', function(){
							$( this ).parents( 'li' ).remove();
						});
				}
			});
		} 
	});


// department dropdown
	$.ajax({
		type: "POST",
		url: "include/populate_menus.php",
		data: { query : "department" },
		success: function( result ){
			results = $.parseJSON( result );
			$.each( results, function( i ){
				$('#departmentmenu').append( "<li><a href='#'>" + results[i] + " </a></li>" );
			});

			$("#departmentmenu>li>a").on( 'click', function(){
	  		$( '#departmenttype').html( $( this ).text() );
			});
		}
	});

// make and model dropdowns
	$.ajax({
		type: "POST",
		url: "include/populate_menus.php",
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
						url: "include/populate_menus.php",
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
