$(document).ready(function () {
  // Aplicar brillo al hover (ya existente)
  $('.producto').hover(
    function () {
      $(this).find('img').css('filter', 'brightness(0.8)');
    },
    function () {
      $(this).find('img').css('filter', 'brightness(1)');
    }
  );
});



