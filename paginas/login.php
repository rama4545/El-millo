<?php
require_once(__DIR__ . '/../php/Conexion.php');
session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: ../index.php");
    exit;

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - El Millo</title>
    <link rel="icon" type="image/png" href="../img_index/favicon.png">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="iniciar-sesion">
        <a href="../index.php"><img src="../img_index/logo.png" alt="Logo" class="logo"></a> 
        <h1>¡Bienvenido!</h1>
        <p class="subtitle">Inicia sesión con tu usuario y contraseña</p>
        
        <form action="../php/Login.php" method="POST">
            <div class="requerimiento">
                <input type="text" name="usuario" placeholder="Nombre de usuario o email" required>
            </div>
            <div class="requerimiento">
                <input type="password" name="clave" placeholder="Contraseña" required id="clave">
            </div>
           <?php if (isset($_GET['error'])): ?>
           <p class="mensaje-error"><?= htmlspecialchars($_GET['error']) ?></p>
           <?php endif; ?>
            <div class="requerimiento">
                <label>
                    <input type="checkbox" onclick="document.getElementById('clave').type = this.checked ? 'text' : 'password'">
                    Mostrar contraseña
                </label>
            </div>

            <a href="#soporte" class="contraseña">¿Olvidó su contraseña?</a>
            <a href="../paginas/registrarse.php" class="contraseña">¿No tiene cuenta? Registrarse</a>

            <button type="submit" class="login">Iniciar sesión</button>
        </form>
    </div>
</body>
</html>