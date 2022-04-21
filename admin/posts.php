<?php
  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

  $query = "SELECT * FROM posts ORDER BY date DESC";
  $result = mysqli_query( $conn, $query );
  $posts = mysqli_fetch_all( $result, MYSQLI_ASSOC );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="styles/adminmain.css">
    <link rel="stylesheet" href="styles/posts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
    integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/adminmain.js" defer></script>
    <title>Admin Dashboard - Posts</title>
</head>

<body>
    <div class="main-wrapper">
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <div class="posts-header">
                <h1 class="admin-title">All Posts</h1>
                <div class="button-wrapper">
                    <a class="new-post-button" href="newpost.php">New Post</a>
                </div>
            </div>
            <div class="dashboard-box all-posts">
                <?php if ( $posts ): ?>
                <div class="field-names grid-layout">
                    <p>Title</p>
                    <p>Body</p>
                    <p>Category</p>
                    <p>Date Created</p>
                    <p>Edit Date</p>
                    <p>Comments</p>
                    <p>Actions</p>
                </div>
                <?php foreach ( $posts as $post ): 
                    
                        $postBody = explode("*%^sp^%*",$post['body']);
                        $postSubArticleCount = count(explode("^%implode%^", $postBody[0]));
                    ?>
                <div class="single-post grid-layout">
                    <h3 class="post-title"><?php echo $post['title']; ?></h3>
                    <p class="post-body">Sub Articles: <?php echo $postSubArticleCount; ?></p>
                    <p class="post-category"><?php echo $post['category']; ?></p>
                    <p class="post-comments"><?php echo $post['date'] ?></p>
                    <p class="post-comments"><?php echo $post['edit_date'] ?></p>
                    <p class="post-comments"><?php 
                        $query = "SELECT * FROM comments WHERE post_id = {$post['id']}";
                        $result = mysqli_query( $conn, $query );
                        $comments = mysqli_fetch_all( $result, MYSQLI_ASSOC );
                        echo count( $comments );
                    ?></p>
                    <div class="button-actions">
                        <div class="button-action-wrapper">
                            <a class="button-action view" href="../single-post.php?id=<?php echo $post['id'] ?>">View</a>
                        </div>
                        <div class="button-action-wrapper">
                            <a class="button-action edit" href="editpost.php?post=<?php echo $post['id'] ?>">Edit</a>
                        </div>
                        <div class="button-action-wrapper">
                            <a class="button-action delete"
                                href="config/deletepost.php?post=<?php echo $post['id'] ?>">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No posts to show</p>
                <?php endif; ?>
            </div>
        </div>
</body>

</html>