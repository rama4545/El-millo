document.addEventListener('DOMContentLoaded', function () {
  const formBuscar = document.getElementById('form-buscar');
  if (formBuscar) {
    formBuscar.addEventListener('submit', function (e) {
      e.preventDefault();
      const q = document.getElementById('input-buscar').value.trim();
      if (q !== '') {
        window.location.href = '../buscar.php?q=' + encodeURIComponent(q);
      }
    });
  }
});
