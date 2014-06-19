<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();
 
if ( isset( $_POST['user'], $_POST['p'] ) )
{
	$user = $_POST['user'];
    $password = $_POST['p'];
 
	$login_status = login( $user, $password, $mysqli );

    if ( $login_status == 'success' )
        header( 'Location: ../portal.php' );
	
	else
	{
        $info = "?user=" .$user. "&error=" .$login_status;
		header( "Location: ../index.php" . $info );
	}
} 

else 
	echo 'Login Failure!'; 
?>
