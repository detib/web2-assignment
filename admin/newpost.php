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
    <title>Admin Dashboard - New Post</title>
</head>

<body>
    <div class="main-wrapper">
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <?php
              $allowedExtensions = ['jpg', 'jpeg', 'png'];
              $invalidFile = false;

              if ( isset( $_POST['submit'] ) ) {
                // print_r($_POST);

                $subtitles = $_POST['subtitle'];
                $paragraphs = $_POST['paragraph'];
                $subtitles = implode( ',', $subtitles );
                $paragraphs = implode( ',', $paragraphs );

                $body = htmlentities( mysqli_real_escape_string( $conn, "$subtitles ** $paragraphs" ) );
                $title = htmlentities( mysqli_real_escape_string( $conn, $_POST['title'] ) );
                $category = htmlentities( mysqli_real_escape_string( $conn, $_POST['category'] ) );

                // echo $body;
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
                    "INSERT INTO posts (title, body, category, post_image) VALUES ('$title', '$body', '$category', '$file_name.$file_ext')" : 
                    "INSERT INTO posts (title, body, category) VALUES ('$title', '$body', '$category')";
                  if ( !mysqli_query( $conn, $sql ) ) {
                    echo 'Error: ' . mysqli_error( $conn );
                  }
                }

                $d = explode( "**", $body );
                $s = explode( ",", $d[0] );
                $p = explode( ",", $d[1] );
              }

            ?>
            <h1 class="admin-title">New Post</h1>
            <div class="dashboard-box">
                <form class="new-post-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="input-field">
                        <label class="new-post-title" for="title">Title</label>
                        <input type="text" name="title" id="title" required>
                    </div>
                    <div class="body-of-post">
                        <h2 class="body-title">Body</h2>
                        <div id="body-fields-wrapper" class="body-fields-wrapper">
                            <div class="body-sub-title-paragraph">
                                <div class="input-field">
                                    <label for="title">Sub Title</label>
                                    <input type="text" name="subtitle[]" id="title" required>
                                </div>
                                <div class="input-field">
                                    <label for="paragraph">Paragraph</label>
                                    <textarea name="paragraph[]" id="paragraph" required></textarea>
                                </div>
                            </div>
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
                            <option value="html">HTML5</option>
                            <option value="javascript">JavaScript</option>
                            <option value="php">php</option>
                            <option value="python">Python</option>
                            <option value="java">Java</option>
                            <option value="react">React</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="image">Image</label>
                        <input type="file" name="post-image" id="image">
                    </div>
                    <div class="submit-field">
                        <input name="submit" type="submit" value="Create Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>