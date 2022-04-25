<?php

// require the database config files, and also the encryption script, that contains the password encryption constants
  require 'config/database.php';
  require 'config/enc.php';

  if ( isset( $_POST['submit'] ) ) {
    // get the data from the form post submission, and sanitize it to prevent sql injection or script injection.
    $name = htmlentities( mysqli_real_escape_string( $conn, $_POST['name'] ) );
    $surname = htmlentities( mysqli_real_escape_string( $conn, $_POST['surname'] ) );
    $email = htmlentities( mysqli_real_escape_string( $conn, $_POST['email'] ) );
    $username = htmlentities( mysqli_real_escape_string( $conn, $_POST['username'] ) );
    $password = htmlentities( mysqli_real_escape_string( $conn, $_POST['password'] ) );

    // check if the a file is uploaded, if uploaded then add the file details to variables, move them to the folder and rename them.
    if ( $_FILES['profile']['error'] == 0 ) {
      // get the file uploaded from the form submission
      $file_name = $_FILES['profile']['name'];
      $file_tmp = $_FILES['profile']['tmp_name']; // temporary file location
      $file_ext = explode( '.', $file_name );
      $file_ext = strtolower( end( $file_ext ) ); // get the file extension

      /*
       *
       * generate random id for the image to store in the database and access it with that id
       * we use the mt_rand function to generate a random number
       * we use the sha1 function to generate sha1 hash of the random number
       * we use the base64_encode function to encode the sha1 hash to a base64 string
       * we use the substr function to get the first 20 characters of the returned string and assign it to the $file_name variable
       *
       */
      $file_name = "profile-pic-" . substr( base64_encode( sha1( mt_rand() ) ), 0, 20 );
      $target_dir = "userImages/$file_name.$file_ext";
      move_uploaded_file( $file_tmp, $target_dir );
    } else { // if no file is uploaded then assign the default image to the variable, and the default extension to the variable.
      $file_name = "default";
      $file_ext = "png";
    }

    $password = openssl_encrypt( $password, ENCRYPT_METHOD, HASH ); // encrypt the password, the ENCRYPT_METHOD and HASH are constants defined in the config/enc.php script

    // write the query
    $query = "INSERT INTO
        users(name, surname, email, username, password, picture)
            VALUES('$name', '$surname', '$email', '$username', '$password', '$file_name.$file_ext')";

            // execute the query and check if it throws an error.
    if ( mysqli_query( $conn, $query ) ) {
      header( "Location: login.php" ); // if the query is successful, redirect to the login page.
    } else {
      echo "<h1 style='color:red; font-weight: 900'>Error: " . $query . "<br>" . mysqli_error( $conn ) . "</h1>";
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
    <link rel="stylesheet" href="styles/register.css">
    <link rel="stylesheet" href="styles/inc.css">
    <script src="js/register.js" defer></script>
    <title>Coder | Register</title>
</head>

<body>
    <?php require 'inc/navbar.php'; ?> <!-- require the navbar -->
    <div class='signup-box'>
        <div class='form-title'>
            <h6>Sign Up</h6>
            <p>Fill in with your information down below</p>
        </div>
        <!-- write the form that submits to this page, with an attribute of enctype="multipart/form-data" -->
        <form action="register.php" method="post" class='signup-form' id="register-form" autocomplete="off"
            enctype="multipart/form-data">
            <div class="two-item-field">
                <div class='form-field'>
                    <label for='name'>Name</label>
                    <div class='signup-input-field'>
                        <input required type='text' placeholder='Type Your Name Here' id='name' name="name" />
                    </div>
                </div>
                <div class='form-field'>
                    <label for='surname'>Surname</label>
                    <div class='signup-input-field'>
                        <input required type='text' placeholder='Type Your Surname Here' id='surname' name="surname"/>
                    </div>
                </div>
            </div>
            <div class='form-field'>
                <label for='email'>Email</label>
                <div class='signup-input-field'>
                    <input required type='text' placeholder='Type Your Email Here' id='email' name="email"/>
                </div>
            </div>
            <div style="display: none;" id="email-exists">
                <p style="color: red; font-weight: 600;">Email already in use</p>
            </div>
            <div class="two-item-field">
                <div class='form-field'>
                    <label for='username'>Username</label>
                    <div class='signup-input-field'>
                        <input required type='text' placeholder='Type Your Username Here' id='username' name="username"/>
                    </div>
                </div>
                <div class='form-field'>
                    <label for='password'>Password</label>
                    <div class='signup-input-field'>
                        <input required type='password' placeholder='Type Password Here' id='password' name="password"/>
                    </div>
                </div>
            </div>
            <div style="display: none;" id="username-exists">
                <p style="color: red; font-weight: 600;">Username already exists.</p>
            </div>
            <div style="display: none;" id="password-error">
                <p style="color: red; font-weight: 600;">Password should be 8 characters long, 1 uppercase letter, 1
                    number.</p>
            </div>
            <div class='form-field'>
                <label for='profile'>Add Profile Picture</label>
                <div class='signup-input-field'>
                    <input id="profile-image" name="profile" type='file' placeholder='Type Your Profile Here'
                        id='profile' />
                </div>
                <p id="register-error-box">Invalid file type.</p>
            </div>
            <input name="submit" type='submit' value='Sign Up' id="submit" />
        </form>
    </div>
    <?php include 'inc/footer.php' ?> <!-- require the footer -->
</body>

</html>