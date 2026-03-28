(function () {
  var register = document.querySelector('form[action=""], form');
  if (!register || !document.getElementById('confirm_password')) return;

  register.addEventListener('submit', function (e) {
    var password = document.getElementById('password');
    var confirm = document.getElementById('confirm_password');
    if (!password || !confirm) return;
    if (password.value !== confirm.value) {
      e.preventDefault();
      if (window.showFieldError) {
        window.showFieldError(confirm, 'Passwords do not match.');
      }
    }
  });
})();
