<?php


  /**
   * 
   * this is the main page, which is accessible to everyone. 
   * 
   * we require the database connection to be established before we can proceed.
   * 
   * 
   * then write the query that selects the posts from the database in descending order.
   * 
   */
  require './config/database.php';

  $query = "SELECT * FROM posts ORDER BY date DESC";

  $result = mysqli_query( $conn, $query );
  $result = mysqli_fetch_all( $result, MYSQLI_ASSOC ); // we fetch them and store them in an associative array.
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
    <title>Coder</title>
</head>

<body>
    <?php require 'inc/navbar.php' ?> <!-- require the navbar file -->
    <div class="main-posts-container">
        <?php if ( $result ): ?> <!-- if the $result variable is true it will display run a foreach loop that displays all the posts -->
        <?php foreach ( $result as $post ): ?> <!-- we use the foreach loop to display all the posts -->
            <!-- $post variable is now a single row in the database, in a associative array, we can access its columns by using the names of the columns as array keys  -->
            <div class="single-post">
                <a href="single-post.php?id=<?= $post['id'] ?>" > <!-- wrap the card with an a tag that directs the single-post with the id of the post passed as a form variable -->
                <div class="single-post-header">
                    <p class="date-created"><?= $post['date']; ?></p> <!-- echo the post date -->
                    <div class="post-title-category">
                        <h2 class="post-title"><?= $post['title']; ?></h2> <!-- echo the post title -->
                        <p class="post-category"><?= $post['category']; ?></p> <!-- echo the post category -->
                    </div>
                </div>
                <div class="image-container">
                    <img src="postImages/<?= $post['post_image']; ?>" alt=""> <!-- img tag, that has the path postImages/ on it preset, then we just echo the photo name that is stored in the database -->
                </div>
                <div class="single-post-body">
                    <?php

                        /**
                         * 
                         * this is where we get the post body that is stored in the database.
                         *   we use the explode function to divide the post body into an array of strings,
                         *   first we seperate the post subtitles from the paragraphs by the characterset *%^sp^%*,
                         *   then we use the ^%seperator%^ to seperate the paragraphs, and subtitles from each other,
                         *   then we use the foreach loop to loop them as $key => $value,
                         *    so that we can use the key of the variable to access the value of the paragraphs array in that iteration.
                         *     we can assume that the subtitles array will always be the same length as the paragraphs array, 
                         *      that is why we use the $key of the $subTitles array to access the value of the $paragraphs array.
                         * 
                         */
                      $postBody = $post['body']; // get the whole body
                      $postBody = explode( "*%^sp^%*", $postBody ); // seperate the subtitles from the paragraphs by the characterset *%^sp^%*
                      $subTitles = explode( "^%seperator%^", $postBody[0] ); // seperate the subtitles from each other
                      $postParagraphs = explode( "^%seperator%^", $postBody[1] ); // seperate the paragraphs from each other
                      foreach ( $subTitles as $key => $value ): // run the foreach loop for the body of the post
                    ?>
                    <div class="single-post-section">
                        <h3 class="single-post-section-sub-title"><?= $value ?></h3> <!-- echo the value, which is the subtitle at that iteration -->
                        <p class="single-post-section-paragrah">
                            <?= str_replace( "^%break%^", "<br>", $postParagraphs[$key] ); ?></p> <!-- echo the paragraph at that iteration, but also replace the ^%break%^ characterset by the <br /> tag -->
                    </div>
                    <?php endforeach; ?> <!-- end the foreach loop for the body of the post -->
                </div>
                <div class="discussions-button-wrapper">
                    <p class="discussions-button">
                        Discussions (<?php

                                    /**
                                     * 
                                     * this is where we get the number of discussions that are related to the post.
                                     * we query the database with the post id at that current iteration, then we num the rows that are returned.
                                     * 
                                     */
                                   $postId = $post['id'];
                                   $query = "SELECT * FROM comments WHERE post_id = $postId";
                                   $result = mysqli_query( $conn, $query );
                                   $result = mysqli_num_rows( $result );
                                   echo $result;
                                 ?> replies) </p>
                </div>
            </a>
            </div>
        <?php endforeach; ?> <!-- end the foreach loop of the whole single post -->
        <?php else: ?> <!-- this else will render if there are no posts in the database -->
        <p style="padding-bottom: 334px;">No posts yet</p>
        <?php endif; ?> <!-- we end the if conditon that is started at line 38 -->
    </div>
    <?php include 'inc/footer.php' ?> <!-- include the footer -->
</body>

</html>