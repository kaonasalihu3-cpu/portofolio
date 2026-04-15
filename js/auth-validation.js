(function () {
  function validEmail(value) {
    return /\S+@\S+\.\S+/.test(value);
  }

  var register = document.getElementById('register-form');
  if (register) {
    register.addEventListener('submit', function (e) {
      var util = window.formValidation;
      if (!util) return;

      var fullName = document.getElementById('full_name');
      var email = document.getElementById('email');
      var password = document.getElementById('password');
      var confirm = document.getElementById('confirm_password');
      var hasError = false;

      if (fullName && fullName.value.trim().length < 3) {
        util.showError(fullName, 'Full name must be at least 3 characters.');
        hasError = true;
      }
      if (email && !validEmail(email.value.trim())) {
        util.showError(email, 'Enter a valid email address.');
        hasError = true;
      }
      if (password && password.value.length < 8) {
        util.showError(password, 'Password must be at least 8 characters.');
        hasError = true;
      }
      if (confirm && password && confirm.value !== password.value) {
        util.showError(confirm, 'Passwords do not match.');
        hasError = true;
      }

      if (hasError) e.preventDefault();
    });
  }

  var login = document.getElementById('login-form');
  if (login) {
    login.addEventListener('submit', function (e) {
      var util = window.formValidation;
      if (!util) return;

      var email = document.getElementById('email');
      var password = document.getElementById('password');
      var hasError = false;

      if (email && !validEmail(email.value.trim())) {
        util.showError(email, 'Enter a valid email address.');
        hasError = true;
      }
      if (password && password.value.trim() === '') {
        util.showError(password, 'Password is required.');
        hasError = true;
      }

      if (hasError) e.preventDefault();
    });
  }
})();
