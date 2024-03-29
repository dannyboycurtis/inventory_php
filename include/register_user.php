<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: login.php' );

else if ( isset( $_POST['user'], $_POST['p'], $_POST['role'] ) ) 
{
	$error_msg = "";

    // Sanitize and validate the data passed in
    $username = filter_input( INPUT_POST, 'user', FILTER_SANITIZE_STRING );
    $password = filter_input( INPUT_POST, 'p', FILTER_SANITIZE_STRING );
	$role = $_POST['role'];

    if ( strlen( $password ) != 128 )
        $error_msg .= 'Invalid password configuration!';

    $prep_stmt = "SELECT id FROM users WHERE username = ? LIMIT 1";
 
    if ( $stmt = $mysqli->prepare( $prep_stmt ) ) 
	{
        $stmt->bind_param( 's', $username );
        $stmt->execute();
        $stmt->store_result();
 
        if ( $stmt->num_rows == 1 )
            $error_msg .= 'This username is taken!';
    }

	else
        $error_msg .= 'Database error!';
 
    if ( empty( $error_msg ) )
	{
        // Create a random salt, then salt the password
        $random_salt = hash('sha512', uniqid( openssl_random_pseudo_bytes( 16 ), TRUE ) );
        $password = hash( 'sha512', $password . $random_salt );
 
		$insert_stmt = "INSERT INTO users ( username, password, salt, role ) VALUES ( ?, ?, ?, ? )";

        // Insert the new user into the database 
        if ( $stmt = $mysqli->prepare( $insert_stmt ) )
		{
            $stmt->bind_param( 'ssss', $username, $password, $random_salt, $role );
			$stmt->execute();
			$stmt->store_result();

			echo $stmt->affected_rows;
        }
    }

	else
		echo $error_msg;
}
?>













