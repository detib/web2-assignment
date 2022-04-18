<?php
  require 'config/database.php';
  require 'config/enc.php';
  $accountError = false;
  $accountActiveError = false;
  if ( isset( $_POST['submit'] ) ) {
    $username = mysqli_real_escape_string( $conn, $_POST['username'] );
    $password = mysqli_real_escape_string( $conn, $_POST['password'] );

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query( $conn, $query );
    $result = mysqli_fetch_assoc( $result );
    if ( $result ) {
      if ( openssl_decrypt( $result['password'], ENCRYPT_METHOD, HASH ) == $password ) {
        if ( $result['is_active'] != 0 ) {
          session_start();
          $_SESSION['user'] = $result;
          header( 'Location: index.php' );
          die();
        } else {
          $accountActiveError = "Your account is not active yet. Please wait for the admin to verify your account.";
        }
      } else {
        $accountError = "Wrong password.";
      }
    } else {
      $accountError = "Invalid username.";
    }

  }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogApp - Login</title>
</head>

<body>
    <?php include 'inc/navbar.php' ?>
    <br>
    <div class='login-box'>
        <div class='form-title'>
            <h6>Log In</h6>
            <p>Log In using the information you registered with</p>
        </div>
        <?php if ( !$accountActiveError ): ?>
        <form method="post" action='<?php echo $_SERVER['PHP_SELF'] ?>' class='login-form'>
            <div class='form-field'>
                <label htmlFor='login-email'>Username</label>
                <div class='login-input-field'>
                    <input name="username" type='text' placeholder='Type Username here' id='login-email' value="<?php if($accountError== "Wrong password.") echo $_POST['username']?>"/>
                </div>
            </div>
            <div class='form-field'>
                <label htmlFor='login-password'>Password</label>
                <div class='login-input-field'>
                    <input name="password" type='password' placeholder='Type password here' id='login-password' />
                </div>
            </div>
            <?php if($accountError):?>
                <div class="form-field not-active">
                    <p><?php echo $accountError ?></p>
                </div>
            <?php endif; ?>
            <input name="submit" type='submit' value='Log In' />
            <p>Don't have an account? <a href="register.php">Sign Up</a></p>
        </form>
        <?php else: ?>
        <div class='form-field not-active'>
            <p><?php echo $accountActiveError; ?></p>
        </div>
        <div class="login-with-another-acc">
            <a href="login.php">Login with another account</a>
        </div>
        <?php endif; ?>
    </div>
</body>

</html>