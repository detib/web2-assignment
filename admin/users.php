<?php

  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

  $query = "SELECT * FROM users WHERE role = '0' ORDER BY date_created DESC";

  $result = mysqli_query( $conn, $query );
  $users = mysqli_fetch_all( $result, MYSQLI_ASSOC );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <div class="single-user grid-layout">
                    <div class="profile-picture">
                        <img src="../userImages/<?php echo $user['picture'] ?>" alt="">
                    </div>
                    <h3 class="user-name"><?php echo $user['name']; ?></h3>
                    <h3 class="user-surname"><?php echo $user['surname']; ?></h3>
                    <p class="user-email"><?php echo $user['email']; ?></p>
                    <p class="user-username"><?php echo $user['username']; ?></p>
                    <p class="user-date-created"><?php echo $user['date_created']; ?></p>
                    <div class="button-actions">
                        <?php if ( $user['is_active'] == 0 ): ?>
                        <div class="button-action-wrapper">
                            <a class="button-action approve"
                                href="config/approveuser.php?user=<?php echo $user['username'] ?>">Approve</a>
                        </div>
                        <?php endif; ?>
                        <div class="button-action-wrapper">
                            <a class="button-action delete"
                                href="config/deleteuser.php?user=<?php echo $user['username'] ?>">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p><i class="fa-solid fa-folder-open"></i> No users found</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>