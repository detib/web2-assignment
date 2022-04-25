<?php

 /*
   *
   * this page is the page that displays all the posts in the admin dashboard
   *
   * first we require the necessary files
   * like the database, session and the admin files, which check for the user being logged in and if they are an admin
   *
   */

  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

  /**
   * 
   * we write the query for all the posts, execute it and put them as a associative array in the $posts variable
   * 
   */

  $query = "SELECT * FROM posts ORDER BY date DESC"; // query for all the posts, we have the ORDER BY date DESC so that the newest posts are on top
  $result = mysqli_query( $conn, $query );
  $posts = mysqli_fetch_all( $result, MYSQLI_ASSOC );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- 
        linking all the css, js files that we used in this page, 
            one of the css files is used for the font-awesome icons(it is not responsible for any type of button, or any other styles in the page)
     -->
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="styles/adminmain.css">
    <link rel="stylesheet" href="styles/posts.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
    integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/adminmain.js" defer></script>
    <title>Admin Dashboard | Posts</title>
</head>

<body>
    <div class="main-wrapper">
        <?php include 'inc/nav.php' ?> <!-- we include the sidebar for the admin panel -->
        <div class="main-content">
            <div class="posts-header">
                <h1 class="admin-title">All Posts</h1>
                <div class="button-wrapper">
                    <a class="new-post-button" href="newpost.php">New Post</a>
                </div>
            </div>
            <div class="dashboard-box all-posts">
                <!-- if condition to check if the $posts variable is not empty, if it is empty it would be falsey and not display the html below -->
                <?php if ( $posts ): ?>
                <div class="field-names grid-layout">
                    <p>Title</p>
                    <p>Body</p>
                    <p>Category</p>
                    <p>Date Created</p>
                    <p>Edit Date</p>
                    <p>Comments</p>
                    <p class="actions-text">Actions</p>
                </div>
                <?php foreach ( $posts as $post ): 
                    
                        $postBody = explode("*%^sp^%*",$post['body']);
                        $postSubArticleCount = count(explode("^%seperator%^", $postBody[0]));

                        /**
                         * 
                         * this is where we start the foreach loop to loop through all the posts and display them
                         * we also use the explode function to split the body, and explode only the first part of the body, which are the subtitles
                         * and we use the count() function to count the number of sub articles, in order to display them as "Sub Articles: n"
                         * 
                         */
                    ?>
                <div class="single-post grid-layout">
                    <!-- we echo the post details in the current iteration, like the $post[title], or $post['category'] -->
                    <h3 class="post-title"><?= $post['title']; ?></h3>
                    <p class="post-body">Sub Articles: <?= $postSubArticleCount; ?></p>
                    <p class="post-category"><?= $post['category']; ?></p>
                    <p class="post-date"><?= $post['date'] ?></p>
                    <p class="post-edit-date"><?=
                        // we check with the ternary operator if the edit date is different from the creation date,
                        //   if they are different we echo the edit date, if it is not we echo "No edits".
                     ( $post['edit_date'] != $post['date'] ) ? $post['edit_date'] : 'No edits';
                    
                    ?></p>
                    <p class="post-comments"><?php 
                        /**
                         * 
                         * this is where we check how many comment a post has,
                         *  we run a query to select from the comments database, and also check the post_id, in the current iteration
                         *  after we execute the query, we put the result in the $comments variable, and we count the number of comments
                         * 
                         */
                        $query = "SELECT * FROM comments WHERE post_id = {$post['id']}";
                        $result = mysqli_query( $conn, $query );
                        $comments = mysqli_fetch_all( $result, MYSQLI_ASSOC );
                        echo count( $comments ); // count() function counts the number of elements in the array and returns that number
                    ?></p>
                    <div class="button-actions">
                        <div class="button-action-wrapper"> 
                            <!-- 
                                these are the buttons to view, edit, delete a post.
                                we use the get method to pass the post id to the next page, and we use the href to redirect to the page.
                            -->
                            <a class="button-action view" href="../single-post.php?id=<?= $post['id'] ?>">View</a>
                        </div>
                        <div class="button-action-wrapper">
                            <a class="button-action edit" href="editpost.php?post=<?= $post['id'] ?>">Edit</a>
                        </div>
                        <div class="button-action-wrapper">
                            <a class="button-action delete"
                                href="config/deletepost.php?post=<?= $post['id'] ?>">Delete</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?> <!-- the foreach loop ends here -->
                <?php else: ?> <!-- the else for the if at the top, this will render the element below it if the condition is not true, that condition is the users being not empty -->
                <p>No posts to show</p>
                <?php endif; ?> <!-- endif to end the if condtion -->
            </div>
        </div>
</body>

</html>