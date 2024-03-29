<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

else if ( isset( $_POST['data'] ) )
{
	$mysqli = inventory_db_connect();

	$user_input = json_decode( $_POST['data'], true );

	// update purchase
	$query_stmt = "UPDATE purchase SET purchase_order = ?, purchase_date = ?, purchased_by = ? WHERE purchase_id = ? LIMIT 1";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ssss', $user_input["purchase_order"], $user_input["purchase_date"], $user_input["purchased_by"], $user_input["purchase_id"] );
		$stmt->execute();

		$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

		if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
		{
			$now = date( 'm/d/Y - h:i:s a' );
			$type = "UPDATE - purchase";

			if ( !( $user_input["purchase_order"] ) )
				$record = "N/A - " . $user_input["purchase_date"];

			else
				$record = $user_input["purchase_order"] . " - " . $user_input["purchase_date"];

			$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
			$stmt2->execute();
		}
	}	

	$result = array( "message" => "The record was successfully updated", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"] );
	
	echo json_encode( $result ) ;
}
?>
