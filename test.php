<?php
include_once 'include/common.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$mysqli = inventory_db_connect();

$tag = '99999';
$notes = "testing";

echo $tag;
echo $notes;

	// add eq_notes entry
	$query_stmt = "INSERT INTO eq_notes VALUES( ?, ? ) ON DUPLICATE KEY UPDATE notes = VALUES(notes)";

	if ( $stmt = $mysqli->prepare( $query_stmt ) )
	{
		$stmt->bind_param( 'ss', $notes, $tag );
		$stmt->execute();
	}

$query_stmt = "SELECT notes FROM eq_notes WHERE tag_num = ?";

if ( $stmt = $mysqli->prepare( $query_stmt ) )
{
	$stmt->bind_param( 's', $tag );
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result( $tnotes );
	$stmt->fetch();
echo "notes: " . $tnotes;
}





?>
