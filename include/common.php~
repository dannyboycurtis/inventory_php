<?php
include_once 'config.php';

function login_db_connect()
{
	$mysqli = new mysqli( HOST, L_USER, L_PASSWORD, L_DATABASE );

	return $mysqli;
}

function inventory_db_connect()
{
	$mysqli = new mysqli( HOST, I_USER, I_PASSWORD, I_DATABASE );

	return $mysqli;
}

function sec_session_start()
{
    $session_name = 'inventory_session';
    $secure = SECURE;
    $httponly = true;

    if ( ini_set( 'session.use_only_cookies', 1 ) === FALSE )
	{
        header( "Location: ../error.php?err=Could not initiate a safe session (ini_set)" );
        exit();
    }

    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params( $cookieParams["lifetime"],
        					   $cookieParams["path"], 
       						   $cookieParams["domain"], 
      						   $secure,
        					   $httponly );

    session_name( $session_name );
    session_start();
    session_regenerate_id();

	if ( isset( $_SESSION['last_activity'] ) && ( time() - $_SESSION['last_activity'] > 1800 ) )
	{
	    // last request was more than 30 minutes ago
	    session_unset();
	    session_destroy();
	}

	$_SESSION['last_activity'] = time(); // update last activity time stamp
}


function login( $user, $password, $mysqli )
{
    if ( $stmt = $mysqli->prepare( "SELECT id, username, password, salt, role 
        														FROM users
       															WHERE username = ? LIMIT 1" ) )
	{
        $stmt->bind_param( 's', $user );
        $stmt->execute();
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result( $user_id, $username, $db_password, $salt, $role );
        $stmt->fetch();
 
        // hash the password with the unique salt.
        $password = hash( 'sha512', $password . $salt );
        if ( $stmt->num_rows == 1 )
		{
            // If the user exists we check if the account is locked
            // from too many login attempts 
 
            if ( checkbrute( $user_id, $mysqli ) == true ) 
                return "account_locked"; // Account is locked 

			else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ( $db_password == $password )
				{
					// Password is correct

                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $username);
                    $_SESSION['username'] = $username;

                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
					$_SESSION['user_id'] = $user_id;

					$_SESSION['role'] = $role;

                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $_SESSION['login_string'] = hash( 'sha512', $password . $user_browser );

					$_SESSION['last_activity'] = time(); // update last activity time stamp		

                    return "success"; // Login successful
                }

				else
				{
                    // Password is not correct

                    // Record this attempt in the database
                    $now = time();
                    $mysqli->query( "INSERT INTO login_attempts( user_id, time )
                                     VALUES ( '$user_id', '$now' )" );
                    return "wrong_password";
                }
            }

        }

		else return "no_such_user"; // No user exists.
    }
}


function checkbrute( $user_id, $mysqli )
{
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours 
    $valid_attempts = $now - ( 2 * 60 * 60 );
 
    if ( !( $stmt = $mysqli->prepare( "SELECT time 
                             		   FROM login_attempts
                             		   WHERE user_id = ? 
                            		   AND time > '$valid_attempts'" ) ) )
		return false;	

	else
	{
        $stmt->bind_param( 'i', $user_id );
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ( $stmt->num_rows > 5 )
            return true;
    }
}


function login_check( $mysqli )
{
	if ( isset( $_SESSION['last_activity'] ) && ( time() - $_SESSION['last_activity'] > 1800 ) )
	{
	    // last request was more than 30 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
		return false; // Not logged in
	}

    // Check if all session variables are set 
    if ( !isset( $_SESSION['username'], $_SESSION['login_string'] ) )
		return false; // Not logged in

	else
	{ 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
 		$role = $_SESSION['role'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
 
        if ( !( $stmt = $mysqli->prepare( "SELECT password 
                                           FROM users 
                                           WHERE id = ? LIMIT 1" ) ) )
			return false; // Not logged in

		else
		{
            // Bind "$user_id" to parameter. 
            $stmt->bind_param( 'i', $user_id );
            $stmt->execute();
            $stmt->store_result();
 
            if ( !( $stmt->num_rows == 1 ) )
				return false; // Not logged in

			else
			{
                // If the user exists get variables from result.
                $stmt->bind_result( $password );
                $stmt->fetch();
                $login_check = hash( 'sha512', $password . $user_browser );
 
                if ( !( $login_check == $login_string ) )
					return false; // Not logged in

				else 
				{
					$_SESSION['last_activity'] = time(); // update last activity time stamp
					return true; // Logged in
				}
            }
        }
    }
}


function esc_url( $url )
{ 
    if ( '' == $url )
        return $url;
 
    $url = preg_replace( '|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url );
 
    $strip = array( '%0d', '%0a', '%0D', '%0A' );
    $url = ( string ) $url;
 
    $count = 1;
    while ( $count )
        $url = str_replace( $strip, '', $url, $count );
 
    $url = str_replace( ';//', '://', $url );
 
    $url = htmlentities( $url );
 
    $url = str_replace( '&amp;', '&#038;', $url );
    $url = str_replace( "'", '&#039;', $url );
 
    if ( $url[0] !== '/' )
        return '';

	else return $url;
}

?>
