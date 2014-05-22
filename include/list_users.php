<?php
include_once 'common.php';
include_once 'query_index.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

if ( $_POST['query'] == "_all" )
	$query = "SELECT	u.user_id, 
						u.f_name, 
						u.l_name,
						u.email,
						u.phone
			  FROM		user u
			  WHERE		u.l_name IS NOT NULL
			  ORDER BY	u.l_name ASC";

else
	$query = "SELECT	u.user_id, 
						u.f_name, 
						u.l_name,
						u.email,
						u.phone
			  FROM		user u
			  WHERE		( u.f_name LIKE ? OR
						u.l_name LIKE ? OR
						u.email LIKE ? OR
						u.phone LIKE ?  ) AND
						u.l_name IS NOT NULL
			  ORDER BY	u.l_name ASC";

if ( $stmt = $mysqli->prepare( $query ) ) 
{
	unset( $results );

	if ( $_POST['query'] != '_all' )
	{
		$word = '%' . $_POST['query'] . '%';
		$stmt->bind_param( "ssss", $word, $word, $word, $word );
	}

 	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $user_id,
						$f_name,
						$l_name,
						$email,
						$phone );

	while ( $stmt->fetch() )
	{
		unset( $equipment );			

		$get_equipment_from_user = "SELECT 	e.tag_num,
											e.serial,
											CONCAT( e.make, ' ', e.model ),
											e.location,
											CONCAT( e.building, ' ', e.room_num ),
											e.department
									FROM	equipment e JOIN uses us ON e.tag_num = us.tag_num
									WHERE	us.user_id = ?";

		// Query equipment for current user
		if ( $stmt2 = $mysqli->prepare( $get_equipment_from_user ) )
		{
			$stmt2->bind_param( "s", $user_id );
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

		// Set results and headers arrays
		$results[] = array( "userid" => $user_id,
												"firstname" => $f_name, 
	 											"lastname" => $l_name,
												"email" => $email,
												"phone" => $phone,
												"equipment" => $equipment, );
	}
}

$_SESSION["querytype"] = "users";
$_SESSION["query"] = $_POST["query"];

echo json_encode( $results );

?>
