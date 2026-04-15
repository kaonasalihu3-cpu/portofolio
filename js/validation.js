(function () {
  function getErrorBox(field) {
    if (!field || !field.parentElement) return null;
    return field.parentElement.querySelector('.error-text');
  }

  function showError(field, message) {
    var box = getErrorBox(field);
    if (box) box.textContent = message || '';
    if (field) field.classList.add('input-error');
  }

  function clearError(field) {
    var box = getErrorBox(field);
    if (box) box.textContent = '';
    if (field) field.classList.remove('input-error');
  }

  function resetFormErrors(form) {
    if (!form) return;
    form.querySelectorAll('.error-text').forEach(function (el) {
      el.textContent = '';
    });
    form.querySelectorAll('.input-error').forEach(function (el) {
      el.classList.remove('input-error');
    });
  }

  var forms = document.querySelectorAll('form[novalidate]');
  forms.forEach(function (form) {
    form.addEventListener('submit', function () {
      resetFormErrors(form);
    });
  });

  window.formValidation = {
    showError: showError,
    clearError: clearError,
    resetFormErrors: resetFormErrors
  };
})();
