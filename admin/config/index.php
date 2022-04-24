<?php 

/**
 * 
 * this script is used to not allow any user to see the file directories if they navigate to
 *   admin/config in the url of the browser, it will redirect the user to this index page
 * 
 */

header( 'Location: ../index.php' );

?>