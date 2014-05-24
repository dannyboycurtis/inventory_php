<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

if ( !isset( $_POST['data'] ) )
	header( 'Location: ../portal.php' );


$user_input = json_decode( $_POST['data'], true );

// add purchase
if ( !( $user_input["purchase_id"] ) )
{
	$purchase_order = $user_input["new_purchase"]["purchase_order"];
	$purchase_date = $user_input["new_purchase"]["purchase_date"];
	$purchased_by = $user_input["new_purchase"]["purchased_by"];

	$query_stmt = "SELECT purchase_id FROM purchase WHERE purchase_order = ? AND purchase_order IS NOT NULL LIMIT 1";
	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 's', $purchase_order );
		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $pid );		

		if ( $stmt->num_rows )
		{
			$stmt->fetch();
			$purchase_id = $pid;
		}

		else
		{
			$query_stmt = "INSERT INTO purchase ( purchase_order, purchase_date, purchased_by ) VALUES ( ?, ?, ? )";

			if ( $stmt = $mysqli->prepare( $query_stmt ) )
			{
				$stmt->bind_param( 'sss', $purchase_order, $purchase_date, $purchased_by );
 				$stmt->execute();
				$purchase_id = $stmt->insert_id;
			}	
		}
	}

	else
		$error .= "purchaseinsert;";
}

else
	$purchase_id = $user_input["purchase_id"];


// add software

if ( $user_input["software_id" ] )
{
	$query_stmt = "UPDATE software SET software_name = ?, license_num = ?, license_type = ?, number_of_licenses = ?, notes = ?, purchase_id = ? WHERE software_id = ?";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'sssssss', $user_input["software_name"], $user_input["license_num"], $user_input["license_type"], $user_input["number_of_licenses"], $user_input["notes"], $user_input["purchase_id"], $user_input["software_id"] );
		$stmt->execute();
	}

	else
		$error .="softwareupdate;";
}

else
{
	$query_stmt = "INSERT IGNORE INTO software ( software_name, license_num, license_type, number_of_licenses, notes, purchase_id ) VALUES( ?, ?, ?, ?, ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ssssss', $user_input["software_name"], $user_input["license_num"], $user_input["license_type"], $user_input["number_of_licenses"], $user_input["notes"], $purchase_id );
		$stmt->execute();
	}

	else
		$error .= "softwareinsert;";
}


if ( $user_input["operation"] == "insert" )
{
	$result = array( "message" => "The record was successfully added", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

	echo json_encode( $result ) ;

}

else if ( $user_input["operation"] == "update" )
{
	$result = array( "message" => "The record was successfully updated", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

	echo json_encode( $result ) ;
}

?>
