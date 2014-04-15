<?php
include_once 'common.php';
include_once 'query_index.php';

$mysqli = inventory_db_connect();
 
//sec_session_start();

if ( isset( $_POST['type'] ) ) 
	$type = $_POST['type'];

// List all Non-Lab Computers
if ( $type == 'computers' and $stmt = $mysqli->prepare( $get_all_computers ) ) 
{
	unset( $headers, $results );

 	$stmt->execute();
	$stmt->store_result();
  $stmt->bind_result( $tag,
											$serial,
											$makemodel,
											$os,
											$hostname,
											$department,
											$offcampus,
											$location, 
											$purchase_order,
											$purchase_date,
											$purchased_by,
											$mac,
											$wmac,
											$ip );

	while ( $stmt->fetch() )
	{
		unset( $users, $software );				

		if ( $offcampus == 'off' )
			$location = "Off Campus";
				
		// Query printer for current record
		if ( $stmt2 = $mysqli->prepare( $get_printer_from_tag ) )
		{
			$stmt2->bind_param( "s", $tag );
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result( $printer );

			if ( $stmt2->fetch() )
				$eq_printer = $printer;

			$stmt2->close();

		}

		// Query notes for current record
		if ( $stmt3 = $mysqli->prepare( $get_notes_from_tag ) )
		{
			$stmt3->bind_param( "s", $tag );
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result( $notes );

			if ( $stmt3->fetch() )
				$eq_notes = $notes;

			$stmt3->close();

		}

		// Query users for current record
		if ( $stmt4 = $mysqli->prepare( $get_users_from_tag ) )
		{
			$stmt4->bind_param( "s", $tag );
			$stmt4->execute();
			$stmt4->store_result();
			$stmt4->bind_result( $firstname, $lastname );

			while ( $stmt4->fetch() )
				$users[] = array("firstname" => $firstname, "lastname" => $lastname );

			$stmt4->close();

		}	

		// Query software for current record
		if ( $stmt5 = $mysqli->prepare( $get_software_from_tag ) )
		{
			$stmt5->bind_param( "s", $tag );
			$stmt5->execute();
			$stmt5->store_result();
			$stmt5->bind_result( $software_name, $license_type );

			while ( $stmt5->fetch() )
				$software[] = array( "name" => $software_name, "type" => $license_type );

			$stmt5->close();

		}

		// Set results and headers arrays
		$results[] = array( "tag" => $tag, 
	 										 	"serial" => $serial, 
												"makemodel" => $makemodel, 
												"department" => $department, 
												"location" => $location,
												"purchase_order" => $purchase_order, 
												"purchase_date" => $purchase_date,
												"purchased_by" => $purchased_by,
												"eq_printer" => $eq_printer,
					 							"eq_notes" => $eq_notes,
					 							"os" => $os,
					 							"hostname" => $hostname,
					 							"mac" => $mac,
					 							"wmac" => $wmac,
												"ip" => $ip,
				 								"users" => $users,
				 								"software" => $software, );
	}
			
	$headers = array( "1" => "Property Tag",
										"2" => "Serial Number",
										"3" => "Make & Model",
										"4" => "Location",
										"5" => "Department",
										"6" => "Users", );

	$resultsCount = $stmt->num_rows;		
	
	echo json_encode( $results );

}

