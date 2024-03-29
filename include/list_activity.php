<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

else
{
	$mysqli = inventory_db_connect();

	if ( $_POST['user'] == "_all" and $_SESSION['role'] == 4 )
		$query = "SELECT inventory_user, timestamp, type, record_id FROM activity ORDER BY timestamp DESC";

	else if ( isset( $_POST['user'] ) )
		$query = "SELECT inventory_user, timestamp, type, record_id FROM activity WHERE inventory_user = ? ORDER BY timestamp DESC";

	if ( $stmt = $mysqli->prepare( $query ) ) 
	{
		unset( $results );

		if ( $_POST['user'] != "_all" )		
			$stmt->bind_param( "s", $_POST['user'] );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $username,
							$timestamp,
							$operation,
							$record );

		while ( $stmt->fetch() )
		{	
			// Set results and headers arrays
			$results[] = array( "username" => $username,
								"timestamp" => $timestamp, 
		 						"operation" => $operation,
								"record" => $record );
		}
	}

	$_SESSION["querytype"] = "activity";
	$_SESSION["query"] = $_POST["user"];

	echo json_encode( $results );
}
?>
