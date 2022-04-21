<!-- detib - Detideti1 -->
<!-- admin -->

<?php 

    require './config/database.php';

    $query = "SELECT * FROM posts ORDER BY date DESC";

    $result = mysqli_query($conn, $query);
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/main.css">
    <link rel="stylesheet" href="styles/index.css">
    <title>Blog App</title>
</head>

<body>
    <?php include 'inc/navbar.php' ?>
    <div class="main-posts-container">
        <?php if($result): ?>
            <?php foreach($result as $post): ?>
        <div class="single-post">
            <div class="single-post-header">
                <p class="date-created"><?php echo $post['date'];?></p>
                <div class="post-title-category">
                    <h2 class="post-title"><?php echo $post['title'];?></h2>
                    <p class="post-category"><?php echo $post['category'];?></p>
                </div>
            </div>
            <div class="image-container">
                <img src="postImages/<?php echo $post['post_image'];?>" alt="">
            </div>
            <div class="single-post-body">
                <?php 
                    $postBody = $post['body'];
                    $postBody = explode("*%^sp^%*",$postBody);
                    $postTitles = explode("^%implode%^", $postBody[0]);
                    $postParagraphs = explode("^%implode%^", $postBody[1]);
                    foreach($postTitles as $key => $value):
                ?>
                <div class="single-post-section">
                    <h3 class="single-post-section-sub-title"><?php echo $value?></h3>
                    <p class="single-post-section-paragrah"><?php echo str_replace("^%break%^", "<br>", $postParagraphs[$key]);?></p>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="discussions-button-wrapper">
                <a href="single-post.php?id=<?php echo $post['id']?>" class="discussions-button">
                Discussions (<?php 
                        $postId = $post['id'];
                        $query = "SELECT * FROM comments WHERE post_id = $postId";
                        $result = mysqli_query($conn, $query);
                        $result = mysqli_num_rows($result);
                        echo $result;
                
                ?> replies) </a>
            </div>
        </div>
        <?php endforeach; ?>
        <?php else: ?>
        <p>No posts yet</p>
        <?php endif;?>
    </div>
    <?php ?>
    <!--<?php include 'inc/footer.php' ?> -->
</body>

</html>