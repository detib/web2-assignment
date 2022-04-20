<?php 
    require '../config/database.php';
    require '../config/session.php';
    require 'admin.php'; 
    
    // query the users
    $query = "SELECT * FROM users WHERE is_active='0' ORDER BY date_created DESC LIMIT 3";
    $result = mysqli_query( $conn, $query );
    $newUsers = mysqli_fetch_all( $result, MYSQLI_ASSOC );

    // query the posts
    $query = "SELECT * FROM posts";
    $result = mysqli_query( $conn, $query );
    $newPosts = mysqli_fetch_all( $result, MYSQLI_ASSOC );
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="styles/adminmain.css">
    <link rel="stylesheet" href="styles/admin-index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
    integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/adminmain.js" defer></script>
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="main-wrapper">
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <h1 class="admin-title">Welcome back <?php echo $name; ?></h1>
            <div class="dashboard-box new-users">
                <h2 class="small-title">New Users</h2>
                <?php if($newUsers):?>
                <div class="field-names grid-layout">
                    <p>Profile Picture</p>
                    <p>Name</p>
                    <p>Surname</p>
                    <p>Email</p>
                    <p>Username</p>
                    <p>Date Created</p>
                </div>
                <?php foreach($newUsers as $user): ?>
                <div class="single-new-user grid-layout">
                    <div class="profile-picture">
                        <img src="../userImages/<?php echo $user['picture'] ?>" alt="">
                    </div>
                    <h3 class="user-name"><?php echo $user['name'];?></h3>
                    <h3 class="user-surname"><?php echo $user['surname'];?></h3>
                    <p class="user-email"><?php echo $user['email'];?></p>
                    <p class="user-username"><?php echo $user['username'];?></p>
                    <p class="user-date-created"><?php echo $user['date_created'];?></p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No new users</p>
                <?php endif; ?>
                <div class="view-more-wrapper">
                    <a href="users.php" class="view-more">View All Users</a>
                </div>
            </div>
            <div class="dashboard-box latest-posts">
                <h2 class="small-title">Latest Posts</h2>
                <?php if($newPosts):?>
                <div class="field-names">
                    <p>Title</p>
                    <p>Date Created</p>
                    <p>Author</p>
                </div>
                <?php foreach($newPosts as $post): ?>
                <div class="single-new-post">
                    <h3 class="post-title"><?php echo $post['title'];?></h3>
                    <p class="post-body"><?php echo $post['body'];?></p>
                    <p class="post-date"><?php echo $post['date'];?></p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No new posts</p>
                <?php endif; ?>
                <div class="view-more-wrapper">
                    <a href="posts.php" class="view-more">View All Posts</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>