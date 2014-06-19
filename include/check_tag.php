<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

else if ( isset( $_POST['tag'] ) )
{
	$mysqli = inventory_db_connect();

	$query_stmt = "SELECT tag_num FROM equipment WHERE tag_num = ? LIMIT 1";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 's', $_POST['tag'] );
		$stmt->execute();
		$stmt->store_result();

		if ( $stmt->num_rows == 1 )
			echo "0";

		else
			echo "1";
	}
}
?>
