(function () {
  document.querySelectorAll('.alert').forEach(function (el) {
    setTimeout(function () {
      el.style.opacity = '0';
      el.style.transition = 'opacity .4s ease';
    }, 3500);
  });
})();
