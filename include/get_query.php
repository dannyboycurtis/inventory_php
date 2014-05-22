<?php
include_once 'common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

if ( !isset( $_POST['tag'] ) )
	header( 'Location: ../portal.php' );

$results[] = array( "query" => $_SESSION["query"], "type" => $_SESSION["querytype"] );

echo json_encode( $results );

?>
