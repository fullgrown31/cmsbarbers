<?php
  if(!isset($_SESSION))
  {
    session_start();
    
  }
  session_unset();
  session_destroy();
  header("Location: index.php");
?>
<!DOCTYPE html>
<html>
  <title>The Gentleman's Cut</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="webstyle.css">
  <?php include('font.php') ?>
  <body>
  <?php include('header.php') ?>
  <div id = "maincontent">
    
    </div>
  </div>
  <?php include('footer.php'); ?>
</body>
</html>