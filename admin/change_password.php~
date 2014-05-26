<?php
include_once '../include/common.php';

$mysqli = login_db_connect();
 
sec_session_start();

$logged = login_check( $mysqli );

if ( !( $logged ) )
	header( 'Location: ../login.php' );

$error_msg = "";
 
if ( isset( $_POST['p'], $_SESSION['username'] ) ) 
{
    $password = filter_input( INPUT_POST, 'p', FILTER_SANITIZE_STRING );
	$username = $_SESSION['username'];

        // Create a random salt
        $random_salt = hash('sha512', uniqid( openssl_random_pseudo_bytes( 16 ), TRUE ) );
 
        // Create salted password 
        $password = hash( 'sha512', $password . $random_salt );
 
        // Insert the new user into the database 
        if ( $changepwd_stmt = $mysqli->prepare( "UPDATE users SET password = ?, salt = ? WHERE username = ?" ) )
		{
            $changepwd_stmt->bind_param( 'sss', $password, $random_salt, $username );

			// Execute the prepared query.
            if ( !$changepwd_stmt->execute() )
                header( 'Location: register_error.php?err=Registration failure: INSERT' );
        }

        header( 'Location: ../portal.php' );
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Register New User</title>
        <script type="text/JavaScript" src="../js/sha512.js"></script> 
        <script type="text/JavaScript" src="../js/main.js"></script>
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php

        if ( !empty( $error_msg ) )
            echo $error_msg;

        ?>
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores</li>
            <li>Emails must have a valid email format</li>
            <li>Passwords must be at least 6 characters long</li>
            <li>Passwords must contain
                <ul>
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly</li>
        </ul>
        <form action="<?php echo esc_url( $_SERVER['PHP_SELF'] ); ?>" 
              method="post" 
              name="registration_form">
            Password: <input type="password"
                             name="password" 
                             id="password"/><br>
            Confirm password: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            <input type="button" 
                   value="Register" 
                   onclick="return pwdformhash( this.form,
                                   				this.form.password,
                                   				this.form.confirmpwd );" /> 
        </form>
        <p>Return to the <a href="../index.php">login page</a>.</p>
    </body>
</html>
