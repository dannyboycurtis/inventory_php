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

	$query_stmt = "INSERT INTO purchase ( purchase_order, purchase_date, purchased_by ) VALUES ( ?, ?, ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'sss', $purchase_order, $purchase_date, $purchased_by );
 		$stmt->execute();
		$purchase_id = $stmt->insert_id;

	}	
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
}

// add new lab
if ( $user_input["lab_name"] )
{
	$lab_name = $user_input["lab_name"];

	$query_stmt = "INSERT INTO user ( f_name ) VALUES ( ? )";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 's', $lab_name );
		$stmt->execute();
		$user_id = $stmt->insert_id;

		if ( $user_id )
			$user_input["users"][] = $user_id;

		// duplicate user found
		else
		{
			$query_stmt = "SELECT user_id FROM user WHERE f_name = ? LIMIT 1";

			if ( $stmt = $maysqli->prepare( $query_stmt ) )
			{
				$stmt->bind_param( 's', $lab_name );
				$stmt->execute();
				$stmt->store_result();
				$stmt->bind_result( $user_id );

				if ( $user_id )
					$user_input["users"][] = $user_id;
			}
		}
	}
}

else
	$user_input["users"][] = $lab_id;

/*************************
work here
**********************/


?>
