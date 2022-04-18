<?php
if ( !$user ) {
  header( 'Location: ../index.php' );
  die();
}

if ( $role != 'admin' ) {
  header( 'Location: ../index.php' );
  die();
}
?>