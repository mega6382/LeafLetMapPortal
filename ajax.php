<?php
  require_once("db.php");
  $keyword = strip_tags( $_GET['keyword'] );
  $jsonData = $conn->getSearchResults( $keyword );
  print $jsonData;
?>