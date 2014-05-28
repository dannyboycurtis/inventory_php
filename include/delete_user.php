<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

if ( $_SESSION["role"] < 4 )
	header( 'Location: ../portal.php' );

$delete_stmt = "DELETE FROM users WHERE username = ? LIMIT 1";

if ( $stmt = $mysqli->prepare( $delete_stmt ) ) 
{
	$stmt->bind_param( 's', $_POST["uname"] );
	$stmt->execute();
	$stmt->store_result();
	
	if ( $stmt->affected_rows == 1 )
		echo '1';

	else
		echo '0';
}
?>
