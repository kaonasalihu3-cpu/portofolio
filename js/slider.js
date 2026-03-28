(function () {
  var slides = document.querySelectorAll('[data-slide]');
  if (!slides.length) return;

  var index = 0;
  setInterval(function () {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
  }, 4000);
})();
