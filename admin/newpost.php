<?php

  /*
   *
   * this page is the page that we use to add new blog posts
   *
   * first we require the necessary files
   * like the database, session and the admin files, which check for the user being logged in and if they are an admin
   *
   */
  require '../config/database.php';
  require '../config/session.php';
  require 'admin.php';

  // check if a form has been submitted with the isset function and we check the $_POST submit key that is set in the form submit button.
  if ( isset( $_POST['submit'] ) ) {

    /*
     *
     * The way this form works is that it can be dynamic, we can add as many fields as we want to the form,
     *   so the names of the fields in the html markup are like 'subtitle[]' and 'paragraph[]', what this does is that the key
     *     subtitle (for example) will be turned into an array of all the subtitles of the added inputs, and the same for paragraphs
     *       so to store them in the database we join them into a single string and seperate the subtitles from the paragraphs
     *         with the special characterset (*%^sp^%*), and we do this for the subtitles too but we seperate them with the special characterset
     *           ^%seperator%^, as we do for the paragraphs.
     *
     * When we want to query the database and select all of those posts, we seperate the body with the special charactersets and then we can display
     *   them properly in the html markup we desire.
     *
     */

    // store the title and body of the post in the variables $subtitles and $paragraphs
    $subtitles = $_POST['subtitle'];
    $paragraphs = $_POST['paragraph'];

    // we loop through the $subtitles array and run a function that takes the breaks a user puts into the textarea
    //    and replaces them with a special string that we use to break the paragraphs (^%break%^)
    $paragraphs = array_map(
      function ( $item ) {

        // nl2br is a function that takes a string and replaces all the new lines with a break (<br />)
        $item = nl2br( $item );
        // we use the str_replace function to replace the break with a special string since we will use the htmlentities function later on
        //   to encode the special string
        return str_replace( "<br />", "^%break%^", $item );
      }, $paragraphs );

    /**
     *
     * $subtitles is now an array of all the subtitles of the added inputs,
     *   so we join them into a single string and seperate them with the special characterset
     *
     * $paragraphs is now an array of all the paragraphs of the added inputs,
     *   so we join them into a single string and seperate them with the special characterset
     *     and we trim the paragraphs out of leading and trailing spaces
     *
     */
    $subtitles = implode( '^%seperator%^', $subtitles );
    $paragraphs = trim( implode( '^%seperator%^', $paragraphs ) );

    /**
     *
     *
     * after we join them we sanitisize the inputs out of sql injections and htmlentities to make sure that the user cannot inject html or sql
     *
     *                                                      v this is where we join the subtitles and paragraphs together with the special characterset
     */
    $body = htmlentities( mysqli_real_escape_string( $conn, "$subtitles *%^sp^%* $paragraphs" ) );
    $title = htmlentities( mysqli_real_escape_string( $conn, $_POST['title'] ) );
    $category = htmlentities( mysqli_real_escape_string( $conn, $_POST['category'] ) );

    /*
     *
     * get the file uploaded from the form submission
     * $file_name is the name of the file
     * $file_tmp_name is the temporary name of the file that is uploaded
     * $file_ext is the extension of the file that we get after we use the explode function to seperate the file name with the dot
     *    and then we use the end function to get the last item in the array which is the extension and store it in $file_ext
     *
     */
    $file_name = $_FILES['post-image']['name'];
    $file_tmp = $_FILES['post-image']['tmp_name'];
    $file_ext = explode( '.', $file_name );
    $file_ext = strtolower( end( $file_ext ) );

    /*
     *
     * generate random id for the image to store in the database and access it with that id
     * we use the mt_rand function to generate a random number
     * we use the sha1 function to generate sha1 hash of the random number
     * we use the base64_encode function to encode the sha1 hash to a base64 string
     * we use the substr function to get the first 20 characters of the returned string and assign it to the $file_name variable
     *
     */
    $file_name = "post-img-" . substr( base64_encode( sha1( mt_rand() ) ), 0, 20 );

    // write the target directory where the image will be stored
    $target_dir = "../postImages/$file_name.$file_ext";

    // store the uploaded image in the target directory
    move_uploaded_file( $file_tmp, $target_dir );

    $sql = "INSERT INTO posts (title, body, category, post_image) VALUES ('$title', '$body', '$category', '$file_name.$file_ext')";
    // execute the query and if it throws an error, the value will be falsey, and we can then display the error
    if ( !mysqli_query( $conn, $sql ) ) {
      echo 'Error: ' . mysqli_error( $conn );
    }
    // if the query is successful then we redirect the user to the posts.php page
    header( 'Location: posts.php' );

  }
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
    <link rel="stylesheet" href="styles/newpost.css">
    <!-- font-awesome icons used in admin sidebar -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.css"
        integrity="sha512-1hsteeq9xTM5CX6NsXiJu3Y/g+tj+IIwtZMtTisemEv3hx+S9ngaW4nryrNcPM4xGzINcKbwUJtojslX2KG+DQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- get the script adminmain.js and use defer so that it loads after the dom has finished loading -->
    <script src="js/adminmain.js" defer></script>
    <!-- get the script newpost.js and use defer so that it loads after the dom has finished loading -->
    <script src="js/newpost.js" defer></script>
    <title>Admin Dashboard | New Post</title>
</head>

<body>
    <div class="main-wrapper">
        <!-- include the admin sidebar that is in the inc folder -->
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <h1 class="admin-title">New Post</h1>
            <div class="dashboard-box">
                <!-- html form with the action to this page that we get through the $_SERVER superglobal and the method POST -->
                <form class="new-post-form" action="<?=$_SERVER['PHP_SELF'] ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="input-field">
                        <label class="new-post-title" for="title">Title</label>
                        <input type="text" name="title" id="title" required>
                    </div>
                    <div class="body-of-post">
                        <h2 class="body-title">Body</h2>
                        <div id="body-fields-wrapper" class="body-fields-wrapper">
                            <!-- through javascript we inject new html markup to the div below for extra input fields -->
                            <div class="body-sub-title-paragraph">
                                <div class="input-field">
                                    <label for="title">Sub Title</label>
                                    <!-- this is the subtitle input with the name that turns the $_POST key into an array -->
                                    <input type="text" name="subtitle[]" id="title" required>
                                </div>
                                <div class="input-field">
                                    <label for="paragraph">Paragraph</label>
                                    <!-- this is the paragraph input with the name that turns the $_POST key into an array -->
                                    <textarea name="paragraph[]" id="paragraph" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="body-buttons"> <!-- buttons that we added, and we handle the clicks events with javascript -->
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
                            <option value="php">Php</option>
                            <option value="python">Python</option>
                            <option value="java">Java</option>
                            <option value="react">React</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="image">Image</label>
                        <input type="file" name="post-image" id="image" required> <!-- this input is required since we didn't make it possible to add a post without a photo -->
                        <p id="image-error-box">Please input a valid file! (.jpg, .jpeg, or .png files only)</p>
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