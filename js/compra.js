document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const mensajeError = document.getElementById("mensaje-error");

  document.querySelectorAll("select").forEach(select => {
    select.addEventListener("focus", () => {
      setTimeout(() => {
        select.scrollIntoView({ behavior: "smooth", block: "center" });
      }, 100);
    });
  });

  document.getElementById("tipo-tarjeta").addEventListener("change", toggleCuotas);

  
  form.addEventListener("submit", function (e) {
    let error = "";

    const nombre = document.querySelector('input[name="nombre"]').value.trim();
    const email = document.querySelector('input[name="email"]').value.trim();
    const direccion = document.querySelector('input[name="direccion"]').value.trim();
    const localidad = document.querySelector('input[name="localidad"]').value.trim();
    const provincia = document.querySelector('select[name="provincia"]').value;
    const dni = document.querySelector('input[name="dni"]').value.replace(/\D/g, '');
    const telefono = document.querySelector('input[name="telefono"]').value.replace(/\D/g, '');

    const tarjetaNumero = document.querySelector('input[name="tarjeta_numero"]').value.replace(/\D/g, '');
    const tarjetaNombre = document.querySelector('input[name="tarjeta_nombre"]').value.trim();
    const tarjeta = document.querySelector('select[name="tarjeta"]').value;
    const tipoPago = document.querySelector('select[name="tipo_pago"]').value;
    const cuotas = document.querySelector('select[name="cuotas"]').value;

    const mes = parseInt(document.querySelector('select[name="mes"]').value);
    const anio = parseInt(document.querySelector('select[name="anio"]').value);
    const cvv = document.querySelector('input[name="tarjeta_cvv"]').value.trim();

    if (!nombre || !email || !direccion || !localidad || !provincia || !dni || !telefono ||
        !tarjetaNumero || !tarjetaNombre || !tarjeta || !tipoPago || !cuotas || !mes || !anio || !cvv) {
      error = "Por favor, completá todos los campos.";
    }

    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!regexEmail.test(email)) {
      error = "El correo electrónico no es válido.";
    }

    if (!/^\d{13,19}$/.test(tarjetaNumero)) {
      error = "El número de tarjeta no es válido.";
    }

    if (tarjeta === "Visa" && !tarjetaNumero.startsWith("4")) {
      error = "Número de tarjeta Visa incorrecto.";
    } else if (tarjeta === "Mastercard") {
      const primeros = parseInt(tarjetaNumero.slice(0, 4));
      const primeros2 = parseInt(tarjetaNumero.slice(0, 2));
      if (!((primeros >= 2221 && primeros <= 2720) || (primeros2 >= 51 && primeros2 <= 55))) {
        error = "Número de tarjeta Mastercard incorrecto.";
      }
    }

    const hoy = new Date();
    const fechaVencimiento = new Date(anio, mes - 1, 1);
    const actual = new Date(hoy.getFullYear(), hoy.getMonth(), 1);
    if (fechaVencimiento < actual) {
      error = "La tarjeta está vencida.";
    }

    if (!/^\d{3}$/.test(cvv)) {
      error = "El código de seguridad (CVV) no es válido.";
    }

    if (error) {
      e.preventDefault();
      mensajeError.textContent = error;
      mensajeError.style.display = "block";
      mensajeError.classList.add("visible");
      mensajeError.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
      mensajeError.style.display = "none";
    }
  });
});

function formatearTarjeta(input) {
  let valor = input.value.replace(/\D/g, '').substring(0, 16);
  valor = valor.replace(/(.{4})/g, '$1-').trim();
  if (valor.endsWith("-")) valor = valor.slice(0, -1);
  input.value = valor;
}
function formatearTelefono(input) {
  let valor = input.value.replace(/\D/g, '').substring(0, 11);
  if (valor.length >= 2) valor = valor.slice(0, 2) + '-' + valor.slice(2);
  if (valor.length > 7) valor = valor.slice(0, 7) + '-' + valor.slice(7);
  input.value = valor;
}
function formatearDni(input) {
  let valor = input.value.replace(/\D/g, '').substring(0, 8);
  if (valor.length >= 2) valor = valor.slice(0, 2) + '.' + valor.slice(2);
  if (valor.length > 6) valor = valor.slice(0, 6) + '.' + valor.slice(6);
  input.value = valor;
}
function toggleCuotas() {
  const tipo = document.getElementById("tipo-tarjeta").value;
  document.getElementById("opciones-cuotas").style.display = tipo === "credito" ? "block" : "none";
}
