<!-- detib - Detideti1 -->
<!-- admin -->

<?php

  require './config/database.php';
  if ( !isset( $_GET['id'] ) ) {
    header( 'Location: index.php' );
    die();
  }

  $id = $_GET['id'];

  $query = "SELECT * FROM posts WHERE id = $id";
  $post = mysqli_query( $conn, $query );
  $post = mysqli_fetch_assoc( $post );
  if ( !$post ) {
    header( 'Location: index.php' );
    die();
  }
  $edit_date = ( $post['date'] == $post['edit_date'] ) ? '' : $post['edit_date'];
  $queryComments = "SELECT * FROM comments WHERE post_id = $id ORDER BY time DESC";

  $comments = mysqli_query( $conn, $queryComments );
  $comments = mysqli_fetch_all( $comments, MYSQLI_ASSOC );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/index.css">
    <title>Blog App Post</title>
</head>

<body>
    <?php include 'inc/navbar.php' ?>
    <div class="main-posts-container single-post-page">
        <div class="single-post">
            <div class="single-post-header">
                <p class="date-created"><?php echo date("d-M-y",strtotime($post['date'])); ?></p>
                <?php if ( $edit_date ): ?>
                <p class="date-created">Last edit on: <?php echo date("d-M-y : H-i",strtotime($post['edit_date'])); ?></p>
                <?php endif; ?>
                <div class="post-title-category">
                    <h2 class="post-title"><?php echo $post['title']; ?></h2>
                    <p class="post-category"><?php echo $post['category']; ?></p>
                </div>
            </div>
            <div class="image-container">
                <img src="postImages/<?php echo $post['post_image']; ?>" alt="">
            </div>
            <div class="single-post-body">
                <?php
                  $postBody = $post['body'];
                  $postBody = explode( "*%^sp^%*", $postBody );
                  $postTitles = explode( "^%implode%^", $postBody[0] );
                  $postParagraphs = explode( "^%implode%^", $postBody[1] );
                  foreach ( $postTitles as $key => $value ):
                ?>
                <div class="single-post-section">
                    <h3 class="single-post-section-sub-title"><?php echo $value ?></h3>
                    <p class="single-post-section-paragrah"><?php echo str_replace("^%break%^", "<br />",$postParagraphs[$key]); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="post-comments">
            <?php if ( $user ): ?>
            <div class="add-comment-container">
                <div class="user-image-container">
                    <img src="userImages/<?php echo $picture ?>" alt="">
                </div>
                <form class="comment-form" action="./config/addComent.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" name="username" value="<?php echo $username; ?>">
                    <textarea placeholder="Enter your comment..." name="comment" id="" rows="3"></textarea>
                    <input type="submit" value="Add Comment" name="submit">
                </form>
            </div>
            <?php endif ?>
            <?php if ( $comments ): ?>
            <?php
                foreach ( $comments as $comment ):

                    $commentUser = $comment['user'];
                    $queryUser = "SELECT username, picture FROM users WHERE username = '$commentUser'";
                    $currentCommentUser = mysqli_query( $conn, $queryUser );
                    $currentCommentUser = mysqli_fetch_assoc( $currentCommentUser );
                    $userPicture = $currentCommentUser['picture'];
                    $userName = $currentCommentUser['username'];
                ?>
            <div class="comment-container">
                <div class="user-data-comment">
                    <div class="user-image-container">
                        <img src="userImages/<?php echo $userPicture; ?>" alt="">
                    </div>
                    <p class="user-name"><?php echo $userName; ?></p>
                    <p class="post-time">
                        <?php

                              $commentTime = strtotime( $comment['time'] );

                              if ( $commentTime < strtotime( '-1 year' ) ) {
                                $commentTime = date( 'H-i : d-M-Y', $commentTime );
                                echo $commentTime;
                              } else {
                                $commentTime = date( 'H-i : d-M', $commentTime );
                                echo $commentTime;
                              }
                            ?>
                    </p>
                </div>
                <div class="comment-content">
                    <p class="comment-text"><?php echo nl2br($comment['body']); ?></p>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p class="no-comments">No comments yet</p>
            <?php endif; ?>
        </div>
        <!--<?php include 'inc/footer.php' ?> -->
</body>

</html>