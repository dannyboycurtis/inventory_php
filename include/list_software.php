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

	if ( $_POST['query'] == "_all" )
		$query = "SELECT s.software_id,
							s.software_name,
							AES_DECRYPT( s.license_num, ? ),
							s.license_type,
							s.number_of_licenses,
							s.notes,
							p.purchase_date
					FROM software s JOIN purchase p ON s.purchase_id = p.purchase_id
					ORDER BY s.software_name ASC";

	else
		$query = "SELECT s.software_id,
							s.software_name,
							AES_DECRYPT( s.license_num, ? ),
							s.license_type,
							s.number_of_licenses,
							s.notes,
							p.purchase_date
					FROM software s JOIN purchase p ON s.purchase_id = p.purchase_id
					WHERE s.software_name LIKE ? OR
							s.license_num LIKE ? OR
							s.license_type LIKE ? OR
							s.notes LIKE ?
					ORDER BY s.software_name ASC";

	if ( $stmt = $mysqli->prepare( $query ) ) 
	{
		unset( $results );

		$lic_salt = LIC_SALT;

		if ( $_POST['query'] != '_all' )
		{
			$word = '%' . $_POST['query'] . '%';
			$stmt->bind_param( "sssss", $lic_salt, $word, $word, $word, $word );
		}

		else
			$stmt->bind_param( "s", $lic_salt ); 

	 	$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $software_id, $software_name, $license_num, $license_type, $number_of_licenses, $notes, $purchase_date );

		while ( $stmt->fetch() )
		{
			unset( $equipment );			

			$get_computers_from_software_id = "SELECT e.tag_num,
														e.serial,
														CONCAT( e.make, ' ', e.model ),
														e.location,
														CONCAT( e.building, ' ', e.room_num ),
														e.department
												FROM equipment e JOIN computer c ON e.tag_num = c.computer_tag,
														licensed_to l
												WHERE c.computer_tag = l.computer_tag AND
														l.software_id = ?";

			// Query equipment for current software
			if ( $stmt2 = $mysqli->prepare( $get_computers_from_software_id ) )
			{
				$stmt2->bind_param( "s", $software_id );
				$stmt2->execute();
				$stmt2->store_result();
				$stmt2->bind_result( $tag, $serial, $makemodel, $offcampus, $location, $department );

				while ( $stmt2->fetch() )
				{
					if ( $offcampus == "off" )
						$location = "Off Campus";

					$equipment[] = array( "tag" => $tag, "serial" => $serial, "makemodel" => $makemodel, "location" => $location, "department" => $department );
				}

				$stmt2->close();
			}

			// Set results and headers arrays
			$results[] = array( "softwareid" => $software_id,
								"softwarename" => $software_name, 
								"licensenumber" => $license_num,
								"licensetype" => $license_type,
								"licensequantity" => $number_of_licenses,
								"purchasedate" => $purchase_date,
								"notes" => $notes,
								"equipment" => $equipment, );
		}
	}

	$_SESSION["querytype"] = "software";
	$_SESSION["query"] = $_POST["query"];

	echo json_encode( $results );
}
?>
