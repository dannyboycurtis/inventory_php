<div class="container">
  <form class="form-horizontal" role="form" id="userForm" action="" method="post">

    <div  id="selectusertype_input" class="form-group">
      <label class="col-xs-2 control-label text-right">Type of User</label>
      <div class="col-xs-3">
			<div class="btn-group">
  				<button id="usertypebutton" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    				<span id="usertype">Choose Type </span><span class="caret"></span>
  				</button>
  				<ul id="usertypemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
    				<li><a href="#">Faculty/Staff </a></li>
    				<li><a href="#">Lab Workstation </a></li>
  				</ul>
			</div>
      </div>
    </div>

	<div id="selectusertype_error" class="input_error form-group" style="margin-bottom:20px;color:red">
		<div class="col-xs-offset-2 col-xs-4"></div>
	</div>

    <div id='selectusers_input' class="form-group">
      <label class="col-xs-2 control-label text-right">Users</label>
      <div class="col-xs-3">
        <div class="btn-group">
  			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    			Choose Users <span class="caret"></span>
  			</button>
  			<ul id="usermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden"></ul>
		</div>
		<ul id='userlist' class='list-unstyled' style='margin-top:10px'></ul>
      </div>
    </div>

	<div  id='newuser_input' class="form-group">
		<label class="col-xs-2 control-label text-right">Add New User</label>
		<div class="col-xs-3">
			<div class='btn-group'>
				<input class='form-control' id='newuserfname' placeholder='First Name'>
				<input class='form-control' id='newuserlname' placeholder='Last Name' style='margin-top:10px'>
				<input class='form-control' id='newuseremail' placeholder='Email Address*' style='margin-top:10px'>
				<input class='form-control' id='newuserphone' placeholder='Phone Number*' style='margin-top:10px'>
			</div>
		</div>
	</div>

	<div id="newuser_error" class="input_error form-group" style="margin-bottom:20px;color:red">
		<div class="col-xs-offset-2 col-xs-4"></div>
	</div>

    <div class="form-group" id='usersnotavailable'>
&nbsp;&nbsp;&nbsp;&nbsp; Please Note: users are not available for this equipment type!
    </div>

  </form>
</div>
<script>
  	// initially hides certain input boxes
	$( '#selectusers_input, #newuser_input, #selectusertype_input' ).hide();

   // this brings up text boxes based on equipment type
  $('#usertypemenu>li>a').on( 'click', function(){
     if ( $( this ).text() == "Faculty/Staff ")
       $('#selectusers_input').show();

     else
       $('#selectusers_input, #newuser_input').hide();

	$( '#usertype' ).html( $( this ).text() ); 
   });

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
					$( '#newuser_input' ).show();
				else
				{
					$( '#newuser_input' ).hide();
	  				$( '#userlist').append( "<li><i class='fa fa-minus-square' style='cursor:pointer'></i> " + $(this).text() + "</li>");
						$( '#userlist>li>i').on( 'click', function(){
							$( this ).parents( 'li' ).remove();
						});
				}
			});
		} 
	});


</script>
