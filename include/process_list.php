<?php
include_once 'common.php';

$mysqli = inventory_db_connect();
 
sec_session_start();

if ( isset( $_POST['type'] ) ) 
{
	$type = $_POST['type'];

	if ( $type == 'computers' )
	{
		$computer_stmt = "SELECT e.tag_num, e.serial, CONCAT( e.make, ' ', e.model ), c.os,
														 c.hostname, e.department, e.location, CONCAT( e.building, ' ', e.room_num )
											FROM equipment e, computer c, uses us, user u
											WHERE c.computer_tag = e.tag_num AND us.tag_num = e.tag_num
														AND us.user_id = u.user_id AND u.l_name IS NOT NULL
											GROUP BY e.tag_num
											ORDER BY tag_num DESC";


		$stmt = $mysqli->prepare( $computer_stmt );
 
    if ( $stmt ) 
		{
    	$stmt->execute();
			$stmt->store_result();
      $stmt->bind_result( $tag, $serial, $makemodel, $os, $hostname, $department, $offcampus, $location );

			printf( "Number of Results: %d", $stmt->num_rows );
			printf( "<table id='custom_table' class='tablesorter' summary='Search Results'>
							 	 <thead>
									 <tr>
										 <th class='expand_all open'><i style='cursor:pointer; cursor:hand;' class='fa fa-plus-square-o fa-fw'></i></th>
										 <th scope='col'><div>Property Tag <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Serial Number <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Make & Model <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Location <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Department <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Users <i class='arrow fa fa-unsorted'></i></div></th>
									 </tr>
								 </thead>
								 <tbody>" );

			while ( $stmt->fetch() )
			{
				printf( "<tr>
									 <td class='expand_record'><i style='cursor:pointer; cursor:hand;'<i class='fa fa-plus-square-o fa-fw'></i></td>
									 <td>%s</td>
									 <td>%s</td>
									 <td>%s</td>", $tag, $serial, $makemodel );

				if ( $offcampus == 'off' )
					printf( "<td>Off Campus</td>" );

				else if ( $offcampus == 'on' )
					printf( "<td>%s</td>", $location );

				else
					printf( "<td>Unknown</td>" );

				printf( "<td>%s</td>", $department );

				$mysqli2 = inventory_db_connect();

				if ( $stmt2 = $mysqli2->prepare( "SELECT CONCAT( u.f_name, ' ', u.l_name ), u.l_name
																					FROM user u, uses us
																					WHERE u.user_id = us.user_id AND us.tag_num = ?" ) )
				{
					$stmt2->bind_param( "s", $tag );
					$stmt2->execute();
					$stmt2->store_result();
					$stmt2->bind_result( $user, $l_name );

					if ( $stmt2->num_rows == 0 )
						printf( "<td></td>" );
										
					else if ( $stmt2->num_rows == 1 )
					{
						$stmt2->fetch();
						printf( "<td>%s</td>", $user );
					}
	
					else if ( $stmt2->num_rows > 1 )
					{
						$stmt2->fetch();
						printf( "<td>%s", $user );
						while ( $stmt2->fetch() )
							printf( ", %s", $user );

						printf( "</td>" );

					}
				}	
				printf( "<tr class='more_info' style='display:none;'><td></td><td style='border: 2px solid blue' colspan='6'>testing testing testing</td></tr>" );
			}
			
			printf( "</tbody></table><script>$( '#custom_table' ).tablesorter();
																			 $( '.expand_record' ).click( function(){
																				 $( this ).parent().next().toggle(); });
																			 $( '.expand_all' ).click( function(){
																				 $( this ).toggleClass( 'closed open' );
																				 if ( $( this ).hasClass( 'open' ) )
																					 $( '.more_info' ).hide();
																				 if ( $( this ).hasClass( 'closed' ) )
																				   $( '.more_info' ).show(); });</script>" );
    }
	}

if ( $type == 'labs' )
	{
		$lab_stmt = "SELECT e.tag_num, e.serial, CONCAT( e.make, ' ', e.model ), c.os,
														 c.hostname, e.department, e.location, CONCAT( e.building, ' ', e.room_num )
											FROM equipment e, computer c, uses us, user u
											WHERE c.computer_tag = e.tag_num AND us.tag_num = e.tag_num
														AND us.user_id = u.user_id AND u.l_name IS NULL
											GROUP BY e.tag_num
											ORDER BY e.building, e.room_num DESC";


		$stmt = $mysqli->prepare( $lab_stmt );
 
    if ( $stmt ) 
		{
    	$stmt->execute();
			$stmt->store_result();
      $stmt->bind_result( $tag, $serial, $makemodel, $os, $hostname, $department, $offcampus, $location );

			printf( "Number of Results: %d", $stmt->num_rows );
			printf( "<table id='custom_table' class='tablesorter' summary='Search Results'>
							 	 <thead>
									 <tr>
										 <th class='expand_all open'><i style='cursor:pointer; cursor:hand;' class='fa fa-plus-square-o fa-fw'></i></th>
										 <th scope='col'><div>Property Tag <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Serial Number <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Make & Model <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Location <i class='arrow fa fa-unsorted'></i></div></th>
										 <th scope='col'><div>Department <i class='arrow fa fa-unsorted'></i></div></th>
									 </tr>
								 </thead>
								 <tbody>" );

			while ( $stmt->fetch() )
			{
				printf( "<tr>
									 <td class='expand_record'><i style='cursor:pointer; cursor:hand;' class='fa fa-plus-square-o fa-fw'></i></td>
									 <td>%s</td>
									 <td>%s</td>
									 <td>%s</td>", $tag, $serial, $makemodel );

				if ( $offcampus == 'off' )
					printf( "<td>Off Campus</td>" );

				else if ( $offcampus == 'on' )
					printf( "<td>%s</td>", $location );

				else
					printf( "<td>Unknown</td>" );

				printf( "<td>%s</td></tr>", $department );
				printf( "<tr class='more_info' style='display:none;'><td></td><td style='border: 2px solid blue' colspan='5'>testing testing testing</td></tr>" );

				
			}
			
			printf( "</tbody></table><script>$( '#custom_table' ).tablesorter();
																			 $( '.expand_record' ).click( function(){
																				 $( this ).parent().next().toggle(); });
																			 $( '.expand_all' ).click( function(){
																				 $( this ).toggleClass( 'closed open' );
																				 if ( $( this ).hasClass( 'open' ) )
																					 $( '.more_info' ).hide();
																				 if ( $( this ).hasClass( 'closed' ) )
																				   $( '.more_info' ).show(); });					
</script>" );

    }
	}
}

?>
