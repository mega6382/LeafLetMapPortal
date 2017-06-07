<?php
  require_once("db.php");
  $keyword = strip_tags( $_GET['keyword'] );
  $jsonData = connectToDB::getSearchResults( $keyword );
  print $jsonData;
?>