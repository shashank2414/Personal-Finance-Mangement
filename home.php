<?php
require('con_base/functions.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home</title>
     <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="responsive.css" />
  </head>
  <body>
     <?php
  // ========Session Msg===========
  if (isset($_SESSION['msg'])): ?>
    <div id="msgBox" class="<?php echo $_SESSION['msg_type']; ?>">
      <?php echo $_SESSION['msg'];
      unset($_SESSION['msg'], $_SESSION['msg_type']); ?>
    </div>
  <?php endif;
  ?>
    <marquee><h1 style="color: white;">Welcome to Personal <br> Finance Management</h1></marquee>




    <script src="app.js"></script>
  </body>
</html>
