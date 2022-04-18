<?php
  require 'config/database.php';
  require 'config/enc.php';

  $allowedExtensions = ['jpg', 'jpeg', 'png'];
  $invalidFile = false;
  if ( isset( $_POST['submit'] ) ) {
    // get the data from the form submission
    $name = mysqli_real_escape_string( $conn, $_POST['name'] );
    $surname = mysqli_real_escape_string( $conn, $_POST['surname'] );
    $email = mysqli_real_escape_string( $conn, $_POST['email'] );
    $username = mysqli_real_escape_string( $conn, $_POST['username'] );
    $password = mysqli_real_escape_string( $conn, $_POST['password'] );

    if ( $_FILES['profile']['error'] == 0 ) {
      // get the file uploaded from the form submission
      $file_name = $_FILES['profile']['name'];
      $file_tmp = $_FILES['profile']['tmp_name'];
      $file_ext = explode( '.', $file_name );
      $file_ext = strtolower( end( $file_ext ) );

      // generate id for the image to store in the database and access it with that id
      $file_name = "profile-pic-" . substr( base64_encode( sha1( mt_rand() ) ), 0, 20 );
      $target_dir = "userImages/$file_name.$file_ext";
      if ( in_array( $file_ext, $allowedExtensions ) ) {
        move_uploaded_file( $file_tmp, $target_dir );
      } else {
        $invalidFile = true;
      }
    } else {
      $target_dir = "userImages/default.png";
      $file_name = "default";
    }

    if ( !$invalidFile ) {

      $password = openssl_encrypt( $password, ENCRYPT_METHOD, HASH );

      $query = "INSERT INTO
            users(name, surname, email, username, password, picture)
                VALUES('$name', '$surname', '$email', '$username', '$password', '$file_name')";
      if ( mysqli_query( $conn, $query ) ) {
        header( "Location: login.php" );
      } else {
        echo "<h1 style='color:red; font-weight: 900'>Error: " . $query . "<br>" . mysqli_error( $conn ) . "</h1>";
      }
    }

  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/register.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/register.js" defer></script>
    <title>BlogApp - Register</title>
</head>

<body>
    <?php require 'inc/navbar.php'; ?>
    <div class='signup-box'>
        <div class='form-title'>
            <h6>Sign Up</h6>
            <p>Fill in with your information down below</p>
        </div>
        <form action="register.php" method="post" class='signup-form' id="register-form" autocomplete="off"
            enctype="multipart/form-data">
            <div class="two-item-field">
                <div class='form-field'>
                    <label for='name'>Name</label>
                    <div class='signup-input-field'>
                        <input required type='text' placeholder='Type your Name here' id='name' name="name"
                            value="<?php echo isset( $_POST['name'] ) ? $_POST['name'] : '' ?>" />
                    </div>
                </div>
                <div class='form-field'>
                    <label for='surname'>Surname</label>
                    <div class='signup-input-field'>
                        <input required type='text' placeholder='Type your Surname here' id='surname' name="surname"
                            value="<?php echo isset( $_POST['surname'] ) ? $_POST['surname'] : '' ?>" />
                    </div>
                </div>
            </div>
            <div class='form-field'>
                <label for='email'>Email</label>
                <div class='signup-input-field'>
                    <input required type='text' placeholder='Type your Email here' id='email' name="email"
                        value="<?php echo isset( $_POST['email'] ) ? $_POST['email'] : '' ?>" />
                </div>
            </div>
            <div style="display: none;" id="email-exists">
                <p style="color: red; font-weight: 600;">Email already in use</p>
            </div>
            <div class="two-item-field">
                <div class='form-field'>
                    <label for='username'>Username</label>
                    <div class='signup-input-field'>
                        <input required type='text' placeholder='Type your Username here' id='username' name="username"
                            value="<?php echo isset( $_POST['username'] ) ? $_POST['username'] : '' ?>" />
                    </div>
                </div>
                <div class='form-field'>
                    <label for='password'>Password</label>
                    <div class='signup-input-field'>
                        <input required type='password' placeholder='Type password here' id='password' name="password"
                            value="<?php echo isset( $_POST['password'] ) ? $_POST['password'] : '' ?>" />
                    </div>
                </div>
            </div>
            <div style="display: none;" id="username-exists">
                <p style="color: red; font-weight: 600;">Username already exists</p>
            </div>
            <div style="display: none;" id="password-error">
                <p style="color: red; font-weight: 600;">Password should be 8 characters long, 1 uppercase letter, 1
                    number</p>
            </div>
            <div class='form-field'>
                <label for='profile'>Add Profile Picture</label>
                <div class='signup-input-field'>
                    <input name="profile" type='file' placeholder='Type your profile here' id='profile' />
                </div>
            </div>
            <?php if ( $invalidFile ): ?>
            <p style="color: red; font-weight: 600;">Invalid file type</p>
            <?php endif; ?>
            <input name="submit" type='submit' value='Sign Up' id="submit" />
        </form>
    </div>
</body>

</html>