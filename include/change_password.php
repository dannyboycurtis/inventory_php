<?php
include_once 'common.php';

$mysqli = login_db_connect();
 
sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$error_msg = "";
 
if ( isset( $_POST['p'] ) ) 
{
	if ( !isset( $_POST['user'] ) )
		$username = $_SESSION['username'];

	else
		$username = $_POST['user'];

	$password = filter_var( $_POST['p'], FILTER_SANITIZE_STRING );

	// Create a random salt
	$random_salt = hash( 'sha512', uniqid( openssl_random_pseudo_bytes( 16 ), TRUE ) );
 
	// Create salted password 
	$password = hash( 'sha512', $password . $random_salt );
 
	// Insert the new user into the database 
	if ( $stmt = $mysqli->prepare( "UPDATE users SET password = ?, salt = ? WHERE username = ? LIMIT 1" ) )
	{
		$stmt->bind_param( 'sss', $password, $random_salt, $username );
		$stmt->execute();

		if ( $stmt->affected_rows == 1 )
			echo "1";

		else
			echo "0";

	}
}

$mysqli->close();
?>
