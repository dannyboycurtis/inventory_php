<?php
include_once 'common.php';
$mysqli = inventory_db_connect();

if ( isset( $_POST['query'] ) )
{
	$query = $_POST['query'];

	$query_stmt = "SELECT CONCAT( f_name, ' ', l_name ) FROM user WHERE f_name LIKE '%{$query}%' OR l_name LIKE '%{$query}%'";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->execute();
		$stmt->bind_result( $name );

		while ( $stmt->fetch() )
			$results[] = $name;
	}

	echo json_encode($results);
}
?>



