<?php
  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

  // query only the latest three users, since the content does not need to be fully seen here
  $query = "SELECT * FROM users WHERE is_active='0' ORDER BY date_created DESC LIMIT 3";
  // execute the query  
  $result = mysqli_query( $conn, $query );
  // fetch the data into associative array so that we can run a foreach loop to display the data that we got from the database
  $newUsers = mysqli_fetch_all( $result, MYSQLI_ASSOC );

  // query only the latest three posts, since the content does not need to be fully seen here
  $query = "SELECT * FROM posts ORDER BY edit_date DESC LIMIT 3";
  // execute the query  
  $result = mysqli_query( $conn, $query );
  // fetch the data into associative array so that we can run a foreach loop to display the data that we got from the database
  $newPosts = mysqli_fetch_all( $result, MYSQLI_ASSOC );
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- link all the css files that this page uses -->
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="styles/adminmain.css">
    <link rel="stylesheet" href="styles/admin-index.css">
    <!-- link the font-awesome library that we used for the icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
        integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- get the script adminmain.js and use defer so that it loads after the dom has finished loading -->
    <script src="js/adminmain.js" defer></script>
    <title>Admin Dashboard</title>
</head>

<body>
    <div class="main-wrapper">
        <!-- include the admin sidebar that is in the inc folder -->
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <!-- echo $name of the user currently logged in -->
            <!-- we do not need to check if the $name variable is set because we have the config files above that do not allow a user here if that variable is not set -->
            <h1 class="admin-title">Welcome back <?php echo $name; ?></h1>
            <div class="dashboard-box new-users">
                <h2 class="small-title">New Users</h2>
                <!-- we do an if statement that checks if the $newUsers variable is not empty, if it was empty it would be falsey and not render the markup below -->
                <?php if ( $newUsers ): ?>
                <div class="field-names grid-layout">
                    <p>Profile Picture</p>
                    <p>Name</p>
                    <p>Surname</p>
                    <p>Email</p>
                    <p>Username</p>
                    <p>Date Created</p>
                </div>
                <!-- we loop through the $newUsers associative array  -->
                <?php foreach ( $newUsers as $user ): ?>
                <div class="single-new-user grid-layout">
                    <div class="profile-picture">
                        <!-- we echo the name of the image stored in the database that is also stored in the userImages folder so that it outputs to the img tag -->
                        <img src="../userImages/<?= $user['picture'] ?>" alt="">
                    </div>
                    <!-- echo all the other details of the current user in the iteration -->
                    <h3 class="user-name"><?= $user['name']; ?></h3>
                    <h3 class="user-surname"><?= $user['surname']; ?></h3>
                    <p class="user-email"><?= $user['email']; ?></p>
                    <p class="user-username"><?= $user['username']; ?></p>
                    <p class="user-date-created"><?= $user['date_created']; ?></p>
                </div>
                <!-- we end the foreach loop here -->
                <?php endforeach; ?>
                <!-- this else will run if the if($newUsers) above is false -->
                <?php else: ?>
                <p><i class="fa-solid fa-folder-open"></i> No new users</p>
                <!-- this is where we end the if($newUsers) condition  -->
                <?php endif; ?>
                <div class="view-more-wrapper">
                    <a href="users.php" class="view-more">View All Users</a>
                </div>
            </div>
            <div class="dashboard-box latest-posts">
                <h2 class="small-title">Latest Posts</h2>
                <!-- if statement that checks if the $newPosts variable is not empty,
                     if it was empty it would be falsey and not render the markup below,
                     just like the code above  -->
                <?php if ( $newPosts ): ?>
                <div class="single-post-names field-names">
                    <p>Title</p>
                    <p>Body</p>
                    <p>Category</p>
                    <p>Date Created</p>
                    <p>Last Edit</p>
                    <p>Comments</p>
                </div>
                <!-- foreach loop that loops through the $newPosts associative array -->
                <?php foreach ( $newPosts as $post ):
                    // the *%^sp^%* is a special characterset that we use to seperate the body of the post from the subtitles
                    $postBody = explode( "*%^sp^%*", $post['body'] );
                    // we use the explode function to seperate the different body parts of the post that are seperated with the special characterset ^%seperator%^
                    // and in this case count them with the count function to display how many sub articles there are in the post
                    $postSubArticleCount = count( explode( "^%seperator%^", $postBody[0] ) );
                    // then the forloop starts displaying html markup here
                  ?>
                <div class="single-new-post">
                    <!-- we echo the post title in the current iteration -->
                    <h3 class="post-title"><?= $post['title']; ?></h3>
                    <!-- we echo the post sub articles in the current iteration that are counted above-->
                    <p class="post-body">Sub Articles: <?= $postSubArticleCount; ?></p>
                    <!-- we echo the post category in the current iteration-->
                    <p class="post-category"><?= $post['category']; ?></p>
                    <!-- we echo the post date in the current iteration-->
                    <p class="post-date"><?= $post['date'] ?></p>
                    <!-- we echo the post edit date in the current iteration but we check it with the ternary operator 
                         to see if the edit date is different from the date created, if it is different we echo the edit date 
                         if it is the same we echo "No Edits"
                    -->
                    <p class="post-edit-date"><?=
                         ( $post['edit_date'] != $post['date'] ) ? $post['edit_date'] : 'No edits';

                    ?></p>
                    <!-- in this part we are outputing to the dom the number of comments a post has
                         we do this by querying the database for the number of comments that are associated with the post
                            we do this by using the post id and then we use the count function to count the number of comments
                            that are associated with the post id in this iteration.
                    -->
                    <p class="post-comments post-comments-number"><?php
                        $query = "SELECT * FROM comments WHERE post_id = {$post['id']}";
                        $result = mysqli_query( $conn, $query );
                        $comments = mysqli_fetch_all( $result, MYSQLI_ASSOC );
                        echo count( $comments );
                ?></p>
                    <!-- at this point we are still in the iteration until the foreach loop ends
                            we are outputing to the dom the link to the single post in the current iteration
                            we do this by using the post id and then we use the echo function to output the link to the post
                            we write the link to the post in the href attribute of the link as the page we want to go to
                            and also send the id of that post as a GET parameter so that we can access it in the single post page to display that post
                    -->
                    <div class="view-post-wrapper">
                        <a href="../single-post.php?id=<?= $post['id']?>" class="view-post">View Post</a>
                    </div>
                </div>
                <?php endforeach; ?> <!-- endforeach to end the foreach loop that outputs the latest posts -->
                <?php else: ?> <!-- else to run if the if statement above is false -->
                <p><i class="fa-solid fa-folder-open"></i> No new posts</p>
                <?php endif; ?> <!-- end of if statement -->
                <div class="view-more-wrapper"> 
                    <a href="posts.php" class="view-more">View All Posts</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>