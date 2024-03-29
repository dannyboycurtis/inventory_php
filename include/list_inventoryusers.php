<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

else
{
	$query = "SELECT username, role FROM users WHERE username != 'admin'"; 

	if ( $stmt = $mysqli->prepare( $query ) ) 
	{		
 		$stmt->execute();
		$stmt->store_result();
		$stmt->bind_result( $user, $role );

		while ( $stmt->fetch() )
			$results[] = array( "user" => $user, "role" => $role );
	}

	$_SESSION["query"] = "_portal";

	echo json_encode( $results );
}
?>
