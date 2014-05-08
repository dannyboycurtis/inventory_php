<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

if ( !isset( $_POST['query'] ) )
	header( 'Location: ../portal.php' );

$query = $_POST['query'];

$query_stmt = "
SELECT	e.tag_num,
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

if ( $_POST['query'] == '_computers' )
	$query_stmt .= "JOIN uses us ON e.tag_num = us.tag_num 
					JOIN user u ON us.user_id = u.user_id 
					WHERE u.l_name IS NOT NULL 
					GROUP BY e.tag_num 
					ORDER BY e.tag_num DESC";

else if ( $_POST['query'] == '_labs' )
	$query_stmt .= "JOIN uses us ON e.tag_num = us.tag_num 
					JOIN user u ON us.user_id = u.user_id
					WHERE u.l_name IS NULL
					GROUP BY e.tag_num 
					ORDER BY p.purchase_date DESC";

else if ( $_POST['query'] == '_printers' )
	$query_stmt .= "WHERE pr.printer_tag IS NOT NULL
					ORDER BY pr.hostname ASC";

else
	$query_stmt .= "WHERE e.tag_num LIKE ? 
					OR e.serial LIKE ? 
					OR e.make LIKE ? 
					OR e.model LIKE ? 
					OR e.department LIKE ? 
					OR c.os LIKE ? 
					OR c.hostname LIKE ? 
					OR pr.hostname LIKE ? 
					OR p.purchase_order LIKE ? 
					OR p.purchase_date LIKE ? 
					OR p.purchased_by LIKE ? 
					OR n.mac LIKE ? 
					OR n.wmac LIKE ? 
					OR n.ip LIKE ? 
					GROUP BY e.tag_num 
					ORDER BY e.tag_num DESC";


if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
{
	unset( $results );

	$q = '%' . $query . '%';

	if ( $query != "_computers" or $query != "_labs" or $query != "_printers" )
		$stmt->bind_param( "ssssssssssssss", $q, $q, $q, $q, $q, $q, $q, $q, $q, $q, $q, $q, $q, $q );

 	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $tag,
						$serial,
						$makemodel,
						$department,
						$offcampus,
						$location, 
						$mac,
						$wmac,
						$ip,
						$description,
						$notes,
						$printer,
						$purchase_order,
						$purchase_date,
						$purchased_by,
						$os,
						$hostname,
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

		$get_software_from_tag = "SELECT s.software_name, s.software_id
								  FROM software s JOIN licensed_to l ON s.software_id = l.software_id
								  WHERE l.computer_tag = ?";

		// Query software for current record
		if ( $stmt3 = $mysqli->prepare( $get_software_from_tag ) )
		{
			$stmt3->bind_param( "s", $tag );
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result( $software_name, $software_id );

			while ( $stmt3->fetch() )
				$software[] = array( "name" => $software_name, "softwareid" => $software_id );

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
}

echo json_encode( $results );

?>
