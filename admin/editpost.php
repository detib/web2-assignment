<?php

  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="styles/adminmain.css">
    <link rel="stylesheet" href="styles/newpost.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
        integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="js/adminmain.js" defer></script>
    <script src="js/newpost.js" defer></script>
    <title>Admin Dashboard | New Post</title>
</head>

<body>
    <div class="main-wrapper">
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <?php
              $allowedExtensions = ['jpg', 'jpeg', 'png'];
              $invalidFile = false;

              if ( isset( $_POST['submit'] ) ) {

                $post_id = $_POST['post-id'];
                $subtitles = $_POST['subtitle'];
                $paragraphs = $_POST['paragraph'];
                $paragraphs = array_map(
                  function ( $item ) {
                    
                    $item = nl2br( $item );
                    return str_replace("<br />", "^%break%^", $item);
                  }, $paragraphs );
                $subtitles = implode( '^%implode%^', $subtitles );
                $paragraphs = trim(implode( '^%implode%^', $paragraphs ));

                $body = htmlentities( mysqli_real_escape_string( $conn, "$subtitles *%^sp^%* $paragraphs" ) );
                $title = htmlentities( mysqli_real_escape_string( $conn, $_POST['title'] ) );
                $category = htmlentities( mysqli_real_escape_string( $conn, $_POST['category'] ) );

                if ( $_FILES['post-image']['error'] == 0 ) {
                  // get the file uploaded from the form submission
                  $file_name = $_FILES['post-image']['name'];
                  $file_tmp = $_FILES['post-image']['tmp_name'];
                  $file_ext = explode( '.', $file_name );
                  $file_ext = strtolower( end( $file_ext ) );

                  // generate id for the image to store in the database and access it with that id
                  $file_name = "post-img-" . substr( base64_encode( sha1( mt_rand() ) ), 0, 20 );
                  $target_dir = "../postImages/$file_name.$file_ext";
                  if ( in_array( $file_ext, $allowedExtensions ) ) {
                    move_uploaded_file( $file_tmp, $target_dir );
                  } else {
                    $invalidFile = true;
                  }
                } else {
                  $file_name = NULL;
                }

                if ( !$invalidFile ) {
                  $sql = $file_name ?
                  "UPDATE posts SET title = '$title', body = '$body', category = '$category', post_image = '$file_name.$file_ext' WHERE id = $post_id" :
                  "UPDATE posts SET title = '$title', body = '$body', category = '$category' WHERE id = $post_id";
                  if($file_name) {
                    $query = mysqli_query( $conn, "SELECT post_image FROM posts WHERE id = $post_id" );
                    $image = mysqli_fetch_assoc( $query );
                    $image = $image['post_image'];
                    unlink( "../postImages/$image" );
                  }
                  if ( !mysqli_query( $conn, $sql ) ) {
                    echo 'Error: ' . mysqli_error( $conn );
                  }
                    header( "Location: posts.php" );
                }
              }

              if(isset($_GET['post'])) {
                $id = $_GET['post'];
                $sql = "SELECT * FROM posts WHERE id = $id";
                $result = mysqli_query( $conn, $sql );
                $post = mysqli_fetch_assoc( $result );
                $title = $post['title'];
                $category = $post['category'];
                $post_image = $post['post_image'];
                $body = explode("*%^sp^%*", $post['body']);
                $subtitles = explode( '^%implode%^', $body[0] );
                $paragraphs = explode( '^%implode%^', $body[1] );
              } 

            ?>
            <h1 class="admin-title">New Post</h1>
            <div class="dashboard-box">
                <form class="new-post-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="input-field">
                        <label class="new-post-title" for="title">Title</label>
                        <input type="text" name="title" id="title" required value="<?php echo $title;?>">
                    </div>
                    <div class="body-of-post">
                        <h2 class="body-title">Body</h2>
                        <div id="body-fields-wrapper" class="body-fields-wrapper">
                            <?php foreach ($subtitles as $key => $subtitle): ?>
                            <div class="body-sub-title-paragraph">
                                <div class="input-field">
                                    <label>Sub Title</label>
                                    <input value="<?php echo $subtitle?>" type="text" name="subtitle[]" id="title"
                                        required>
                                </div>
                                <div class="input-field">
                                    <label>Paragraph</label>
                                    <textarea name="paragraph[]"
                                        required><?php echo trim(str_replace("^%break%^", "", $paragraphs[$key]));?></textarea>
                                </div>
                            </div>
                            <?php endforeach ?>
                        </div>
                        <div class="body-buttons">
                            <div id="add-another-field" class="add-more-button">Add Another Field</div>
                            <div id="remove-field" class="add-more-button remove-field">Remove Field</div>
                        </div>
                    </div>
                    <div class="input-field select-field">
                        <label for="category">Category</label>
                        <select name="category" id="category" required>
                            <option value="">Select a category</option>
                            <option <?php if($category == "html") echo 'selected';?> value="html">HTML5</option>
                            <option <?php if($category == "javascript") echo 'selected';?> value="javascript">JavaScript
                            </option>
                            <option <?php if($category == "php") echo 'selected';?> value="php">php</option>
                            <option <?php if($category == "python") echo 'selected';?> value="python">Python</option>
                            <option <?php if($category == "java") echo 'selected';?> value="java">Java</option>
                            <option <?php if($category == "react") echo 'selected';?> value="react">React</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="image">Image</label>
                        <input type="file" name="post-image" id="image">
                    </div>
                    <div class="submit-field">
                        <input type="hidden" name="post-id" value="<?php echo $id?>">
                        <input name="submit" type="submit" value="Update Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>