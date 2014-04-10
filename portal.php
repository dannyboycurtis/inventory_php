<?php

include_once 'include/common.php';
 
$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: login.php' );
	
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>CAL Inventory</title>


<link rel="shortcut icon" href="http://www.csusb.edu/images/favicon.ico">


  <!-- CSS -->
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/main.css">

  <!-- Javascript -->
  <script type="text/javascript" src="js/jquery-2.1.0.min.js"></script>
  <script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script type="text/javascript" src="js/bootstrap-typeahead.js"></script> 
  <script type="text/JavaScript" src="js/sha512.js"></script> 
  <script type="text/JavaScript" src="js/main.js"></script>

</head>
<body style="padding-top: 60px">

<!-- Top panel-->
<div class="container" id="navbar">
  <?php include 'include/template/navbar.php'; ?>
</div>


<!-- Bottom panel -->
<div class="container">
  <div class="row">


	<!-- Main Section -->
    <div id="main_content">
	  <?php include "include/template/main.php"; ?>


    </div><!-- end main section -->

  </div><!-- end row -->

</div><!-- end container -->
  
</body>
</html>
