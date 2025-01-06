<?php
  // ========Session Msg===========
  if (isset($_SESSION['msg'])): ?>
    <div id="msgBox" class="<?php echo $_SESSION['msg_type']; ?>">
      <?php echo $_SESSION['msg'];
      unset($_SESSION['msg'], $_SESSION['msg_type']); ?>
    </div>
  <?php endif;
  ?>