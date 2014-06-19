<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

else if ( isset( $_POST['record_id'] ) and isset( $_POST['type'] ) )
{
	$mysqli = inventory_db_connect();

	$record_id = $_POST['record_id'];

	if ( $_POST['type'] == 'equipment' )
	{
		$delete_stmt = "DELETE FROM equipment WHERE tag_num = ? LIMIT 1";

		$record = $record_id;
	}

	else if ( $_POST['type'] == 'user' )
	{
		$delete_stmt = "DELETE FROM user WHERE user_id = ? LIMIT 1";

		$query_stmt = "SELECT CONCAT( u.f_name, ' ', u.l_name ) FROM user u WHERE u.user_id = ? LIMIT 1";

		if ( $stmt2 = $mysqli->prepare( $query_stmt ) )
		{
			$stmt2->bind_param( 's', $record_id );
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result( $name );
			$stmt2->fetch();
			$record = $name;
		}
	}

	else if ( $_POST['type'] == 'software' )
	{
		$delete_stmt = "DELETE FROM software WHERE software_id = ? LIMIT 1";

		$query_stmt = "SELECT CONCAT( software_name, ' ', license_type ) FROM software WHERE software_id = ? LIMIT 1";

		if ( $stmt2 = $mysqli->prepare( $query_stmt ) )
		{
			$stmt2->bind_param( 's', $record_id );
			$stmt2->execute();
			$stmt2->bind_result( $name );
			$stmt2->fetch();
			$record = $name;
		}
	}

	if ( $stmt = $mysqli->prepare( $delete_stmt ) ) 
	{
		$stmt->bind_param( 's', $record_id );
		$stmt->execute();
	
		if ( $stmt->affected_rows == 1 )
		{	
			echo '1';

			$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

			if ( $stmt3 = $mysqli->prepare( $activity_stmt ) )
			{
				$now = date( 'm/d/Y - h:i:s a' );
				$type = "DELETE - " . $_POST['type'];

				$stmt3->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
				$stmt3->execute();
			}
		}

		else
			echo '0';
	}
}
?>
