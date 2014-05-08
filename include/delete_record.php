<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

if ( !isset( $_POST['record_id'] ) or !isset( $_POST['type'] ) )
	header( 'Location: ../portal.php' );

$record_id = $_POST['record_id'];

if ( $_POST['type'] == 'equipment' )
	$delete_stmt = "DELETE FROM equipment WHERE tag_num = ? LIMIT 1";

if ( $_POST['type'] == 'user' )
	$delete_stmt = "DELETE FROM user WHERE user_id = ? LIMIT 1";

if ( $_POST['type'] == 'software' )
	$delete_stmt = "DELETE FROM software WHERE software_id = ? LIMIT 1";

if ( $stmt = $mysqli->prepare( $delete_stmt ) ) 
{
	$stmt->bind_param( 's', $record_id );
	$stmt->execute();
	
	if ( $stmt->affected_rows == 1 )
		echo '1';

	else
		echo '0';
}
?>
