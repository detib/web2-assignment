<?php require 'config/session.php'; ?>

<nav>
    <h1>BlogApp</h1>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if ( $user ): ?>
        <li><a href="logout.php">Log Out</a></li>
            <?php if ($role == 'admin' ): ?>
                <li><a href="admin/index.php">Dashboard</a></li>
            <?php endif; ?>
        <?php else: ?>
            <li><a href="login.php">Log In</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>