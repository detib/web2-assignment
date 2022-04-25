<?php

  /*
   *
   * this page is the page that displays all the users in the admin dashboard
   *
   * first we require the necessary files
   * like the database, session and the admin files, which check for the user being logged in and if they are an admin
   *
   */

  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

  $query = "SELECT * FROM users WHERE role = '0' ORDER BY date_created DESC";
  /**
   *
   *
   *  we write the query for all the users, to select only the users we use the WHERE keyword, to select only those with the role of 0 which indicates a user, role 1 indicates a admin.
   *      and we order them by date_created in descending order so that the newest users are on top
   *
   *
   **/

  $result = mysqli_query( $conn, $query ); // execute the query
  $users = mysqli_fetch_all( $result, MYSQLI_ASSOC ); // fetch and put the results in an associative array

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link css,js,font-awesome -->
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="styles/adminmain.css">
    <link rel="stylesheet" href="styles/users.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
        integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/adminmain.js" defer></script>
    <title>Admin Dashboard | Users</title>
</head>

<body>
    <div class="main-wrapper">
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <h1 class="admin-title">All Users</h1>
            <div class="all-users">
                <?php if ( $users ): ?>
                <!-- if the $users variable is not empty it will be true, and render the html below it until the endif keyword -->
                <div class="field-names grid-layout">
                    <p>Profile Picture</p>
                    <p>Name</p>
                    <p>Surname</p>
                    <p>Email</p>
                    <p>Username</p>
                    <p>Date Created</p>
                    <p class="actions-text">Actions</p>
                </div>
                <?php foreach ( $users as $user ): ?>
                <!-- we start the foreach loop in order to render as much html as needed, as many users as we have -->
                <div class="single-user grid-layout">
                    <div class="profile-picture"> <!-- we echo the name of the profile picture that the user has in the database, and also have the relative path to the folder containing the photos -->
                        <img src="../userImages/<?=$user['picture'] ?>" alt="">
                    </div>
                    <!-- echo all the user details, that are stored in the database, exepct for the password -->
                    <h3 class="user-name"><?=$user['name']; ?></h3>
                    <h3 class="user-surname"><?=$user['surname']; ?></h3>
                    <p class="user-email"><?=$user['email']; ?></p>
                    <p class="user-username"><?=$user['username']; ?></p>
                    <p class="user-date-created"><?=$user['date_created']; ?></p>
                    <div class="button-actions"> <!-- this is where the action buttons for the user are, approve and delete buttons. -->
                        <?php if ( $user['is_active'] == 0 ): ?> <!-- we will show this button only if the user account is not currently active -->
                        <div class="button-action-wrapper"> <!-- we have the href to direct the click to the approve or delete user php script, and also pass the username in the get method -->
                            <a class="button-action approve"
                                href="config/approveuser.php?user=<?=$user['username'] ?>">Approve</a>
                        </div>
                        <?php endif; ?> <!-- end of if statement -->
                        <div class="button-action-wrapper">
                            <a class="button-action delete"
                                href="config/deleteuser.php?user=<?=$user['username'] ?>">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?> <!-- end of foreach loop -->
                <?php else: ?> <!-- if the $users variable is empty it will be false, and render the html below it until the endif keyword -->
                <p><i class="fa-solid fa-folder-open"></i> No users found</p>
                <?php endif; ?> <!-- end of if statement -->
            </div>
        </div>
    </div>
</body>

</html>