<?php
require_once("db.php");
$street = strip_tags( $_POST['street'] );
$geo = strip_tags( $_POST['geo'] );
$keywords = strip_tags( $_POST['keywords'] );

 $conn->addStreet( $street, $geo, $keywords);

?>
<!DOCTYPE html>
<html>
 <head>
  <title>Street added</title>
 </head>
 <body>
  <h1>Street has been added</h1>
 </body>
</html>