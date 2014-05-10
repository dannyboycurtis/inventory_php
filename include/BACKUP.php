<br>
<div class='row'>

<div class='col-xs-2'>
<div class="btn-group">
    <label>Make</label>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <span id="maketype">Choose Make </span><span class="caret"></span>
  </button>
  <ul id="makemenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">

    <li><a href="#">Other </a></li>
    <li class="divider"></li>
  </ul>
</div>
<br><br>
<div class="btn-group">
    <label>Model</label>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <span id="modeltype">Choose Model </span><span class="caret"></span>
  </button>
  <ul id="modelmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">

    <li><a href="#">Other </a></li>
    <li class="divider"></li>
  </ul>
</div>
</div>

<div class='col-xs-3'>
<div class="btn-group">
    <label>Department</label>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    <span id="departmenttype">Choose Department </span><span class="caret"></span>
  </button>
  <ul id="departmentmenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
  </ul>
</div>
</div>

<div class='col-xs-3'>
<div class="btn-group">
    <label>Users</label>
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
    Choose Users <span class="caret"></span>
  </button>
  <ul id="usermenu" class="dropdown-menu" role="menu" style="height:auto;max-height: 200px;overflow-x:hidden">
  </ul>
</div>
<br><br>
<ul id='userlist' class='list-unstyled'></ul>

<div class='btn-group' id='addUser' style='display:none'>
<label>Add New User</label>
<input class='form-control' placeholder='First Name*'>
<input class='form-control' placeholder='Last Name*' style='margin-top:10px'>
<input class='form-control' placeholder='Email Address' style='margin-top:10px'>
<input class='form-control' placeholder='Phone Number' style='margin-top:10px'>
</div>

</div>

<script>


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
					$( '#modeltype' ).html( "Other " );

				else
				{
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
	  						$( '#modeltype').html( $( this ).text() );
							});
						}
					});


				}
			});
		}
	});


	
</script>
