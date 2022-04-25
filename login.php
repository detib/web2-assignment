<?php

  /**
   * 
   * we require the config files that we need to establish the database connection.
   *   and also the encryption constants that we need to decrypt the password.
   * 
   * 
   */
  require 'config/database.php';
  require 'config/enc.php';

  // we initialize the error variables to false, then after some condtion we will turn them to true and show the error.
  $accountError = false;
  $accountActiveError = false;

  if ( isset( $_POST['submit'] ) ) { // check if the form has been submitted
    $username = mysqli_real_escape_string( $conn, $_POST['username'] ); // sanitaze and store in variable the username that is submitted in the form
    $password = mysqli_real_escape_string( $conn, $_POST['password'] ); // sanitaze and store in variable the password that is submitted in the form

    $query = "SELECT * FROM users WHERE username = '$username'"; // select the user from the database where the username is the same as the username that is submitted in the form
    $result = mysqli_query( $conn, $query ); // execute the query
    $result = mysqli_fetch_assoc( $result ); // fetch the result and store it in an associative array
    if ( $result ) { // if the result is true then we have a user with that username, else it will show the "Invalid username" error
      if ( openssl_decrypt( $result['password'], ENCRYPT_METHOD, HASH ) == $password ) { // now we check the password, first we decrypt the password that is stored in the database, then we compare it with the password that is submitted in the form, if true then we continue, else we show the "Invalid password" error
        if ( $result['is_active'] != 0 ) { // if the user is not active then we show the "Account not activated" error
          session_start(); // if it is active we start the session, 
          $_SESSION['user'] = $result; // then we store the whole user in the session variables, so that we can accesss it in the whole page, whenever we need it.
          header( 'Location: index.php' ); // redirect to the index page
          die();
        } else {
          $accountActiveError = "Your account is not active yet. Please wait for the admin to verify your account."; // third nested if error
        }
      } else {
        $accountError = "Wrong password."; // second nested if error
      }
    } else {
      $accountError = "Invalid username."; // first if error
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link all the css files that this page uses -->
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/inc.css">
    <title>Coder | Login</title>
</head>

<body>
    <?php include 'inc/navbar.php' ?>
    <div class='login-box'>
        <div class='form-title'>
            <h6>Log In</h6>
            <p>Log in using the information you registered with</p>
        </div>
        <?php if ( !$accountActiveError ): ?> <!-- if the $accountActiveError is true then we do not need to show the whole form so we put the whole form inside an if conditon -->
          <!-- action is $_SERVER['PHP_SELF'] so that this form submits to itself -->
        <form method="post" action='<?= $_SERVER['PHP_SELF'] ?>' class='login-form'>
            <div class='form-field'>
                <label for='login-email'>Username</label>
                <div class='login-input-field'>
                    <input name="username" type='text' placeholder='Type Username Here' id='login-email' 
                        value="<?= $accountError== "Wrong password." ? $_POST['username'] : NULL?>"/>
                        <!-- 
                          if the $accountError is the wrong password we want to keep the username written so that the user does not need to retype it
                            it is also inside a ternary operator that outputs nothing if the $accountError is false, as initalized above, and the username if it is true.
                        -->
                </div>
            </div>
            <div class='form-field'>
                <label for='login-password'>Password</label>
                <div class='login-input-field'>
                    <input name="password" type='password' placeholder='Type Password Here' id='login-password' />
                </div>
            </div>
            <?php if($accountError):?> <!-- if the $accountError is true we output this error to the user$accountError
             -->
                <div class="form-field not-active">
                    <p><?= $accountError ?></p> <!-- in the else clause at the login handler above we change the value of the variable to a text, the error text, we output that here -->
                </div>
            <?php endif; ?> <!-- end of if statement -->
            <input name="submit" type='submit' value='Log In' />
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </form>
        <?php else: ?> <!-- this is the else clause that will run if the $accountActiveError is true -->
        <div class='form-field not-active'>
            <p><?= $accountActiveError; ?></p> <!-- in the else clause at the login handler above we change the value of the variable to a text, the error text, we output that here -->
        </div>
        <div class="login-with-another-acc">
            <a href="login.php">Login with another account</a>
        </div>
        <?php endif; ?> <!-- endif statement to end the whole if statement -->
    </div>
    <?php require 'inc/footer.php' ?> <!-- require the footer --> 
</body>

</html>