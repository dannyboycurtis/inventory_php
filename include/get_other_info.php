<?php
include_once 'common.php';
include_once 'query_index.php';

$mysqli = login_db_connect();

sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: login.php' );


if ( $_POST['request'] && $_POST['tag'] )
{	
	$mysqli = inventory_db_connect();

	if ( $_POST['request'] == "computers" )
	{	
		if ( $mysqli->prepare( $get_purchase_from_tag ) )
		{
			$stmt->bind_param( "s", $_POST['tag'] );
	 		$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result( $purchase_order,
								$purchase_date,
								$purchased_by );

			if ( $stmt->fetch() )
				printf( '<div class="panel panel-default"><div class="panel-body">
							<b>Purchase Order: </b>%s,
							<b>Purchased By: </b>%s</div></div>', $purchase_order, $purchased_by );
		}
	}

/*
		$get_purchase_from_tag
		$get_network_from_tag
		
		$get_computer_info_from_tag
		$get_printer_from_tag

		$get_notes_from_tag
*/
	if ( $_POST['request'] == "labs" )
	{
		

	}

	if ( $_POST['request'] == "printers" )
	{
		

	}

	if ( $_POST['request'] == "users" )
	{
		

	}

	if ( $_POST['request'] == "purchases" )
	{
		

	}

	if ( $_POST['request'] == "computers" && $_SESSION['role'] > 1 )
	{
		

	}

}


?>