<?php 
 if(isset($_POST['otp-submit'])){
    header('Location: index.php');
    exit;
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
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="style.css" />
    <link rel="stylesheet" href="responsive.css" />

    <title>PFM | Forgot Password</title>
    
  </head>
  <body>
    
  
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
        document.addEventListener('DOMContentLoaded', () => {
    const inputs = document.querySelectorAll('.otp-input input');

    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            if (e.target.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
               }
           });
           input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        inputs[index - 1].focus();
                    }
                });
       });
   });
      
     
    </script>
  </body>
</html>
