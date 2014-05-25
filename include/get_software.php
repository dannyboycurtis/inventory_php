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
SELECT	s.software_id,
		s.software_name,
		AES_DECRYPT( s.license_num, ? ),
		s.license_type,
		s.number_of_licenses,
		s.notes,
		s.purchase_id,
		p.purchase_order,
		p.purchase_date,
		p.purchased_by
FROM software s
		LEFT OUTER JOIN purchase p ON s.purchase_id = p.purchase_id

WHERE s.software_id = ? LIMIT 1";


if ( $stmt = $mysqli->prepare( $query_stmt ) ) 
{
	$lic_salt = LIC_SALT;

	$stmt->bind_param( "ss", $lic_salt, $query );
 	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $software_id,
						$software_name,
						$license_num,
						$license_type,
						$number_of_licenses,
						$notes,
						$purchase_id,
						$purchase_order,
						$purchase_date,
						$purchased_by );

	$stmt->fetch();

		// Set results and headers arrays
		$results[] = array( "software_id" => $software_id,
							"software_name" => $software_name, 
		 					"license_num" => $license_num,
							"license_type" => $license_type,
							"number_of_licenses" => $number_of_licenses,
							"notes" => $notes,
							"purchase_id" => $purchase_id,
							"purchase_order" => $purchase_order, 
							"purchase_date" => $purchase_date,
							"purchased_by" => $purchased_by );
}

echo json_encode( $results );

?>
