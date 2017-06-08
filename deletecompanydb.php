<?php
 require_once("db.php");
 $id = intval($_POST['company']);
 $conn->deleteCompany($id);
?>
<!DOCTYPE html>
<html>
 <head>
  <title>Company deleted</title>
 </head>
 <body>
  <h1>Company has been deleted</h1>
 </body>
</html>