// List all Lab Computers
if ( $type == 'labs' and $stmt = $mysqli->prepare( $get_all_labs ) ) 
{
	unset( $headers, $results );

 	$stmt->execute();
	$stmt->store_result();
  $stmt->bind_result( $tag,
											$serial,
											$makemodel,
											$os,
											$hostname,
											$department,
											$location, 
											$purchase_order,
											$purchase_date,
											$purchased_by,
											$mac,
											$wmac,
											$ip );

	while ( $stmt->fetch() )
	{
		unset( $users, $software );				
				
		// Query printer for current record
		if ( $stmt2 = $mysqli->prepare( $get_printer_from_tag ) )
		{
			$stmt2->bind_param( "s", $tag );
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result( $printer );

			if ( $stmt2->fetch() )
				$eq_printer = $printer;

			$stmt2->close();

		}

		// Query notes for current record
		if ( $stmt3 = $mysqli->prepare( $get_notes_from_tag ) )
		{
			$stmt3->bind_param( "s", $tag );
			$stmt3->execute();
			$stmt3->store_result();
			$stmt3->bind_result( $notes );

			if ( $stmt3->fetch() )
				$eq_notes = $notes;

			$stmt3->close();

		}

		// Query software for current record
		if ( $stmt4 = $mysqli->prepare( $get_software_from_tag ) )
		{
			$stmt4->bind_param( "s", $tag );
			$stmt4->execute();
			$stmt4->store_result();
			$stmt4->bind_result( $software_name, $license_type );

			while ( $stmt4->fetch() )
				$software[] = array( "name" => $software_name, "type" => $license_type );

			$stmt4->close();

		}

		// Set results and headers arrays
		$results[] = array( "tag" => $tag, 
	 										 	"serial" => $serial, 
												"makemodel" => $makemodel, 
												"department" => $department, 
												"location" => $location,
												"purchase_order" => $purchase_order, 
												"purchase_date" => $purchase_date,
												"purchased_by" => $purchased_by,
												"eq_printer" => $eq_printer,
					 							"eq_notes" => $eq_notes,
					 							"os" => $os,
					 							"hostname" => $hostname,
					 							"mac" => $mac,
					 							"wmac" => $wmac,
												"ip" => $ip,
				 								"software" => $software, );
	}
			
	$headers = array( "1" => "Property Tag",
										"2" => "Serial Number",
										"3" => "Make & Model",
										"4" => "Location",
										"5" => "Department", );

	$resultsCount = $stmt->num_rows;		
	
	echo json_encode( $results );

}

// List all Network Printers
if ( $type == 'printers' and $stmt = $mysqli->prepare( $get_all_network_printers ) ) 
{
	unset( $headers, $results );

 	$stmt->execute();
	$stmt->store_result();
  $stmt->bind_result( $tag,
											$serial,
											$makemodel,
											$hostname,
											$department,
											$location, 
											$purchase_order,
											$purchase_date,
											$purchased_by,
											$mac,
											$wmac,
											$ip );

	while ( $stmt->fetch() )
	{

		// Query notes for current record
		if ( $stmt2 = $mysqli->prepare( $get_notes_from_tag ) )
		{
			$stmt2->bind_param( "s", $tag );
			$stmt2->execute();
			$stmt2->store_result();
			$stmt2->bind_result( $notes );

			if ( $stmt2->fetch() )
				$eq_notes = $notes;

			$stmt2->close();

		}

		// Set results and headers arrays
		$results[] = array( "tag" => $tag, 
	 										 	"serial" => $serial, 
												"makemodel" => $makemodel, 
												"department" => $department, 
												"location" => $location,
												"purchase_order" => $purchase_order, 
												"purchase_date" => $purchase_date,
												"purchased_by" => $purchased_by,
					 							"eq_notes" => $eq_notes,
					 							"hostname" => $hostname,
					 							"mac" => $mac,
					 							"wmac" => $wmac,
												"ip" => $ip, );
	}
			
	$headers = array( "1" => "Property Tag",
										"2" => "Serial Number",
										"3" => "Make & Model",
										"4" => "Location",
										"5" => "Department", );

	$resultsCount = $stmt->num_rows;		

	echo json_encode( $results );

}


// List all faculty/staff users
if ( $type == 'users' and $stmt = $mysqli->prepare( $get_all_users ) ) 
{
	unset( $headers, $results );

 	$stmt->execute();
	$stmt->store_result();
  $stmt->bind_result( $user_id,
											$f_name,
											$l_name );

	while ( $stmt->fetch() )
	{
		unset( $equipment );			

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
		$results[] = array( "f_name" => $f_name, 
	 										 	"l_name" => $l_name, 
												"equipment" => $equipment, );
	}

	$headers = array( "1" => "First Name",
										"2" => "Last Name", );

	$resultsCount = $stmt->num_rows;
	
	echo json_encode( $results );

}

