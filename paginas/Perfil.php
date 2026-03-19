<?php
require_once(__DIR__ . '/../php/Conexion.php');
session_start();

if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'Perfil.php') === false) {
    $_SESSION['ultima_pagina'] = $_SERVER['HTTP_REFERER'];
}


if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['id'])) {
    header("Location: login.php");
    exit;
}

$error = '';
$success = '';

$conn = (new Database())->getConnection();
$usuario_id = $_SESSION['usuario']['id'];

$stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$res = $stmt->get_result();
$usuario_actual = $res->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $email = trim($_POST['email']);
    $telefono = trim($_POST['telefono'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if ($nombre === '' || $apellido === '' || $email === '') {
        $error = 'Nombre, apellido y email son obligatorios.';
    } else {
        $foto_perfil = $usuario_actual['foto_perfil'];

        if (!empty($_FILES['foto_perfil']['name'])) {
            $ext = pathinfo($_FILES['foto_perfil']['name'], PATHINFO_EXTENSION);
            $nuevo_nombre = 'perfil_' . $usuario_id . '.' . $ext;
            $ruta = __DIR__ . '/../img_index/perfiles/' . $nuevo_nombre;
            if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $ruta)) {
                $foto_perfil = $nuevo_nombre;
            } else {
                $error = 'Error al subir la imagen de perfil.';
            }
        }

        if ($error === '') {
            $sql = "UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ?, direccion = ?, descripcion = ?, foto_perfil = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("sssssssi", $nombre, $apellido, $email, $telefono, $direccion, $descripcion, $foto_perfil, $usuario_id);
                if ($stmt->execute()) {
                    $success = "Perfil actualizado correctamente.";

                    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
                    $stmt->bind_param("i", $usuario_id);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    $usuario_actual = $res->fetch_assoc();
                } else {
                    $error = "Error al guardar cambios.";
                }
            } else {
                $error = "Error al preparar la consulta.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Perfil - El Millo</title>
    <link rel="icon" type="image/png" href="../img_index/favicon.png">
    <link rel="stylesheet" href="../css/perfil.css">
</head>
<body>
    <div class="container">
        <div class="perfil-header">
<a href="<?= $_SESSION['ultima_pagina'] ?? '../index.php' ?>" class="btn-volver">&#8592; Atrás</a>
            <h1>Mi Perfil</h1>
            <a href="../php/logout.php" class="btn-logout">Cerrar sesión</a>
        </div>

        <?php if ($error): ?>
            <div class="mensaje error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="mensaje success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="perfil-container">
            <div class="perfil-sidebar">
                <div class="foto-perfil-container">
                    <?php if ($usuario_actual['foto_perfil']): ?>
                        <img src="../img_index/perfiles/<?= htmlspecialchars($usuario_actual['foto_perfil']) ?>" class="foto-perfil-grande" alt="Perfil">
                    <?php else: ?>
                        <div class="foto-perfil-placeholder">
                            <span><?= strtoupper(substr($usuario_actual['nombre'], 0, 1)) ?></span>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="info-usuario">
                    <h2><?= htmlspecialchars($usuario_actual['nombre']) ?> <?= htmlspecialchars($usuario_actual['apellido']) ?></h2>
                    <p class="usuario-nombre">@<?= htmlspecialchars($usuario_actual['usuario']) ?></p>
                    <div class="info-datos">
                        <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario_actual['nombre']) ?></p>
                        <p><strong>Apellido:</strong> <?= htmlspecialchars($usuario_actual['apellido']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($usuario_actual['email']) ?></p>
                        <?php if (!empty($usuario_actual['telefono'])): ?>
                            <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario_actual['telefono']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($usuario_actual['direccion'])): ?>
                            <p><strong>Dirección:</strong> <?= htmlspecialchars($usuario_actual['direccion']) ?></p>
                        <?php endif; ?>
                    </div>
                    <?php if (!empty($usuario_actual['descripcion'])): ?>
                        <p class="descripcion">"<?= htmlspecialchars($usuario_actual['descripcion']) ?>"</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="perfil-contenido">
                <form method="POST" enctype="multipart/form-data">
                    <div class="seccion">
                        <h3>Información Personal</h3>
                        <label for="foto_perfil">Foto de Perfil</label>
                        <input type="file" name="foto_perfil" id="foto_perfil" accept="image/*">

                        <label for="nombre">Nombre *</label>
                        <input type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($usuario_actual['nombre']) ?>" required>

                        <label for="apellido">Apellido *</label>
                        <input type="text" name="apellido" id="apellido" value="<?= htmlspecialchars($usuario_actual['apellido']) ?>" required>

                        <label for="email">Email *</label>
                        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario_actual['email']) ?>" required>

                        <label for="telefono">Teléfono</label>
                        <input type="tel" name="telefono" id="telefono" value="<?= htmlspecialchars($usuario_actual['telefono'] ?? '') ?>">

                        <label for="direccion">Dirección</label>
                        <textarea name="direccion" id="direccion"><?= htmlspecialchars($usuario_actual['direccion'] ?? '') ?></textarea>

                        <label for="descripcion">Descripción</label>
                        <textarea name="descripcion" id="descripcion"><?= htmlspecialchars($usuario_actual['descripcion'] ?? '') ?></textarea>
                    </div>

                    <div class="seccion">
                        <h3>Información de Cuenta</h3>
                        <p><strong>Usuario:</strong> <?= htmlspecialchars($usuario_actual['usuario']) ?></p>
                        <p><strong>Fecha de Registro:</strong> <?= date('d/m/Y', strtotime($usuario_actual['fecha_registro'])) ?></p>
                        <?php if (!empty($usuario_actual['fecha_ultimo_acceso'])): ?>
                            <p><strong>Último Acceso:</strong> <?= date('d/m/Y H:i', strtotime($usuario_actual['fecha_ultimo_acceso'])) ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="botones-accion">
                        <button type="submit">Guardar Cambios</button>
                        <a href="../index.php">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
