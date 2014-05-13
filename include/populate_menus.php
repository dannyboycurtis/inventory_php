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

if ( $_POST['query'] == 'make' )
{
	$query_stmt = "SELECT DISTINCT e.make 
								 FROM equipment e 
									 INNER JOIN ( SELECT make, COUNT(*) total
																FROM equipment
																GROUP BY make ) e2 ON e.make = e2.make
								 WHERE e.make IS NOT NULL
								 ORDER BY e2.total DESC";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $make );

		while ( $stmt->fetch() )
			$results[] = $make;
	}	
}

else if ( isset( $_POST['make'] ) and $_POST['query'] == 'model_from_make' )
{
	$query_stmt = "SELECT DISTINCT model FROM equipment WHERE make = ? ORDER BY model ASC";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

		$stmt->bind_param( 's', $_POST['make'] );
 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $model );

		while ( $stmt->fetch() )
			$results[] = $model;
	}	
}

else if ( $_POST['query'] == 'department' )
{
	$query_stmt = "SELECT DISTINCT department FROM equipment WHERE department IS NOT NULL AND department != '' ORDER BY department ASC";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $department );

		while ( $stmt->fetch() )
			$results[] = $department;
	}	
}

else if ( $_POST['query'] == 'users' )
{
	$query_stmt = "SELECT user_id, f_name, l_name FROM user WHERE l_name IS NOT NULL ORDER BY l_name ASC";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $user_id, $f_name, $l_name );

		while ( $stmt->fetch() )
			$results[] = array( "userid" => $user_id, "fname" => $f_name, "lname" => $l_name );
	}	
}

else if ( $_POST['query'] == 'purchase_order' )
{
	$query_stmt = "SELECT purchase_id, purchase_order, purchase_date, purchased_by FROM purchase WHERE purchase_order IS NOT NULL";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $purchase_id, $purchase_order, $purchase_date, $purchased_by );

		while ( $stmt->fetch() )
			$results[] = array( "purchaseid" => $purchase_id,
								"purchaseorder" => $purchase_order,
								"purchasedate" => $purchase_date,
								"purchasedby" => $purchased_by );
	}	
}

else if ( $_POST['query'] == 'purchased_by' )
{
	$query_stmt = "SELECT DISTINCT purchased_by FROM purchase WHERE purchased_by IS NOT NULL";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $purchased_by);

		while ( $stmt->fetch() )
			$results[] = $purchased_by;
	}	
}
else if ( $_POST['query'] == 'os' )
{
	$query_stmt = "SELECT DISTINCT os FROM computer WHERE os IS NOT NULL ORDER BY os ASC";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $os );

		while ( $stmt->fetch() )
			$results[] = $os;
	}	
}

else if ( $_POST['query' ] == 'software' )
{
	$query_stmt = "SELECT software_id, software_name, license_type FROM software ORDER BY software_name ASC";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		unset( $results );

 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $software_id, $software_name, $license_type );

		while ( $stmt->fetch() )
			$results[] = array( "softwareid" => $software_id, "software_name" => $software_name, "licensetype" => $license_type );
	}	
}

echo json_encode( $results );

?>
