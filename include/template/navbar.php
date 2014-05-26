 <!-- Fixed navbar -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" style="font-family:Times New Roman;font-size:19pt;" href="portal.php"><?php echo ORGANIZATION; ?> Inventory</a>
    </div>
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav pull-right">
        <li id="searchBtn" class="collapse in" data-toggle="collapse" href="#search_panel">
					<a style="cursor:pointer;"><b>Search</b></a>
				</li>
				<li class="divider-vertical"></li>
		<?php if ( $_SESSION['role'] > 1 ) : ?>
	        <li data-backdrop="static" data-toggle="modal" data-target="#addEquipmentModal">
				<a style="cursor:pointer;">Add Equipment</a>
			</li>
        	<li data-backdrop="static" data-toggle="modal" data-target="#addSoftwareModal">
				<a style="cursor:pointer;">Add Software</a>
			</li>
		<?php endif; ?>
        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">List All <b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li><a href="#" onClick="list_equipment( '_computers' );"><i class="fa fa-desktop"></i>&nbsp; Computers/Tablets</a>
              </li>
              <li><a href="#" onClick="list_equipment( '_labs' );"><i class="fa fa-users"></i>&nbsp; Lab Workstations</a>
              </li>
              <li><a href="#" onClick="list_equipment( '_printers' );"><span class="glyphicon glyphicon-print"></span>&nbsp; Network Printers</a>
              </li>
              <li><a href="#" onClick="list_users( '_all' );"><span class="glyphicon glyphicon-user"></span>&nbsp; Faculty/Staff Users</a>
              </li>
              <li><a href="#" onClick="list_purchases( '_all' );"><span class="glyphicon glyphicon-barcode"></span>&nbsp; Purchase Orders</a>
              </li>
		      <?php if ( $_SESSION['role'] > 1 ) : ?>
			    <li class='divider'></li>
                <li><a href="#" onClick="list_software( '_all' );">
                  <i class="fa fa-key"></i>&nbsp; Software Licenses</a>
                </li>
		      <?php endif; ?>
            </ul>
          </li>
        </ul>
	    <?php if ( $_SESSION['role'] == 4 ) : ?>
			<ul class="nav navbar-nav">
      		    <li class="dropdown">
        			<a href="#" class="dropdown-toggle" data-toggle="dropdown">Administration <b class="caret"></b></a>
        			<ul class="dropdown-menu">
        				<li><a id="manageUsers" href="#"><span class="glyphicon glyphicon-list"></span>&nbsp; Manage Inventory Users</a></li>
        			    <li><a id="viewUserLogAll" href="#"><span class="glyphicon glyphicon-eye-open"></span>&nbsp; View User Activity Log</a></li>
        			</ul>
      			</li>
    		</ul>
		<?php endif; ?>
        <ul class="nav navbar-nav navbar-right text-right">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $_SESSION['username']; ?> &nbsp;<span class="glyphicon glyphicon-cog"></span></a>
            <ul class="dropdown-menu">
              <li><a id="viewUserLog" href="#" class="text-right">View User Log &nbsp;<span class="glyphicon glyphicon-list-alt"></span></a></li>
              <li><a href="#" class="text-right">Reset Password &nbsp;<span class="glyphicon glyphicon-wrench"></span></a></li>
              <li class="divider"></li>
              <li><a href="include/process_logout.php" class="text-right">Log out &nbsp;&nbsp;<i class="fa fa-sign-out"></i></a></li>
            </ul>
          </li>
        </ul>
      </ul>
 
    </div><!--/.nav-collapse -->
  </div>
</div>

<script>
$( '#viewUserLog' ).on( 'click', function(){
	list_activity( '<?php echo $_SESSION["username"]; ?>' );
});

$( '#viewUserLogAll' ).on( 'click', function(){
	list_activity( '_all' );
});

$( '#manageUsers' ).on( 'click', function(){
	list_inventoryusers();
});
</script>
