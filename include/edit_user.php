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

	$error = "";

	$user_input = json_decode( $_POST['data'], true );

	// edit user
	$query_stmt = "UPDATE user SET f_name = ?, l_name = ?, email = ?, phone = ? WHERE user_id = ?";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'sssss', $user_input["f_name"], $user_input["l_name"], $user_input["email"], $user_input["phone"], $user_input["user_id"] );
		$stmt->execute();

		$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

		if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
		{
			$now = date( 'm/d/Y - h:i:s a' );
			$type = "UPDATE - user";
			$record = $_user_input["f_name"] . " " . $user_input["l_name"];

			$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
			$stmt2->execute();
		}
	}

	else
		$error .="userupdate;";

	if ( $error != "" )
		$result = array( "message" => "An error occurred!", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

	else
		$result = array( "message" => "The record was successfully updated", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

	echo json_encode( $result ) ;
}
?>
