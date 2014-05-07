 <?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

if ( $_POST['query'] == "_all" )
	$query = "SELECT	 	p.purchase_id,
											p.purchase_order,
											p.purchase_date,
											p.purchased_by
						FROM			purchase p
						WHERE			p.purchase_order IS NOT NULL
						ORDER BY	p.purchase_date DESC";

else
	$query = "SELECT	 	p.purchase_id,
											p.purchase_order,
											p.purchase_date,
											p.purchased_by
						FROM			purchase p
						WHERE			p.purchase_order LIKE ? OR
											p.purchase_date LIKE ? OR
											p.purchased_by LIKE ?
						ORDER BY	p.purchase_date DESC";

if ( $stmt = $mysqli->prepare( $query ) ) 
{
	unset( $results );

	if ( $_POST['query'] != "_all" )
	{
		$word = '%' . $_POST['query'] . '%';
		$stmt->bind_param( "sss", $word, $word, $word );
	}

 	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $purchase_id,
						$purchase_order,
						$purchase_date,
						$purchased_by );

	while ( $stmt->fetch() )
	{
		unset( $equipment, $software );			

		$get_equipment_from_purchase_id = "SELECT 	e.tag_num,
																								e.serial,
																								CONCAT( e.make, ' ', e.model ),
																								e.location,
																								CONCAT( e.building, ' ', e.room_num ),
																								e.department
																				FROM		equipment e
																				WHERE		e.purchase_id = ?";

		// Query equipment for current purchase
		if ( $stmt2 = $mysqli->prepare( $get_equipment_from_purchase_id ) )
		{
			$stmt2->bind_param( "s", $purchase_id );
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result( $tag,
													 $serial,
													 $makemodel,
													 $offcampus,
													 $location,
													 $department );

			while ( $stmt2->fetch() )
			{
				if ( $offcampus == "off" )
					$location = "Off Campus";

				$equipment[] = array( "tag" => $tag,
									  					"serial" => $serial,
															"makemodel" => $makemodel,
															"location" => $location,
															"department" => $department );
			}

			$stmt2->close();
		}

		$get_software_from_purchase_id = "SELECT 	s.software_name,
																							s.license_type,
																							s.number_of_licenses
																			FROM		software s
																			WHERE		s.purchase_id = ?";

		// Query software for current purchase
		if ( $stmt3 = $mysqli->prepare( $get_software_from_purchase_id ) )
		{
			$stmt3->bind_param( "s", $purchase_id );
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result( $software_name,
													 $license_type,
													 $number_of_licenses );

			while ( $stmt3->fetch() )
			{
				$software[] = array( "s_name" => $software_name,
									  					"type" => $license_type,
															"quantity" => $number_of_licenses );
			}

			$stmt3->close();
		}
		// Set results and headers arrays
		$results[] = array( "purchaseid" => $purchase_id,
												"purchaseorder" => $purchase_order, 
	 											"purchasedate" => $purchase_date,
												"purchasedby" => $purchased_by,
												"equipment" => $equipment,
												"software" => $software, );
	}
}
echo json_encode( $results );

?>
