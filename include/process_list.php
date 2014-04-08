<?php
include_once 'common.php';

$mysqli = inventory_db_connect();
 
sec_session_start();

if ( isset( $_POST['type'] ) ) 
{
	$type = $_POST['type'];

	if ( $type == 'computers' )
		$prep_stmt = "SELECT tag_num FROM equipment e, computer c WHERE c.computer_tag = e.tag_num";

	if ( $type == 'printers' )
		$prep_stmt = "SELECT * FROM equipment e, network_printer p WHERE p.printer_tag = e.tag_num";		

	if ( $type == 'users' )
		$prep_stmt = "SELECT * FROM user GROUP BY 'f_name', 'l_name' ORDER BY 'l_name' ASC";

	if ( $type == 'purchases' )
		$prep_stmt = "SELECT * FROM purchase";

	if ( $type == 'software' )
		$prep_stmt = "SELECT * FROM software";

    $stmt = $mysqli->prepare( $prep_stmt );
 
    if ( $stmt ) 
	{
        $stmt->execute();
        $stmt->bind_result( $tag );

		while ( $stmt->fetch() )
			printf("%s <br>", $tag);
    }

	else echo "failure";


}

?>
