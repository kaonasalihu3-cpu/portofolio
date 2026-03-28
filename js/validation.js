(function () {
  function showError(field, message) {
    var box = field.parentElement.querySelector('.error-text');
    if (box) box.textContent = message;
  }

  var forms = document.querySelectorAll('form[novalidate]');
  forms.forEach(function (form) {
    form.addEventListener('submit', function () {
      form.querySelectorAll('.error-text').forEach(function (el) {
        el.textContent = '';
      });
    });
  });

  window.showFieldError = showError;
})();
