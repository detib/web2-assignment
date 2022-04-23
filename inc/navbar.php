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
            <?php if (!$user): ?>
            <li class="nav-link">
                <a href="login.php">Log In</a>
            </li>
            <li class="nav-link">
                <a href="register.php">Register</a>
            </li>
            <?php endif; ?>
            <?php if ($user && $role == 'admin'): ?>
            <li class="nav-link">
                <a href="admin/index.php">Dashboard</a>
            </li>
            <?php endif; ?>
        </ul>
    </div>
    <?php if ( $user ): ?>
    <div class="user">
        <a href="$"><?php echo $user['username']; ?></a>
        <div class="profile-pic"><a href="#"><img src="userImages/<?php echo $user['picture'] ?>" alt=""></a></div>
        <div class="user-dropdown">
            <a href="logout.php">Sign Out</a>
        </div>
    </div>
    <?php else: ?>
    <div class="nav-signedout">
        <ul class="nav-items">
            <li class="nav-link">
                <a href="login.php">Log In</a>
            </li>
            <li class="nav-link">
                <a href="register.php">Register</a>
            </li>
        </ul>
    </div>
    <?php endif; ?>
</nav>