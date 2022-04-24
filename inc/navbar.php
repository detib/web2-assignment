<!-- This is the html markup for the navbar that also includes some logic based on whether a user is logged in or not, we get this through the require function  -->

<!-- we require the session.php file to get the session variables that we stored -->
<?php require 'config/session.php'; ?>

<head>
    <script src="https://kit.fontawesome.com/a1f1e2f8b3.js" crossorigin="anonymous"></script>
</head>
<nav>
    <div class="nav-brand">
        <a href="index.php"><i class="fa-solid fa-code icon"></i> CODER</a>
    </div>
    <div>
        <ul class="nav-items">
            <li class="nav-link">
                <a href="index.php">Home</a>
            </li>
            <!-- if(!$user) checks if the variable $user is set, This will not return a undefined variable error since we defined it in the session.php script
                if the user is not logged in then it will display the login and register links -->
            <?php if ( !$user ): ?>
            <li class="nav-link">
                <a href="login.php">Log In</a>
            </li>
            <li class="nav-link">
                <a href="register.php">Register</a>
            </li>
            <?php endif; ?>
            <!-- endif to end the if condition started above -->


            <?php if ( $user && $role == 'admin' ): ?>
            <li class="nav-link">
                <a href="admin/index.php">Dashboard</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <!-- we check again the $user variable, if the user is logged in then it will display the username, logout link, and the profile picture -->
    <?php if ( $user ): ?>
    <div class="user">
        <!-- we echo the username -->
        <a href="$"><?= $username; ?></a>
        <!-- we echo the image name and extension that is saved in the session variables, that we originally fetch from the database after a successful login -->
        <div class="profile-pic"><a href="#"><img src="userImages/<?= $picture ?>" alt=""></a></div>
        <div class="user-dropdown">
            <a href="logout.php">Sign Out</a>
        </div>
    </div>
    <?php else: ?> <!-- the links below aren't functional. we used them solely so that the main nav-links would be centered in the nav even when the user shrinks the page horizontally -->
    <div class="nav-signedout">
        <ul class="nav-items">
            <li class="nav-link">
                <a href="#">Log In</a>
            </li>
            <li class="nav-link">
                <a href="#">Register</a>
            </li>
        </ul>
    </div>
    <?php endif; ?> <!-- endif -->
</nav>