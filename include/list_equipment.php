<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

else if ( isset( $_POST['query'] ) )
{
	$mysqli = inventory_db_connect();

	$query = $_POST['query'];

	$query_stmt = "SELECT e.tag_num,
							e.serial, 
							CONCAT( e.make, ' ', e.model ), 
							e.department, 
							e.location, 
							CONCAT( e.building, ' ', e.room_num ),
							n.mac,
							n.wmac,
							n.ip,
							eqd.description,
							eqn.notes,
							eqp.printer,
							p.purchase_order,
							p.purchase_date,
							p.purchased_by,
							c.os,
							c.hostname,
							pr.hostname
					FROM equipment e
						LEFT OUTER JOIN purchase p ON e.purchase_id = p.purchase_id
						LEFT OUTER JOIN computer c ON e.tag_num = c.computer_tag
						LEFT OUTER JOIN network_printer pr ON e.tag_num = pr.printer_tag
						LEFT OUTER JOIN eq_network n ON e.tag_num = n.tag_num
						LEFT OUTER JOIN eq_description eqd ON e.tag_num = eqd.tag_num
						LEFT OUTER JOIN eq_notes eqn ON e.tag_num = eqn.tag_num
						LEFT OUTER JOIN eq_printer eqp ON e.tag_num = eqp.tag_num ";

	if ( $query == '_computers' )
	{
		$query_stmt .= "JOIN uses us ON e.tag_num = us.tag_num 
						JOIN user u ON us.user_id = u.user_id 
						WHERE u.l_name IS NOT NULL 
						GROUP BY e.tag_num 
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
			$stmt->execute();
	}

	else if ( $query == '_labs' )
	{
		$query_stmt .= "JOIN uses us ON e.tag_num = us.tag_num 
						JOIN user u ON us.user_id = u.user_id
						WHERE u.l_name IS NULL
						GROUP BY e.tag_num 
						ORDER BY p.purchase_date DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
			$stmt->execute();
	}

	else if ( $query == '_printers' )
	{
		$query_stmt .= "WHERE pr.printer_tag IS NOT NULL
						ORDER BY pr.hostname ASC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
			$stmt->execute();
	}

	else if ( $_POST['type'] == 'tag_num' )
	{
		$query_stmt .= "WHERE e.tag_num = ?
						GROUP BY e.tag_num 
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'serial' )
	{
		$query_stmt .= "WHERE e.serial = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'make' )
	{
		$query_stmt .= "WHERE e.make = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'makemodel' )
	{
		$querywords = explode( "/", $query );

		$query_stmt .= "WHERE e.make = ? AND e.model = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 'ss', $querywords[0], $querywords[1] );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'department' )
	{
		$query_stmt .= "WHERE e.department = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'hostname' )
	{
		$query_stmt .= "WHERE c.hostname = ? OR pr.hostname = ? 
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 'ss', $query, $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'ip' )
	{
		$query_stmt .= "WHERE n.ip = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'mac' )
	{
		$query_stmt .= "WHERE n.mac = ? OR n.wmac = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 'ss', $query, $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'purchasedby' )
	{
		$query_stmt .= "WHERE p.purchased_by = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'purchasedate' )
	{
		$query_stmt .= "WHERE p.purchase_date = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	else if ( $_POST['type'] == 'location' )
	{
		$query_stmt .= "WHERE e.location = ?
						GROUP BY e.tag_num
						ORDER BY e.tag_num DESC";

		if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
		{
			$stmt->bind_param( 's', $query );
			$stmt->execute();
		}
	}

	unset( $results );

	$stmt->store_result();
	$stmt->bind_result( $tag, $serial, $makemodel, $department, $offcampus, $location, 
						$mac, $wmac, $ip,
						$description, $notes, $printer,
						$purchase_order, $purchase_date, $purchased_by,
						$os, $hostname,
						$phostname );

	while ( $stmt->fetch() )
	{
		unset( $users, $software );				

		if ( $offcampus == 'off' )
			$location = "Off Campus";

		if ( !( $hostname ) and $phostname )
			$hostname = $phostname;				
	
		$get_users_from_tag = "SELECT u.user_id, u.f_name, u.l_name
							   FROM user u JOIN uses us ON u.user_id = us.user_id
							   WHERE us.tag_num = ?";

		// Query users for current record
		if ( $stmt2 = $mysqli->prepare( $get_users_from_tag ) )
		{
			$stmt2->bind_param( "s", $tag );
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result( $user_id, $firstname, $lastname );

			while ( $stmt2->fetch() )
				$users[] = array( "userid" => $user_id, "firstname" => $firstname, "lastname" => $lastname );

			$stmt2->close();
		}	

		$get_software_from_tag = "SELECT s.software_name, s.software_id, s.license_type
								  FROM software s JOIN licensed_to l ON s.software_id = l.software_id
								  WHERE l.computer_tag = ?";

		// Query software for current record
		if ( $stmt3 = $mysqli->prepare( $get_software_from_tag ) )
		{
			$stmt3->bind_param( "s", $tag );
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result( $software_name, $software_id, $license_type );

			while ( $stmt3->fetch() )
				$software[] = array( "name" => $software_name, "softwareid" => $software_id, "licensetype" => $license_type );

			$stmt3->close();
		}

		// Set results and headers arrays
		$results[] = array( "tag" => $tag, 
							"serial" => $serial, 
							"makemodel" => $makemodel, 
							"location" => $location,
							"department" => $department,
			 				"mac" => $mac,
			 				"wmac" => $wmac,
							"ip" => $ip,
							"description" => $description,
			 				"eq_notes" => $notes,							
							"eq_printer" => $printer,
							"purchase_order" => $purchase_order, 
							"purchase_date" => $purchase_date,
							"purchased_by" => $purchased_by,
			 				"os" => $os,
			 				"hostname" => $hostname,
		 					"software" => $software,
							"users" => $users, );
	}

	$_SESSION["querytype"] = $_POST["type"];
	$_SESSION["query"] = $_POST["query"];

	echo json_encode( $results );
}
?>
