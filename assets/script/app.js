// Display session pop-up message for 2 seconds
window.onload = function () {
  const msgBox = document.getElementById("msgBox");
  if (msgBox) {
    setTimeout(() => {
      msgBox.style.display = "none";
    }, 10000);
  }
};

const sign_in_btn = document.querySelector("#sign-in-btn");
const sign_up_btn = document.querySelector("#sign-up-btn");
const container = document.querySelector(".container");
const sign_in_btn2 = document.querySelector("#sign-in-btn2");
const sign_up_btn2 = document.querySelector("#sign-up-btn2");

sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode");
});
sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode");
});
sign_up_btn2.addEventListener("click", () => {
  container.classList.add("sign-up-mode2");
});
sign_in_btn2.addEventListener("click", () => {
  container.classList.remove("sign-up-mode2");
});

// ==========Auth page Js==================

/* ===========hidden forgot password script=================== */

const forgotLink = document.querySelector('a[href="forgot_pass.php"]');
const popup = document.getElementById("forgot-popup");
const closePopup = document.getElementById("close-popup");
const sendOtpButton = document.getElementById("otp-verify");

// Show pop-up when "Forgot Password" is clicked
forgotLink.addEventListener("click", (e) => {
  e.preventDefault();
  popup.style.display = "flex";
});

// Hide pop-up when "Close" button is clicked
closePopup.addEventListener("click", () => {
  popup.style.display = "none";
});

// Hide pop-up with transition after "Send OTP" is clicked
sendOtpButton.addEventListener("click", () => {
  popup.style.opacity = "0";
  setTimeout(() => {
    popup.style.display = "none";
    popup.style.opacity = "1";
  }, 300); // Match the CSS transition duration
});
