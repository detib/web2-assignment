<?php

    /**
     * 
     * this is the single-post page, that outputs a single post along with its comments.
     * 
     * it gets an id in the through the get method, then we query the database in order to get the post with that id,
     * then we get the comments that are related to that post, and then we echo the post and the comments.
     * 
     * also at the comments, we query the database, the table of users, and get the user name and the user image,
     *  then output the author of the comment along with its comment.
     * 
     */

  require './config/database.php'; // get the database connection
  if ( !isset( $_GET['id'] ) ) { // if no get method is sent we redirect to the index page
    header( 'Location: index.php' );
    die();
  }

  $id = $_GET['id']; // save the $id in the variable

  $query = "SELECT * FROM posts WHERE id = $id"; // query for the single post
  $post = mysqli_query( $conn, $query ); // execute the query for the post
  $post = mysqli_fetch_assoc( $post ); // fetch the result and store it in an associative array
  if ( !$post ) { // if the post is not found we redirect to the index page
    header( 'Location: index.php' );
    die();
  }
  $edit_date = ( $post['date'] == $post['edit_date'] ) ? NULL : $post['edit_date']; // we check the edit date and if it is the same as the date then we don't show it, else we show it.
  $queryComments = "SELECT * FROM comments WHERE post_id = $id ORDER BY time DESC"; // query for the comments and order them in newest at the top

  $comments = mysqli_query( $conn, $queryComments ); // execute the query for the comments
  $comments = mysqli_fetch_all( $comments, MYSQLI_ASSOC ); // fetch the result and store it in an associative array

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link all the css files that this page uses -->
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/inc.css">
    <title>Coder | Post</title>
</head>

<body>
    <?php include 'inc/navbar.php' ?>
    <div class="single-post-page">
        <div class="single-post">
            <div class="single-post-header">
                <p class="date-created"><?= date("d-M-y",strtotime($post['date'])); ?></p>
                <?php if ( $edit_date ): ?> <!-- we check the $edit_date variable and if is false it will not show the edit date since it is the same, so no edits have happened -->
                <p class="date-created">Last edit on: <?= date("d-M-y : H-i",strtotime($post['edit_date'])); ?></p> <!-- $post['edit_date'] is a timestamp so we run it through the date function to format our date the way we want it -->
                <?php endif; ?> <!-- end of the $edit_date if statement-->
                <div class="post-title-category">
                    <h2 class="post-title"><?= $post['title']; ?></h2> <!-- echo the $post['title'], the title of the post -->
                    <p class="post-category"><?= $post['category']; ?></p> <!-- echo the $post['category'], the category of the post -->
                </div>
            </div>
            <div class="image-container">
                <img src="postImages/<?= $post['post_image']; ?>" alt=""> <!-- echo the $post['post_image'], the image of the post, the path of the folder location is hardcoded, and we just check which image we want, which is associated to the post -->
            </div>
            <div class="single-post-body">
                <?php
                /**
                 * 
                 * This part is the same as the one in the index page,
                 *   we have the body of the post, as one column in the database, and we seperate it into sub articles.
                 * 
                 */
                  $postBody = $post['body'];
                  $postBody = explode( "*%^sp^%*", $postBody );
                  $postTitles = explode( "^%seperator%^", $postBody[0] );
                  $postParagraphs = explode( "^%seperator%^", $postBody[1] );
                  foreach ( $postTitles as $key => $value ): // start the subarticles foreach loop
                ?>
                <div class="single-post-section">
                    <h3 class="single-post-section-sub-title"><?= $value ?></h3> <!-- echo the value of the subtitle -->
                    <p class="single-post-section-paragrah"><?= str_replace("^%break%^", "<br />",$postParagraphs[$key]); ?></p> <!-- echo the value of the paragraph -->
                </div>
                <?php endforeach; ?> <!-- end the subarticles foreach loop -->
            </div>
        </div>
        <div class="post-comments">
            <div class="post-comments-title">
                <?php 
                    /**
                     * 
                     * this is where we query the database for the comments of the post that are associated with the post id,
                     * then we just count the number of the comments and echo that to the user.
                     * 
                     */
                    $postId = $post['id'];
                    $query = "SELECT * FROM comments WHERE post_id = $postId";
                    $result = mysqli_query($conn, $query);
                    $result = mysqli_num_rows($result);
                    echo $result;
                ?> Comments
            </div>
            <?php if ( $user ): ?> <!-- this is the condition that checks if a user is logged in, we have the session variables by requiring the navbar which requires the session variables-->
            <div class="add-comment-container">
                <div class="user-image-container">
                    <img src="userImages/<?= $picture ?>" alt=""> <!-- we echo the users profile picture that is in the session variables -->
                </div>
                <!-- the form that sends the comment, it has two hidden input so we can also send the post id to link the posts with the comments, and to link the user with the comment -->
                <form class="comment-form" action="./config/addComent.php" method="post">
                    <input type="hidden" name="id" value="<?= $id; ?>"> <!-- the id of the post -->
                    <input type="hidden" name="username" value="<?= $username; ?>"> <!-- the username of the user -->
                    <textarea placeholder="Enter your comment..." name="comment" required></textarea> <!-- body of the comment -->
                    <input type="submit" value="Add Comment" name="submit"> <!-- submit button of the form -->
                </form>
            </div>
            <?php endif ?> <!-- end the if statement that checks if a user is logged in -->
            <?php if ( $comments ): ?> <!-- check if there are comments, if not it will not run the foreach loop -->
            <?php
                foreach ( $comments as $comment ): // foreach loop for the comments, and also query the username and picture to associate the user with the comment

                    $commentUser = $comment['user']; // store the username of the user that made the comment
                    $queryUser = "SELECT username, picture FROM users WHERE username = '$commentUser'"; // query the username and picture of the user
                    $currentCommentUser = mysqli_query( $conn, $queryUser ); // run the query
                    $currentCommentUser = mysqli_fetch_assoc( $currentCommentUser ); // fetch the result
                    $userPicture = $currentCommentUser['picture']; // the picture of the user
                    $userName = $currentCommentUser['username']; // the username of the user
                ?>
            <div class="comment-container">
                <div class="user-data-comment">
                    <div class="user-image-container">
                        <img src="userImages/<?= $userPicture; ?>" alt=""> <!-- output the user profile picture -->
                    </div>
                    <p class="user-name"><?= $userName; ?></p> <!-- output the username of the user -->
                    <p class="post-time"><?php

                              $commentTime = strtotime( $comment['time'] ); // get the timestamp of the comment

                              if ( $commentTime < strtotime( '-1 year' ) ) { 
                                  // check if the comment is older than one year
                                  // if it is older than one year, we just output the date with the year in the format we want
                                $commentTime = date( 'H-i : d-M-Y', $commentTime );
                                echo $commentTime;
                              } else { 
                                  // if it is not older than one year, we just output the date with the year removed
                                $commentTime = date( 'H-i : d-M', $commentTime );
                                echo $commentTime;
                              }
                            
                    ?></p>
                </div>
                <div class="comment-content">
                    <p class="comment-text"><?= nl2br($comment['body']); ?></p> <!-- output the comment body, nl2br() function outputs br tags to the html markup, as posted in the comment textarea -->
                </div>
            </div>
            <?php endforeach; ?> <!-- end the foreach loop for the comments -->
            <?php endif; ?> <!-- end the if statement that checks if there are comments -->
        </div>
    </div>
    <?php include 'inc/footer.php' ?> <!-- include the footer -->
</body>

</html>