<?php
require_once(__DIR__ . '/php/Conexion.php');
session_start();
$usuarioLogueado = isset($_SESSION['usuario']);
$carrito_cantidad = 0;
if ($usuarioLogueado) {
    $conn = (new Database())->getConnection();
    $usuario_id = $_SESSION['usuario']['id'];
    $sql = "SELECT SUM(cantidad) as total FROM carrito_items ci JOIN carritos c ON ci.carritos_id = c.id WHERE c.usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $carrito_cantidad = $row['total'] ?? 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tienda Millo</title>
    <link rel="icon" type="image/png" href="./img_index/favicon.png">
    <link rel="stylesheet" href="general.css">
    <link rel="stylesheet" href="css/carrito.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script defer src="../js/carrito.js"></script>
    <script defer src="../js/buscar.js"></script>
</head>
<body>
<header>
    <nav>
        <a href="index.php"><img src="img_index/logo.png" class="logo" alt="Logo"></a>
       <form action="php/buscar.php" class="buscar" method="get">
       <input type="text" name="q" placeholder="Buscar">
       <button type="submit"><i class="fas fa-search"></i></button>
       </form>
        <div class="iconos">
            <?php if ($usuarioLogueado): ?>
                <a href="paginas/Perfil.php" title="Perfil"><img src="img_index/user.png" class="user"></a>
            <?php else: ?>
                <a href="paginas/login.php" class="btn-iniciarsesion">Iniciar sesión</a>
                <a href="paginas/registrarse.php" class="btn-iniciarsesion">Crear cuenta</a>
            <?php endif; ?>
            <div class="carrito-icono" onclick="toggleCarrito()" id="icono-carrito">
                <img src="img_index/carrito.png" alt="Carrito" class="carrito">
                <?php if ($carrito_cantidad > 0): ?>
                    <span class="contador-carrito"><?= $carrito_cantidad ?></span>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>

<div id="carrito-lateral" class="carrito-lateral">
    <div class="carrito-header">
        <span>Carrito</span>
        <button onclick="toggleCarrito()" style="background: none; border: none; color: white; font-size: 18px;">&times;</button>
    </div>
    <div class="carrito-resumen">
        <p>Tu carrito está vacío.</p>
    </div>
</div>

<div class="alerta-agregado" id="alerta-agregado" style="display:none;"></div>
<div id="notificacion-carrito" class="notificacion" style="display:none;"></div>

<main>
  <div class="portada">
    <img src="./img_index/fondo.svg" alt="Portada">
  </div>

  <div class="descuento">
    <img src="./img_index/descuento.png" alt="Descuento">
  </div>

  <div class="iconos-awesome"> 
    <div class="icono">
      <i class="fas fa-credit-card"></i>
      <span>12 cuotas sin interés</span>
    </div>
    <div class="icono">
      <i class="fas fa-exchange-alt"></i>
      <span>Primer cambio gratis</span>
    </div>
    <div class="icono">
      <i class="fas fa-truck"></i>
      <span>Envíos todo el país</span>
    </div>
    <div class="icono">
      <i class="fas fa-clock"></i>
      <span>Atención 24hs</span>
    </div>
  </div>

  <div class="categorias">
    <a href="./paginas/adultos.php">
      <div class="categoria">
        <img src="./img_index/adultos.png" alt="Hombres">  
        <h3>Adultos</h3>
      </div>
    </a>

    <a href="./paginas/retros.php">
      <div class="categoria">
        <img src="./img_index/retros.png" alt="Retros">
        <div class="contenido-texto"><h3>Retros</h3></div>
      </div>
    </a>

    <a href="./paginas/niños.php">
      <div class="categoria">
        <img src="./img_index/niños.png" alt="Niños">
        <h3>Niños</h3>
      </div>
    </a>
  </div>

  <div class="soymillo">
    <img src="./img_index/publicidad2.png" alt="">
  </div>
</main>

<script>
function toggleCarrito() {
  const carrito = document.getElementById('carrito-lateral');
  carrito.classList.toggle('visible');
  if (carrito.classList.contains('visible')) cargarCarrito();
}

function cargarCarrito() {
  fetch('./php/carrito_index.php')
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
</script>

<footer>
    <p>&copy; 2025 EL MILLO. Todos los derechos reservados.</p>
    <div class="redes-sociales">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
</footer>
</body>
</html>
