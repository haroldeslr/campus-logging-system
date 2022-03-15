function current_password_show_hide() {
  let x = document.getElementById("current-password");
  let show_eye = document.getElementById("current-password-show-eye");
  let hide_eye = document.getElementById("current-password-hide-eye");
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

function new_password_show_hide() {
  let x = document.getElementById("new-password");
  let show_eye = document.getElementById("new-password-show-eye");
  let hide_eye = document.getElementById("new-password-hide-eye");
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

function confirm_new_password_show_hide() {
  let x = document.getElementById("confirm-new-password");
  let show_eye = document.getElementById("confirm-new-password-show-eye");
  let hide_eye = document.getElementById("confirm-new-password-hide-eye");
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
