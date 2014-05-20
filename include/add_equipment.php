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
		echo "New purchase insert failed!";
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
		$user_id = $stmt->insert_id;

		if ( $user_id )
			$user_input["users"][] = $user_id;
	}

	else
		echo "New user insert failed!";
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
				$user_id = $stmt->insert_id;
		
				if ( $user_id )
					$user_input["users"][] = $user_id;
			}
		}
	}

	else
		echo "Lab user insert failed!";
}

else if ( $user_input["lab_id"] )
	$user_input["users"][] = $user_input["lab_id"];


// add equipment
$query_stmt = "INSERT IGNORE INTO equipment VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ? )";

if ( $stmt = $mysqli->prepare( $query_stmt ) )
{
	$stmt->bind_param( 'sssssssss', $user_input["tag_num"], $user_input["serial"], $user_input["make"], $user_input["model"], $user_input["department"], $user_input["location"], $user_input["building"], $user_input["room_num"], $purchase_id );
	$stmt->execute();
	if ( $stmt->affected_rows != 1 )
		echo "Equipment insert failed!";
}

else
	echo "Equipment insert failed!";

if ( isset( $user_input["mac"] ) or isset( $user_input["wmac"] ) or isset( $user_input["ip"] ) )
{
	// add eq_network entry
	$query_stmt = "INSERT IGNORE INTO eq_network VALUES( ?, ?, ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ssss', $user_input["tag_num"], $user_input["mac"], $user_input["wmac"], $user_input["ip"] );
		$stmt->execute();
		if ( $stmt->affected_rows != 1 )
			echo "Network insert failed!";
	}

	else
		echo "Network insert failed!";
}

if ( isset( $user_input["notes"] ) )
{
	// add eq_notes entry
	$query_stmt = "INSERT IGNORE INTO eq_notes VALUES( ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ss', $user_input["notes"], $user_input["tag_num"] );
		$stmt->execute();
		if ( $stmt->affected_rows != 1 )
			echo "Notes insert failed!";
	}

	else
		echo "Notes insert failed!";
}


// add network_printer entry if eqtype is printer
if ( $user_input["eqtype"] == "printer" )
{
	// add network_printer entry
	$query_stmt = "INSERT IGNORE INTO network_printer VALUES ( ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ss', $user_input["hostname"], $user_input["tag_num"] );
		$stmt->execute();
		if ( $stmt->affected_rows != 1 )
			echo "Network Printer insert failed!";
	}

	else
		echo "Network Printer insert failed!";
}

// add users and software if eqtype is computer or other
if ( $user_input["eqtype"] == "computer" or $user_input["eqtype"] == "other" )
{
	// add uses entries
	$query_stmt = "INSERT IGNORE INTO uses VALUES( ?, ? )";

	$usersfailed = 0;

	foreach( $user_input["users"] as $user )
	{
		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ss', $user, $user_input["tag_num"] );
			$stmt->execute();
			if ( $stmt->affected_rows != 1 )
				$usersfailed++;
		}
	}
}

// add description
if ( isset( $user_input["description"] ) )
{
	// add eq_description entry
	$query_stmt = "INSERT IGNORE INTO eq_description VALUES ( ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ss', $user_input["description"], $user_input["tag_num"] );
		$stmt->execute();
		if ( $stmt->affected_rows != 1 )
			echo "Description insert failed!";
	}

	else
		echo "Description insert failed!";
}

// add licensed_to, computer, eq_printer if eqtype is computer
if ( $user_input["eqtype"] == "computer" )
{
	// add computer entry
	$query_stmt = "INSERT IGNORE INTO computer VALUES ( ?, ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'sss', $user_input["hostname"], $user_input["os"], $user_input["tag_num"] );
		$stmt->execute();
		if ( $stmt->affected_rows != 1 )
			echo "Computer insert failed!";
	}

	else
		echo "Computer insert failed!";

	// add licensed_to entries
	$query_stmt = "INSERT IGNORE INTO licensed_to VALUES ( ?, ? )";

	$softwarefailed = 0;

	echo $user_input["software"][0];
	foreach( $user_input["software"] as $software )
	{
		if ( $stmt = $mysqli->prepare( $query_stmt ) )
		{
			$stmt->bind_param( 'ss', $software, $user_input["tag_num"] );
			$stmt->execute();
			if ( $stmt->affected_rows != 1 )
				$softwarefailed++;

			echo "softwaresuccess!!!!";
		}

		else
			echo "Software insert failed!";
	}

	// add eq_printer entry
	$query_stmt = "INSERT IGNORE INTO eq_printer VALUES ( ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ss', $user_input["printer"], $user_input["tag_num"] );
		$stmt->execute();
		if ( $stmt->affected_rows != 1 )
			echo "Eq_printer insert failed!";
	}

	else
		echo "Eq_printer insert failed!";
}


echo "Success!";

?>
