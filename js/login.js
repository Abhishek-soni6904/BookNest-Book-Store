// Tab switching functionality
const tabs = document.querySelectorAll(".tab");
const forms = document.querySelectorAll(".form");
const welcomeText = document.querySelector(".welcome-text");
const subtitle = document.querySelector(".subtitle");
const passwordField = document.getElementById("registerPassword");
const confirmPasswordField = document.getElementById("confirmPassword");
const submitBtn = document.getElementById("registerSubmit");
const matchMessage = document.getElementById("matchMessage");

tabs.forEach((tab) => {
  tab.addEventListener("click", () => {
    const targetForm = tab.dataset.tab;

    // Update active tab
    tabs.forEach((t) => t.classList.remove("active"));
    tab.classList.add("active");

    // Show corresponding form
    forms.forEach((form) => {
      form.classList.remove("active");
      if (form.id === `${targetForm}Form`) {
        form.classList.add("active");
      }
    });

    // Update welcome text
    if (targetForm === "login") {
      welcomeText.textContent = "Welcome back";
      subtitle.textContent = "Please enter your details to continue";
    } else {
      welcomeText.textContent = "Create account";
      subtitle.textContent = "Please fill in the information below";
    }
  });
});

function updatePasswordMessage(message, color) {
  matchMessage.textContent = message;
  matchMessage.style.color = color;
}

function validatePassword() {
  const password = passwordField.value.trim();
  const confirmPassword = confirmPasswordField.value.trim();
  submitBtn.disabled = true;

  if (!password) {
    updatePasswordMessage("Password cannot be empty.", "var(--success)");
    return;
  }

  if (password !== confirmPassword) {
    updatePasswordMessage("Passwords do not match.", "var(--danger)");
    return;
  }

  updatePasswordMessage("Passwords match.", "green");
  submitBtn.disabled = false;
}
passwordField.addEventListener("input", validatePassword);
confirmPasswordField.addEventListener("input", validatePassword);
