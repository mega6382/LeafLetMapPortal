<?php
 require_once("db.php");

 $id = intval($_POST['area']);
 $geo = strip_tags($_POST['geo']);
 $keywords = strip_tags($_POST['keywords']);

 $conn->updateArea( $id, $geo, $keywords);

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Area updated</title>
 </head>
 <body>
  <h1>Area has been updated</h1>
 </body>
</html>