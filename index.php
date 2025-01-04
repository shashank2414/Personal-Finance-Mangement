<?php

global $PDO_LINK;
require('con_base/functions.inc.php');

// ========For Sign Up==========
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (isset($_POST['signup-submit'])) {

    $username = sanitizeInput($_POST['username']);
    $phone = sanitizeInput($_POST['phone']);
    $pass = enc(sanitizeInput($_POST['password']));
    $otp = rand(100000, 999999);

    

    // $msg = "Hi Sir/mam\n\n\n*Your mobile verification otp is : " . $otp . ".*\n\nKindly verify your mobile number.\n\nThanks. \n\n*Regards PFM*";
    // echo  sentwp_sms($phone, $msg);

    if(strlen($phone) === 10 ){
      try {

        /////Find Dupilicate with status 0///
          $sql_dup = "SELECT * FROM tab_user WHERE mobile = :mobile";
          $stmt_dup = $PDO_LINK->prepare($sql_dup);
          $stmt_dup->bindParam(':mobile', $phone, PDO::PARAM_STR);
          $stmt_dup->execute();

          // Get the number of rows returned
           
          if($stmt_dup->rowCount()>0)
          {
          $sql_dup = "delete FROM tab_user WHERE mobile = :mobile";
          $stmt_dup = $PDO_LINK->prepare($sql_dup);
          $stmt_dup->bindParam(':mobile', $phone, PDO::PARAM_STR);
          $stmt_dup->execute();

          $sql_dup = "delete FROM tab_login WHERE user = :mobile";
          $stmt_dup = $PDO_LINK->prepare($sql_dup);
          $stmt_dup->bindParam(':mobile', $phone, PDO::PARAM_STR);
          $stmt_dup->execute();
          }

         /////Find Dupilicate with status 0///

           

      $sql1 = "INSERT INTO tab_user (name, mobile) VALUES (:name, :mobile)";
      $stmt1 = $PDO_LINK->prepare($sql1);
      $stmt1->bindParam(':name', $username, PDO::PARAM_STR);
      $stmt1->bindParam(':mobile', $phone, PDO::PARAM_STR);
      if ($stmt1->execute()) {

        $sql = "INSERT INTO tab_login (user, username, mobile, pass,otp) VALUES (:user,:username, :phone, :pass,:otp)";
        $stmt = $PDO_LINK->prepare($sql);
        $stmt->bindParam(':user', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':otp', $otp, PDO::PARAM_STR);

        if ($stmt->execute()) {
          $_SESSION['msg'] = "Otp sent to your mobile";
          $_SESSION['msg_type'] = "success";
          // $msg = "Hi Sir/mam\n\n\n*Your mobile verification otp is : " . $otp . ".*\n\nKindly verify your mobile number.\n\nThanks. \n\n*Regards PFM*";
          // sentwp_sms($phone, $msg);
          header("Location: auth.php?mobile=$phone");
          exit;
        } else {
          $_SESSION['msg'] = "Failed to submit data.";
          $_SESSION['msg_type'] = "error";
        }
      } else {
        $_SESSION['msg'] = "Failed to submit data.";
        $_SESSION['msg_type'] = "error";
      }
    } catch (PDOException $e) {
      $_SESSION['msg'] = "Error: " . $e->getMessage();
      $_SESSION['msg_type'] = "error";
    }
    }else{
       $_SESSION['msg'] = "Enter 10 digit mobile number";
      $_SESSION['msg_type'] = "error";
    }

    
  }


  // ========For Sign In==========
  if (isset($_POST['signin-submit'])) {

    $mobile = $_POST['mobile'];
    $pass = $_POST['valueOfKey'];

    $sql_signin = "SELECT * FROM tab_login where user=$mobile and status=1 ";
    $stmt_signin = $PDO_LINK->prepare($sql_signin);
    

    if($stmt_signin->execute()){
      $result = $stmt_signin->fetch(PDO::FETCH_ASSOC);
      if($result){
        $main_mobile = $result['mobile'];
        $main_pass = dec($result['pass']);

        if($mobile === $main_mobile && $pass === $main_pass){

          $_SESSION['msg'] = "Signed In 😊";
          $_SESSION['msg_type'] = "success";

           header("location: home.php");
           exit;
        }else{
         $_SESSION['msg'] = "Mobile or password is wrong";
          $_SESSION['msg_type'] = "error";

        }
      }else{
        $_SESSION['msg'] = "Invalid Credential";
          $_SESSION['msg_type'] = "error";
      }
    }else{
       $_SESSION['msg'] = "Some error occured, try again later";
          $_SESSION['msg_type'] = "error";

    }

    // header("location: auth.php");
    // exit();
  }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link
    rel="stylesheet"
    href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p"
    crossorigin="anonymous" />
  <link rel="stylesheet" href="style.css" />
  <link rel="stylesheet" href="responsive.css" />
  <title>PFM | Sign Up</title>
  <style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
      -webkit-appearance: none;
      margin: 0;
    }

    input[type="number"] {
      -moz-appearance: textfield;
    }
  </style>
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


  <div class="container">
    <div class="signin-signup">
      <!-- ========= First Interface Sign in========== -->
      <form action="" method="post" class="sign-in-form" autocomplete="off">
        <h2 class="title">Sign in</h2>
        <div class="input-field">
          <i class="fas fa-user"></i>
          <input type="number" name="mobile" autocomplete="false" placeholder="Mobile" required />
        </div>
        <div class="input-field">
          <i class="fas fa-lock"></i>
          <!-- <input type="password" placeholder="Password" /> -->
          <input type="password" name="valueOfKey" autocomplete="new-password" placeholder="Password" required />
        </div>
        <small><a href="">Forgot Password ?</a></small>

        <button type="submit" name="signin-submit" class="btn">Login</button>

        <p class="account-text">
          Don't have an account?
          <a href="#" id="sign-up-btn2">Sign up</a>
        </p>
      </form>

      <!-- ========= Second Interface Sign up========== -->
      <form action="" method="post" class="sign-up-form">
        <h2 class="title">Sign up</h2>
        <div class="input-field">
          <i class="fas fa-user"></i>
          <!-- <input type="text" placeholder="Username" /> -->
          <input type="text" name='username' placeholder="Full Name" required />
        </div>
        <div class="input-field">
          <i class="fas fa-phone"></i>
          <!-- <input type="number" placeholder="Whatsapp Number" /> -->
          <input type="number" name="phone" placeholder="Whatsapp Number" required />
        </div>
        <div class="input-field">
          <i class="fas fa-lock"></i>
          <!-- <input type="password" placeholder="Password" /> -->
          <input type="text" name="password" placeholder="Password" required />
        </div>
        <input type="hidden" value="" name="otp" />
        <button class="btn" type="submit" name="signup-submit">Sign up</button>

        <p class="account-text">
          Already have an account? <a href="#" id="sign-in-btn2">Sign in</a>
        </p>
      </form>
    </div>

    <!-- ========= First and Second Interface Signup-Sign-in buttons========== -->
    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <img
            src="dev.png"
            style="
                width: 47%;
                height: auto;
                background: #ffffff;
                padding: 1rem;
                border-radius: 50%;
              "
            alt="" />
          <h1>
            Welcome to Personal <br /> Finance Management
          </h1>

          <button class="btn" id="sign-in-btn">Sign in</button>
        </div>

      </div>
      <div class="panel right-panel">
        <div class="content">
          <img
            src="dev.png"
            style="
                width: 47%;
                height: auto;
                background: #ffffff;
                padding: 1rem;
                border-radius: 50%;
              "
            alt="" />
          <h1>
            Welcome to Personal <br />
            Finance Management
          </h1>
          <!-- <p style="margin-bottom: 10px">
              Take control of your finances, one smart decision at a time.
            </p> -->

          <button class="btn" id="sign-up-btn">Sign up</button>
        </div>

      </div>
    </div>
  </div>

  <script src="app.js"></script>
</body>

</html>