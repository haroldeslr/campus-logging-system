function password_show_hide() {
  let x = document.getElementById("password");
  let show_eye = document.getElementById("password-show-eye");
  let hide_eye = document.getElementById("password-hide-eye");
  hide_eye.classList.remove("d-none");
  if (x.type === "password") {
    x.type = "text";
    show_eye.style.display = "none";
    hide_eye.style.display = "block";
  } else {
    x.type = "password";
    show_eye.style.display = "block";
    hide_eye.style.display = "none";
  }
}
