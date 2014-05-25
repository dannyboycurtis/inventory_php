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

$error = "";

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

				$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

				if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
				{
					$now = date( 'm/d/Y - h:i:s a' );
					$type = "INSERT - purchase";

					if ( !( $purchase_order ) )
						$record = "N/A - " . $purchase_date;

					else
						$record = $purchase_order . " - " . $purchase_date;

					$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
					$stmt2->execute();
				}

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
	$query_stmt = "UPDATE software SET software_name = ?, license_num = AES_ENCRYPT( ?, ? ), license_type = ?, number_of_licenses = ?, notes = ?, purchase_id = ? WHERE software_id = ?";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$lic_salt = LIC_SALT;
		$stmt->bind_param( 'ssssssss', $user_input["software_name"], $user_input["license_num"], $lic_salt, $user_input["license_type"], $user_input["number_of_licenses"], $user_input["notes"], $user_input["purchase_id"], $user_input["software_id"] );
		$stmt->execute();
	}

	else
		$error .="softwareupdate;";
}

else
{
	$query_stmt = "INSERT INTO software ( software_name, license_num, license_type, number_of_licenses, notes, purchase_id ) VALUES( ?, AES_ENCRYPT( ?, ? ), ?, ?, ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$lic_salt = LIC_SALT;
		$stmt->bind_param( 'sssssss', $user_input["software_name"], $user_input["license_num"], $lic_salt, $user_input["license_type"], $user_input["number_of_licenses"], $user_input["notes"], $purchase_id );
		$stmt->execute();
	}

	else
		$error .= "softwareinsert;";
}


if ( $user_input["operation"] == "insert" )
{
	$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

	if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
	{
		$now = date( 'm/d/Y - h:i:s a' );
		$type = "INSERT - software";
		$record = $user_input["software_name"] . " - " . $user_input["license_type"];

		$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
		$stmt2->execute();
	}

	$result = array( "message" => "The record was successfully added", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

	echo json_encode( $result ) ;

}

else if ( $user_input["operation"] == "update" )
{
	$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

	if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
	{
		$now = date( 'm/d/Y - h:i:s a' );
		$type = "UPDATE - software";
		$record = $user_input["software_name"] . " - " . $user_input["license_type"];

		$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
		$stmt2->execute();
	}

	$result = array( "message" => "The record was successfully updated", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

	echo json_encode( $result ) ;
}

?>
