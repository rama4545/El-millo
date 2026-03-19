document.addEventListener("DOMContentLoaded", function () {
  const botonesComprar = document.querySelectorAll(".btn-comprar");
  const modal = document.getElementById("modal-producto");
  const modalImg = document.getElementById("modal-img");
  const modalNombre = document.getElementById("modal-nombre");
  const inputNombre = document.getElementById("nombre");
  const inputPrecio = document.getElementById("precio");
  const inputID = document.getElementById("producto_id");

  botonesComprar.forEach(boton => {
    boton.addEventListener("click", () => {
      const nombre = boton.dataset.nombre;
      const precio = boton.dataset.precio;
      const img = boton.dataset.img;
      const id = boton.dataset.id;

      modalImg.src = img;
      modalNombre.textContent = nombre;
      inputNombre.value = nombre;
      inputPrecio.value = precio;
      inputID.value = id;

      modal.classList.remove("oculto");
    });
  });

document.getElementById("form-agregar-carrito").addEventListener("submit", async function (e) {
  e.preventDefault();

  const datos = new FormData(this);

  try {
    const res = await fetch("../php/agregar.php", {
      method: "POST",
      body: datos,
      credentials: "include"
    });

    const data = await res.json();

    if (data.success) {
      mostrarNotificacion("Producto agregado al carrito ✅");
      cerrarModal();
      actualizarContador();
    } else {
      mostrarNotificacion("❌ " + (data.error || "Error al agregar"));
    }

} catch (error) {
  const respuesta = await error?.response?.text?.();
  console.error("FALLO AJAX:", error);
  console.log("RESPUESTA FALLIDA:", respuesta);
  mostrarNotificacion("❌ Error de conexión (ver consola)");
}
});
  window.cerrarModal = function () {
    modal.classList.add("oculto");
    document.getElementById("form-agregar-carrito").reset();
  }

  
  function actualizarContador() {
    fetch("../php/contador_carrito.php")
      .then(res => res.text())
      .then(numero => {
        let cont = document.querySelector(".contador-carrito");
        if (cont) {
          cont.innerText = numero;
        } else {
          const span = document.createElement("span");
          span.className = "contador-carrito";
          span.innerText = numero;
          document.querySelector(".carrito-icono").appendChild(span);
        }
      });
  }

  function mostrarNotificacion(msg) {
    const alerta = document.getElementById("alerta-agregado");
    alerta.innerText = msg;
    alerta.style.display = "block";
    setTimeout(() => alerta.style.display = "none", 4000);
  }
});

function toggleCarrito() {
  const carrito = document.getElementById('carrito-lateral');
  carrito.classList.toggle('visible');
  if (carrito.classList.contains('visible')) cargarCarrito();
}

function cargarCarrito() {
  fetch('../php/carrito.php')
    .then(response => response.text())
    .then(html => {
      document.querySelector('.carrito-resumen').innerHTML = html;
      agregarEventosEliminar();
    });
}

function agregarEventosEliminar() {
  document.querySelectorAll('.btn-eliminar').forEach(boton => {
    boton.addEventListener('click', function(e) {
      e.preventDefault();
      const form = this.closest('form');
      const itemId = form.querySelector('input[name="item_id"]').value;

      fetch(form.action, {
        method: 'POST',
        body: new URLSearchParams({ item_id: itemId })
      })
      .then(res => res.json())
      .then(data => {
        if (data.success) cargarCarrito();
      });
    });
  });
}
