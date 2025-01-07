<?php
require('../con_base/functions.inc.php');
$phone = $_GET['mobile'];
$via = "";

if(isset($_GET['via'])){
  $via = $_GET['via'];
}
 

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

        if($via == "")
        {
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
            if($stmt->execute()){

                $sql1 = "Select pass from tab_login where mobile=:mobile";
                $stmt1 = $PDO_LINK->prepare($sql1);
                $stmt1->bindParam(":mobile", $phone, PDO::PARAM_STR);
                $stmt1->execute();
                $result = $stmt1->fetch(PDO::FETCH_ASSOC);
                $pass = dec($result['pass']);
             
                $msg = "Hi Sir/mam\n\n*Congrats 💐💐,\n Welcome to Personal Finance Management!! Take control of your finances today for a brighter tomorrow.*\n\n Grab your ID and Password 👇\n\n ID : *" . $phone . "*\n Password : *" . $pass . "*\n\nThanks\nRegards PFM";
                sentwp_sms($phone, $msg);
            
            } 
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
        }else{
          try {
             $new_pass = chr(rand(ord('A'), ord('Z'))) . chr(rand(ord('a'), ord('z'))) . chr(rand(ord('a'), ord('z'))) . rand(000, 999);

             $sql1 = "UPDATE tab_login SET pass=:pass where mobile=:phone";
              $stmt1 = $PDO_LINK->prepare($sql1);
              $stmt1->bindParam(':pass', enc($new_pass), PDO::PARAM_STR);
              $stmt1->bindParam(':phone', $phone);
              if ($stmt0->execute()){
                $msg = "Hi Sir/mam\n\n\n*Congrats, Your ID and new Password is generated.\n\n ID : " . $phone . ".\n\n Password : " . $new_pass . ".*\n\nThanks. \n\n*Regards PFM*";
                sentwp_sms($phone, $msg);
              }            
         
            $_SESSION['msg'] = "Your UserID and Password has been sent to your mobile";
            $_SESSION['msg_type'] = "success";
            header("location: home.php");
            exit;
           
        } catch (PDOException $e) {
          $_SESSION['msg'] = "Error: " . $e->getMessage();
          $_SESSION['msg_type'] = "error";
        }
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

<script>
  document.addEventListener("DOMContentLoaded", () => {
  const inputs = document.querySelectorAll(".otp-input input");

  inputs.forEach((input, index) => {
    input.addEventListener("input", (e) => {
      if (e.target.value.length === 1 && index < inputs.length - 1) {
        inputs[index + 1].focus();
      }
    });
    input.addEventListener("keydown", (e) => {
      if (e.key === "Backspace" && e.target.value === "" && index > 0) {
        inputs[index - 1].focus();
      }
    });
  });
});
</script>

  <script src="../assets/script/app.js"></script>


</body>

</html>