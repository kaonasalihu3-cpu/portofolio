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

  function validateRequiredField(form, name, message) {
    var field = form.querySelector('[name="' + name + '"]');
    if (!field) return false;
    if (String(field.value || '').trim() === '') {
      showError(field, message);
      return true;
    }
    return false;
  }

  function bindAdminValidation(formId, rules) {
    var form = document.getElementById(formId);
    if (!form) return;
    form.addEventListener('submit', function (e) {
      var hasError = false;
      rules.forEach(function (rule) {
        hasError = validateRequiredField(form, rule.name, rule.message) || hasError;
      });
      if (hasError) e.preventDefault();
    });
  }

  bindAdminValidation('admin-product-create-form', [
    { name: 'title', message: 'Title is required.' },
    { name: 'short_description', message: 'Short description is required.' },
    { name: 'body', message: 'Body is required.' }
  ]);
  bindAdminValidation('admin-product-edit-form', [
    { name: 'title', message: 'Title is required.' },
    { name: 'short_description', message: 'Short description is required.' },
    { name: 'body', message: 'Body is required.' }
  ]);
  bindAdminValidation('admin-news-create-form', [
    { name: 'title', message: 'Title is required.' },
    { name: 'body', message: 'Body is required.' }
  ]);
  bindAdminValidation('admin-news-edit-form', [
    { name: 'title', message: 'Title is required.' },
    { name: 'body', message: 'Body is required.' }
  ]);
  bindAdminValidation('admin-content-edit-form', [
    { name: 'page_key', message: 'Page key is required.' },
    { name: 'section_key', message: 'Section key is required.' },
    { name: 'title', message: 'Title is required.' },
    { name: 'body', message: 'Body is required.' }
  ]);

  window.formValidation = {
    showError: showError,
    clearError: clearError,
    resetFormErrors: resetFormErrors
  };
})();
