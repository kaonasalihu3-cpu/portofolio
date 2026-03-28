(function () {
  var form = document.querySelector('form');
  var message = document.getElementById('message');
  if (!form || !message) return;

  form.addEventListener('submit', function (e) {
    if (message.value.trim().length < 10) {
      e.preventDefault();
      if (window.showFieldError) {
        window.showFieldError(message, 'Message must be at least 10 characters.');
      }
    }
  });
})();
