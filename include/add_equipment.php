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

	// add new user
	if ( $user_input["new_user"] )
	{
		$f_name = $user_input["new_user"]["f_name"];
		$l_name = $user_input["new_user"]["l_name"];
		$email = $user_input["new_user"]["email"];
		$phone = $user_input["new_user"]["phone"];

		$query_stmt = "INSERT INTO user ( f_name, l_name, email, phone ) VALUES ( ?, ?, ?, ? )";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ssss', $f_name, $l_name, $email, $phone );
			$stmt->execute();
			$user_input["users"][] = $stmt->insert_id;

			$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

			if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
			{
				$now = date( 'm/d/Y - h:i:s a' );
				$type = "INSERT - user";
				$record = $f_name . " " . $l_name;

				$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
				$stmt2->execute();
			}
		}

		else
			$error .= "userinsert;";
	}

	// add new lab
	if ( $user_input["lab_name"] )
	{
		$lab_name = $user_input["lab_name"];

		$query_stmt = "SELECT DISTINCT user_id FROM user WHERE f_name = ? AND l_name IS NULL LIMIT 1";

		// check if this name exists already
		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $lab_name );
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result( $uid );

			if ( $stmt->num_rows )
			{
				$stmt->fetch();		
				$user_input["users"][] = $uid;
			}

			else
			{
				$query_stmt = "INSERT INTO user ( f_name ) VALUES ( ? )";

				if ( $stmt = $mysqli->prepare( $query_stmt ) )
				{
					$stmt->bind_param( 's', $lab_name );
					$stmt->execute();
					$user_input["users"][] = $stmt->insert_id;
		
					$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

					if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
					{
						$now = date( 'm/d/Y - h:i:s a' );
						$type = "INSERT - user(lab)";
						$record = $lab_name;

						$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
						$stmt2->execute();
					}
				}

				else $error .= "userinsert;";
			}
		}

		else
			$error .= "userselect;";
	}

	else if ( $user_input["lab_id"] )
		$user_input["users"][] = $user_input["lab_id"];

	// add equipment
	$query_stmt = "INSERT INTO equipment VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ? )
					ON DUPLICATE KEY UPDATE serial = VALUES( serial ),
											make = VALUES( make ),
											model = VALUES( model ),
											department = VALUES( department ),
											location = VALUES( location ),
											building = VALUES( building ),
											room_num = VALUES( room_num ),
											purchase_id = VALUES( purchase_id )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'sssssssss', $user_input["tag_num"], $user_input["serial"], $user_input["make"], $user_input["model"], $user_input["department"], $user_input["location"], $user_input["building"], $user_input["room_num"], $purchase_id );
		$stmt->execute();
	}

	else
		$error .= "equipmentinsert;";

	if ( isset( $user_input["mac"] ) or isset( $user_input["wmac"] ) or isset( $user_input["ip"] ) )
	{
		// add eq_network entry
		$query_stmt = "INSERT INTO eq_network VALUES( ?, ?, ?, ? )
						ON DUPLICATE KEY UPDATE mac = VALUES( mac ), wmac = VALUES( wmac ), ip = VALUES( ip )";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ssss', $user_input["tag_num"], $user_input["mac"], $user_input["wmac"], $user_input["ip"] );
			$stmt->execute();
		}

		else
			$error .= "networkinsert;";
	}

	if ( $user_input["notes"] )
	{
		// add eq_notes entry
		$query_stmt = "INSERT INTO eq_notes VALUES( ?, ? )
						ON DUPLICATE KEY UPDATE notes = VALUES( notes )";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ss', $user_input["notes"], $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "notesinsert;";
	}

	else
	{
		// delete eq_notes entry
		$query_stmt = "DELETE FROM eq_notes WHERE tag_num = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}
	}

	// add network_printer entry if eqtype is printer
	if ( $user_input["eqtype"] == "printer" )
		{
		// add network_printer entry
		$query_stmt = "INSERT INTO network_printer VALUES ( ?, ? )
						ON DUPLICATE KEY UPDATE hostname = VALUES( hostname )";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ss', $user_input["hostname"], $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "networkprinterinsert;";

		// delete entries in eq_description and computer
		$query_stmt = "DELETE FROM eq_description WHERE tag_num = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "deletedesc;";

		$query_stmt = "DELETE FROM computer WHERE computer_tag = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "deletecomputer;";
	}

	// add users and software if eqtype is computer or other
	if ( $user_input["eqtype"] == "computer" or $user_input["eqtype"] == "other" )
	{
		// delete removed uses
		$query_stmt = "DELETE FROM uses WHERE tag_num = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		// add uses entries
		$query_stmt = "INSERT INTO uses VALUES( ?, ? )";

		foreach( $user_input["users"] as $user )
		{
			if ( $stmt = $mysqli->prepare( $query_stmt ) )
			{
				$stmt->bind_param( 'ss', $user, $user_input["tag_num"] );
				$stmt->execute();
			}

			else
				$error .= "usesinsert;";
		}
	}

	// add description
	if ( $user_input["eqtype"] == "other" )
	{
		// add eq_description entry
		$query_stmt = "INSERT INTO eq_description VALUES ( ?, ? ) ON DUPLICATE KEY UPDATE description = VALUES( description )";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ss', $user_input["description"], $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "descinsert;";

		// delete network_printer, computer entries
		$query_stmt = "DELETE FROM network_printer WHERE printer_tag = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "deletenetprint;";

		$query_stmt = "DELETE FROM computer WHERE computer_tag = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "deletecomp;";
	}

	// add licensed_to, computer, eq_printer if eqtype is computer
	if ( $user_input["eqtype"] == "computer" )
	{
		// add computer entry
		$query_stmt = "INSERT INTO computer VALUES ( ?, ?, ? ) ON DUPLICATE KEY UPDATE hostname = VALUES( hostname ), os = VALUES( os )";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'sss', $user_input["hostname"], $user_input["os"], $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "compinsert;";

		// delete network_printer, eq_description entries
		$query_stmt = "DELETE FROM network_printer WHERE printer_tag = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "deletenetprint;";

		$query_stmt = "DELETE FROM eq_description WHERE tag_num = ?";

		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 's', $user_input["tag_num"] );
			$stmt->execute();
		}

		else
			$error .= "deletedesc;";

		// add licensed_to entries
		$query_stmt = "INSERT INTO licensed_to VALUES ( ?, ? )";

		foreach( $user_input["software"] as $software )
		{
			if ( $stmt = $mysqli->prepare( $query_stmt ) )
			{
				$stmt->bind_param( 'ss', $software, $user_input["tag_num"] );
				$stmt->execute();
			}

			else
				$error .= "licenseinsert;";
		}

		// add eq_printer entry
		if ( isset( $user_input["printer"] ) )
		{
			$query_stmt = "INSERT INTO eq_printer VALUES ( ?, ? ) ON DUPLICATE KEY UPDATE printer = VALUES( printer )";

			if ( $stmt = $mysqli->prepare( $query_stmt ) )
			{
				$stmt->bind_param( 'ss', $user_input["printer"], $user_input["tag_num"] );
				$stmt->execute();
			}
		}

		else
		{
			$query_stmt = "DELETE FROM eq_printer WHERE tag_num = ?";

			if ( $stmt = $mysqli->prepare( $query_stmt ) )
			{
				$stmt->bind_param( 's', $user_input["tag_num"] );
				$stmt->execute();
			}
		}
	}

	if ( $user_input["operation"] == "insert" )
	{
		$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

		if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
		{
			$now = date( 'm/d/Y - h:i:s a' );
			$type = "INSERT - equipment";
			$record = $user_input["tag_num"];

			$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
			$stmt2->execute();
		}

		$result = array( "message" => "The record was successfully added", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"] );

		echo json_encode( $result ) ;
	}

	else if ( $user_input["operation"] == "update" )
	{
		$activity_stmt = "INSERT INTO activity VALUES ( ?, ?, ?, ? )";

		if ( $stmt2 = $mysqli->prepare( $activity_stmt ) )
		{
			$now = date( 'm/d/Y - h:i:s a' );
			$type = "UPDATE - equipment";
			$record = $user_input["tag_num"];

			$stmt2->bind_param( 'ssss', $_SESSION["username"], $now, $type, $record );
			$stmt2->execute();
		}

		$result = array( "message" => "The record was successfully updated", "query" => $_SESSION["query"], "querytype" => $_SESSION["querytype"], "errors" => $error );

		echo json_encode( $result ) ;
	}
}
?>
