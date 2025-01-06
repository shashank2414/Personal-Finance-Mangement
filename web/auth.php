<?php
require('../con_base/functions.inc.php');
$phone = $_GET['mobile'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $sql_otp_verification = "SELECT * FROM tab_login where user=$phone";
  $stmt_otp_verification = $PDO_LINK->prepare($sql_otp_verification);
  $stmt_otp_verification->execute();
  $result = $stmt_otp_verification->fetch(PDO::FETCH_ASSOC);


  if (isset($_POST['otp-submit'])) {
    $entered_otp = sanitizeInput($_POST['otp_digit_1']) . sanitizeInput($_POST['otp_digit_2']) . sanitizeInput($_POST['otp_digit_3']) . sanitizeInput($_POST['otp_digit_4']) . sanitizeInput($_POST['otp_digit_5']) . sanitizeInput($_POST['otp_digit_6']);

    if (strlen($entered_otp) == 6) {
      if ($entered_otp === $result['otp']) {

        $status = 1;

        try {

          $sql0 = "UPDATE tab_user SET status=:status where mobile=:phone";
          $stmt0 = $PDO_LINK->prepare($sql0);
          $stmt0->bindParam(':status', $status, PDO::PARAM_STR);
          $stmt0->bindParam(':phone', $phone);

          if ($stmt0->execute()) {

            $sql = "UPDATE tab_login SET status=:status where user=:phone";
            $stmt = $PDO_LINK->prepare($sql);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':phone', $phone);
            $stmt->execute();
            $_SESSION['msg'] = "Your UserID and Password has been sent to your mobile";
            $_SESSION['msg_type'] = "success";
            header("location: home.php");
            exit;
          } else {
            $_SESSION['msg'] = "Error: " . $e->getMessage();
            $_SESSION['msg_type'] = "error";
          }
        } catch (PDOException $e) {
          $_SESSION['msg'] = "Error: " . $e->getMessage();
          $_SESSION['msg_type'] = "error";
        }
      } else {
        $_SESSION['msg'] = "Invalid OTP";
        $_SESSION['msg_type'] = "error";
      }
    } else {
      $_SESSION['msg'] = "Fill all the boxes";
      $_SESSION['msg_type'] = "error";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PFM | Authentication</title>

  <?php require("include/header_link.php"); ?>

</head>

<body>

  <!-- ========Session Msg Display============= -->

  <?php require("include/session_msg.php"); ?>


  <form action="" method="post">
    <div class="otp-container">
      <h1>OTP Verification</h1>
      <p>Please enter the 6-digit OTP sent to your mobile number.</p>
      <div class="otp-input">
        <input type="text" maxlength="1" name="otp_digit_1" autofocus>
        <input type="text" maxlength="1" name="otp_digit_2">
        <input type="text" maxlength="1" name="otp_digit_3">
        <input type="text" maxlength="1" name="otp_digit_4">
        <input type="text" maxlength="1" name="otp_digit_5">
        <input type="text" maxlength="1" name="otp_digit_6">
      </div>
      <button id="otp-verify" type="submit" name="otp-submit" class="btn">Verify OTP</button>
    </div>
  </form>



  <script src="assets/script/app.js"></script>


</body>

</html>