// List all purchase orders
if ( $type == 'purchases' and $stmt = $mysqli->prepare( $get_all_purchase_orders ) ) 
{
	unset( $headers, $results );

 	$stmt->execute();
	$stmt->store_result();
  $stmt->bind_result( $purchase_id,
											$purchase_order,
											$purchase_date,
											$purchased_by );

	while ( $stmt->fetch() )
	{
		unset( $equipment );			

		// Query equipment for current user
		if ( $stmt2 = $mysqli->prepare( $get_equipment_from_purchase_id ) )
		{
			$stmt2->bind_param( "s", $purchase_id );
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
		$results[] = array( "purchase_order" => $purchase_order, 
	 										 	"purchase_date" => $purchase_date,
												"purchased_by" => $purchased_by, 
												"equipment" => $equipment, );
	}
			
	$headers = array( "1" => "Purchase Order",
										"2" => "Purchase Date",
										"3" => "Purchased By" );

	$resultsCount = $stmt->num_rows;
	
	echo json_encode( $results );

}


// List all licensed software
if ( $type == 'software' and $stmt = $mysqli->prepare( $get_all_software ) ) 
{
	unset( $headers, $results );

 	$stmt->execute();
	$stmt->store_result();
  $stmt->bind_result( $software_id,
											$software_name,
											$license_num,
											$license_type,
											$number_of_licenses,
											$notes );

	while ( $stmt->fetch() )
	{
		unset( $computers );			

		// Query computers for current software
		if ( $stmt2 = $mysqli->prepare( $get_computers_from_software_id ) )
		{
			$stmt2->bind_param( "s", $software_id );
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

				$computers[] = array( "tag" => $tag,
															"serial" => $serial,
															"makemodel" => $makemodel,
															"location" => $location,
															"department" => $department );

			}

			$stmt2->close();

		}

		// Set results and headers arrays
		$results[] = array( "software_name" => $software_name, 
	 										 	"license_number" => $license_number,
												"license_type" => $license_type, 
												"number_of_licenses" => $number_of_licenses,
												"notes" => $notes,
												"computers" => $computers, );
	}
			
	$headers = array( "1" => "Software Name",
										"2" => "License Number",
										"3" => "License Type",
										"4" => "Number of Licenses" );

	$resultsCount = $stmt->num_rows;
	
	echo json_encode( $results );

}


/*

			printf( "Number of Results: %d", $stmt->num_rows );
			printf( "<table id='custom_table' class='tablesorter' summary='Search Results'>
							 	 <thead>
									 <tr>
										 <th>
											 <i style='cursor:pointer; color:blue;' class='expand_all open fa fa-plus-square fa-fw'></i>
										 </th>
										 <th scope='col'>
										 	 <div>Property Tag <i class='fa fa-unsorted'></i></div>
										 </th>
										 <th scope='col'>
											 <div>Serial Number <i class='fa fa-unsorted'></i></div>
										 </th>
										 <th scope='col'>
											 <div>Make & Model <i class='fa fa-unsorted'></i></div>
										 </th>
										 <th scope='col'>
											 <div>Location <i class='fa fa-unsorted'></i></div>
										 </th>
										 <th scope='col'>
											 <div>Department <i class='fa fa-unsorted'></i></div>
										 </th>
									 </tr>
								 </thead>
								 <tbody>" );

	
				printf( "<td>%s</td></tr>", $department );
				printf( "<tr class='more_info expand-child' style='display:none;'><td></td><td style='border: 2px solid blue' colspan='5'>testing testing testing</td></tr>" );

				
			}


    }
	}


// after query has been done:
printf( "</tbody></table>
				 <script>$( '#custom_table' ).tablesorter();
									 $( '.expand_record' ).click( function(){
										 $( this ).parent().parent().next().toggle();
										 $( this ).toggleClass( 'fa-minus-square fa-plus-square' ); });
									 $( '.expand_all' ).click( function(){
										 $( this ).toggleClass( 'closed open' );
										 if ( $( this ).hasClass( 'open' ) )
										 {
											 $( '.more_info' ).hide();
											 $( '.expand_record, .expand_all' ).removeClass( 'fa-minus-square' );
											 $( '.expand_record, .expand_all' ).addClass( 'fa-plus-square' );
										 }

										 if ( $( this ).hasClass( 'closed' ) )
										 {
										   $( '.more_info' ).show();
											 $( '.expand_record, .expand_all' ).removeClass( 'fa-plus-square' );
											 $( '.expand_record, .expand_all' ).addClass( 'fa-minus-square' );
										 }
									 }); </script>" );
*/

?>
