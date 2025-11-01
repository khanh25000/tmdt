document.addEventListener("DOMContentLoaded", function () {
  const forms = document.querySelectorAll("form");
  forms.forEach((form) => {
    form.addEventListener("submit", function (e) {
      const password = form.querySelector("#password");
      const confirmPassword = form.querySelector("#confirm_password");

      if (password && confirmPassword) {
        if (password.value !== confirmPassword.value) {
          e.preventDefault();
          alert("Mật khẩu và xác nhận mật khẩu không khớp!");
        }
      }
    });

    // Add animation for input focus
    const inputs = form.querySelectorAll("input");
    inputs.forEach((input) => {
      input.addEventListener("focus", function () {
        this.parentElement.classList.add("input-focused");
      });
      input.addEventListener("blur", function () {
        this.parentElement.classList.remove("input-focused");
      });
    });
  });
});
