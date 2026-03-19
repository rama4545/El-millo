<?php
session_start();
$formData = $_SESSION['form'] ?? [];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrarse - El Millo</title>
    <link rel="icon" type="image/png" href="../img_index/favicon.png">
    <link rel="stylesheet" href="../css/registrarse.css" />
<body>
    <div class="registrarse">
        <a href="../index.php"><img src="../img_index/logo.png" alt="Logo" class="logo" /></a>
        <h1>¡Bienvenido!</h1>
        <p class="subtitle">Crea tu usuario y contraseña</p>

        <form action="../php/register.php" method="POST">
            <div class="requerimiento">
                <input type="text" name="usuario" placeholder="Nombre de usuario" required
                value="<?= htmlspecialchars($formData['usuario'] ?? '') ?>" />
            </div>
            <div class="requerimiento">
                <input type="email" name="email" placeholder="Email" required
                value="<?= htmlspecialchars($formData['email'] ?? '') ?>" />
            </div>
            <div class="requerimiento">
                <input type="text" name="nombre" placeholder="Nombre" required
                value="<?= htmlspecialchars($formData['nombre'] ?? '') ?>" />
            </div>
            <div class="requerimiento">
                <input type="text" name="apellido" placeholder="Apellido" required
                value="<?= htmlspecialchars($formData['apellido'] ?? '') ?>" />
            </div>
            <div class="requerimiento">
                <input type="password" name="clave" id="clave" placeholder="Contraseña" required minlength="6" />
            </div>
            <div class="requerimiento">
                <input type="password" name="confirmar_clave" id="confirmar_clave" placeholder="Confirmar Contraseña" required minlength="6" />
            </div>

            <div class="requerimiento" style="text-align: center;">
                <label>
                    <input type="checkbox" onclick="vercontraseña()"> Mostrar contraseña 
                </label>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="mensaje-error">
                 <?= htmlspecialchars($_GET['error']) ?>
                </div>
            <?php endif; ?>

            <a href="./login.php" class="pregunta">¿Ya tiene cuenta?</a>
            <button type="submit" class="login">Crear Cuenta</button>
        </form>
    </div>

    <script>
        function vercontraseña() {
            const clave = document.getElementById('clave');
            const confirmar = document.getElementById('confirmar_clave');
            const tipo = clave.type === 'password' ? 'text' : 'password';
            clave.type = tipo;
            confirmar.type = tipo;
        }
    </script>
</body>
</html>
<?php unset($_SESSION['form']); ?>
