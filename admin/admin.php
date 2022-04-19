<?php

if ( !$user || $role != 'admin') {
  header( 'Location: ../index.php' );
  die();
}

?>