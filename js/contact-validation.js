(function () {
  function validEmail(value) {
    return /\S+@\S+\.\S+/.test(value);
  }

  var form = document.getElementById('contact-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    var util = window.formValidation;
    if (!util) return;

    var name = document.getElementById('name');
    var email = document.getElementById('email');
    var subject = document.getElementById('subject');
    var message = document.getElementById('message');
    var hasError = false;

    if (name && name.value.trim() === '') {
      util.showError(name, 'Name is required.');
      hasError = true;
    }
    if (email && !validEmail(email.value.trim())) {
      util.showError(email, 'Enter a valid email address.');
      hasError = true;
    }
    if (subject && subject.value.trim() === '') {
      util.showError(subject, 'Subject is required.');
      hasError = true;
    }
    if (message && message.value.trim().length < 10) {
      util.showError(message, 'Message must be at least 10 characters.');
      hasError = true;
    }

    if (hasError) e.preventDefault();
  });
})();
