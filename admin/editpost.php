<?php

  /**
   *
   * This script is used to edit the already existing posts.
   *  it uses the same html markup, same css, and same js logic as the script that adds posts.
   *
   * The differences are that this this script takes a post id sent with the $_GET method,
   *    it queries the database for the post with the id, and then displays the form with the
   *    data of the post already filled in. We display the form data by adding the value="..." property to the inputs.
   *  This is done in this way because the user can edit a single character and not have to rewrite the same content just to edit one character.
   *
   * Since the form is dynamic and can have less or more inputs from the user.
   * We query the database and also seperate the body column of the database by the special characters that we used in the script that adds posts.
   * Then we run a foreach loop to display all of the post data in the form no matter how much sub-articles the post has.
   *
   *
   *
   * This page also checks for permissions, if the user is not logged in, or if the user is not an admin,
   *   then the user is redirected to the index page.
   *
   * That logic is in the admin.php (admin.php uses the session variables that are stored in the session.php script to check for permissions)
   *    file that we require before any of the html is displayed.
   *
   */

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
    <!-- linking the styles, javascript that we used (defering it so it runs after the html is fully loaded), and also the font-awesome icons -->
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
        <!-- include the sidebar -->
        <?php include 'inc/nav.php' ?>
        <div class="main-content">
            <?php

                // Here we grab the $_POST method which is sent from this script after the form has been submitted. 
                // We check for the $_POST['submit'] because we have the name on the submit button 'submit'
              if ( isset( $_POST['submit'] ) ) {

                // Here we grab the post id that is in the input hidden field.
                $post_id = $_POST['post-id'];

                // Here we grab the sutitles and the body of the post.
                // and also run the same functions as the script that adds new posts. In order to save the data in the database in the same way that we add posts.
                
                $subtitles = $_POST['subtitle'];
                $paragraphs = $_POST['paragraph'];
                // we map through the array of paragraphs that are type textarea input
                $paragraphs = array_map(
                  function ( $item ) {
                    // we use the nl2br function to replace the new line characters with <br />
                    $item = nl2br( $item );
                    // then we return the item but also replacing the <br /> 
                    //    with the special characters that are used to add the <br /> to the html markup but not allow any other type of html elements.
                    return str_replace( "<br />", "^%break%^", $item );
                  }, $paragraphs ); // array map takes 2 parameters, the function that runs on every item, and the array that we want to map through.
                //   after that we use the implode function to join the array of paragraphs with the special character set in order to know how to seperate them when we display them in the html markup.
                $subtitles = implode( '^%seperator%^', $subtitles );
                $paragraphs = trim( implode( '^%seperator%^', $paragraphs ) ); // trim to remove leading and trailing whitespace.

                // we join the body in the same string, that we use to seperate,
                //    and we run them through the htmlentities function, and the mysqli_real_escape_string function, to defend against sql injection, or script injections.
                // we run the title and the category through the same functions to defend against sql injection, or script injections.
                $body = htmlentities( mysqli_real_escape_string( $conn, "$subtitles *%^sp^%* $paragraphs" ) );
                $title = htmlentities( mysqli_real_escape_string( $conn, $_POST['title'] ) );
                $category = htmlentities( mysqli_real_escape_string( $conn, $_POST['category'] ) );

                // we check the $_FILES superglobal for the 0 error, which means no file was uploaded, 
                //   in the edit post script, the file is optional, since we may want to not change the file
                //   and if it is, we save the file details to variables so that we can use them later to store in the database
                if ( $_FILES['post-image']['error'] == 0 ) {
                  // get the file uploaded from the form submission
                  // get the file details, like the name, extension, temp location and store them in variables.
                  $file_name = $_FILES['post-image']['name'];
                  $file_tmp = $_FILES['post-image']['tmp_name'];
                  $file_ext = explode( '.', $file_name ); // explode is a function to seperate a string into an array by a delimiter.
                  $file_ext = strtolower( end( $file_ext ) ); // we take only the end of the array, which is the extension of the file.

                  // generate id for the image, just like in the newpost.php script, to store in the database and access it with that id
                  $file_name = "post-img-" . substr( base64_encode( sha1( mt_rand() ) ), 0, 20 );
                  $target_dir = "../postImages/$file_name.$file_ext"; // the target directory, and the name of the file. the target directory is the postImages folder in the root directory.
                  move_uploaded_file( $file_tmp, $target_dir ); // move the file to that directory (save it).
                } else { // this else will run if the file was not uploaded, and we will change the sql query to not include the image column.
                  $file_name = NULL;
                }

                // we use the ternary operator to check if the file name is null, if it is, we will not include the image column in the sql query.
                $sql = $file_name ?
                "UPDATE posts SET title = '$title', body = '$body', category = '$category', post_image = '$file_name.$file_ext' WHERE id = $post_id" :
                "UPDATE posts SET title = '$title', body = '$body', category = '$category' WHERE id = $post_id";
                // this is done so if the file is changed we delete the old image from the postImages folder.
                if ( $file_name ) { 
                    // first we query the database for the image name.
                  $query = mysqli_query( $conn, "SELECT post_image FROM posts WHERE id = $post_id" );
                  $image = mysqli_fetch_assoc( $query );  // fetch the row
                  $image = $image['post_image']; // get the image name from the array
                  unlink( "../postImages/$image" ); // delete the image from the postImages folder
                }
                if ( !mysqli_query( $conn, $sql ) ) { // we execute the query and check if it is true or false. It will be false when it throws an error. If it does we echo it.
                  echo 'Error: ' . mysqli_error( $conn );
                }
                header( "Location: posts.php" ); // redirect the user to the posts page.

              }

              //  grab the post id from the $_GET method, query the database, and store the data in variables.
              if ( isset( $_GET['post'] ) ) {
                //   post id
                $id = $_GET['post'];
                // the query to get the post with that postid
                $sql = "SELECT * FROM posts WHERE id = $id";
                // execute the query
                $result = mysqli_query( $conn, $sql );
                // fetch the data in an associative array
                $post = mysqli_fetch_assoc( $result );

                // put the data that is returned from the query into variables for easier access
                $title = $post['title'];
                $category = $post['category'];
                $post_image = $post['post_image'];

                /**
                 *
                 * This is where we get the body column in the database, and split the subtitles from the paragraphs with the *%^sp^%* character set,
                 *   and then we split the paragraphs with the ^%seperator%^ character set.
                 *
                 * the first part of the body is the subtitles, and the second part is the paragraphs.
                 *
                 * the explode function takes a string and splits it into an array, using the character set as the delimiter. So, whenerver it finds that character,
                 *   it puts that element as a new element in the array.
                 *
                 * example below, takes the string and splits it into an array, using ',' as the delimiter.
                 * $string = "Hello, World, This, Is, A, Test";
                 * $array = explode( ",", $string );
                 *
                 * $array = [
                 *  "Hello",
                 *  "World",
                 *  "This",
                 *  "Is",
                 *  "A",
                 *  "Test"
                 * ]
                 *
                 *
                 * */
                $body = explode( "*%^sp^%*", $post['body'] );
                $subtitles = explode( '^%seperator%^', $body[0] );
                $paragraphs = explode( '^%seperator%^', $body[1] );
              }

            ?>
            <h1 class="admin-title">New Post</h1>
            <div class="dashboard-box">
                <!--  action="$_SERVER['PHP_SELF']" sends the form submission to this script -->
                <!-- the form has an attribute enctype="multipart/form-data", that allows us to send files through the form -->
                <form class="new-post-form" action="<?=$_SERVER['PHP_SELF'] ?>" method="post"
                    enctype="multipart/form-data">
                    <div class="input-field">
                        <label class="new-post-title" for="title">Title</label>
                        <!-- input of title we get the value of $title variable and echo it into the value attribute of the input 
                                so that we can see what was the title before and change something in it -->
                        <input type="text" name="title" id="title" required value="<?=$title; ?>">
                    </div>
                    <div class="body-of-post">
                        <h2 class="body-title">Body</h2>
                        <div id="body-fields-wrapper" class="body-fields-wrapper">
                            <!-- 
                                we run the foreach loop to loop through the subtitles array, and output as much needed html to the page so that every sub-article can be edited.
                                we do the foreach only on the subtitles but also echo the paragraphs in the same loop, so that the paragraphs can be edited as well.
                                a subtitle cannot exist without its paragraph sincle all form fields in the add post have the required attribute, so we are safe to assume that
                                the subtitles array will always be the same size as the paragraphs array. We access the paragraphs array with the $key variable, so that we can
                                access the paragraphs in the same order as the subtitles. the keys in the $subtitles array are numbers, so we can use them as the indices for the
                                paragraphs array. 
                            -->
                            <?php foreach ( $subtitles as $key => $subtitle ): ?> <!-- foreach($array as $arraykeyInThatIteration => $arrayValueInThatIteration) -->
                            <div class="body-sub-title-paragraph">
                                <div class="input-field">
                                    <label>Sub Title</label>
                                    <!-- 
                                        we output the value by getting the $subtitle variable since it is the value of the subtitle that we queried in the database earlier
                                            names of the inputs stay the same as the names on the newpost form, so that we can store the data in the same way as the newpost form 
                                    -->
                                    <input value="<?=$subtitle ?>" type="text" name="subtitle[]" id="title" required>
                                </div>
                                <div class="input-field">
                                    <label>Paragraph</label>
                                    <!--  we output the value by getting the $paragraphs array, 
                                            and using the $key variable to access the paragraphs array in the same order as the subtitles array 
                                            names of the inputs stay the same as the names on the newpost form, 
                                            so that we can store the data in the same way as the newpost form  
                                            we also trim the value to remove leading and trailing whitespace, 
                                            also we use str_replace to replace the ^%break%^ character set with an empty string, so that it doesn't show in the
                                            textarea.
                                    -->
                                    <textarea name="paragraph[]"
                                        required><?=trim( str_replace( "^%break%^", "", $paragraphs[$key] ) ); ?></textarea>
                                </div>
                            </div>
                            <?php endforeach ?> <!-- end the form sub-articles inputs foreach loop here -->
                        </div>
                        <div class="body-buttons"> <!-- these are the buttons, we added id's to them since we use javascript to handle the click events -->
                            <div id="add-another-field" class="add-more-button">Add Another Field</div>
                            <div id="remove-field" class="add-more-button remove-field">Remove Field</div>
                        </div>
                    </div>
                    <div class="input-field select-field">
                        <label for="category">Category</label>
                        <select name="category" id="category" required>
                            <!-- 
                                since we have a select field, we get the value in the database and we have it stored in the $category variable,
                                we use the ternary operator to check if the $category variable matches a value,
                                if that value matches we can echo the 'selected' attribute to the option, so that it is selected by default. 

                                condition ? "if true" : "if false"
                                the if false part in our case is always null since we do not want to echo anything if the condition is false.
                            -->
                            <option value="">Select a category</option>
                            <option <?=$category == "html" ? 'selected' : NULL ?> value="html">HTML5</option>
                            <option <?=$category == "javascript" ? 'selected' : NULL ?> value="javascript">JavaScript</option>
                            <option <?=$category == "php" ? 'selected' : NULL ?> value="php">php</option>
                            <option <?=$category == "python" ? 'selected' : NULL ?> value="python">Python</option>
                            <option <?=$category == "java" ? 'selected' : NULL ?> value="java">Java</option>
                            <option <?=$category == "react" ? 'selected' : NULL ?> value="react">React</option>
                        </select>
                    </div>
                    <div class="input-field">
                        <label for="image">Image</label>
                        <input type="file" name="post-image" id="image">
                        <p id="image-error-box">Please input a valid file! (.jpg, .jpeg, or .png files only)</p>
                    </div>
                    <div class="submit-field">
                        <!-- we use a hidden input with the value that we get through the $_GET superglobal array, in order to send the 
                                form data with the post method, and also keep track of which post to edit in the database.        
                        -->
                        <input type="hidden" name="post-id" value="<?=$id ?>">
                        <input name="submit" type="submit" value="Update Post">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>