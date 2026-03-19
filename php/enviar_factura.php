<?php
require_once(__DIR__ . '/Conexion.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';

$orden_id   = $_POST['compra_id'] ?? null;
$nombre     = $_POST['nombre'] ?? '';
$email      = $_POST['email'] ?? '';
$total      = $_POST['total'] ?? 0;
$direccion  = $_POST['direccion'] ?? '';
$localidad  = $_POST['localidad'] ?? '';  
$provincias  = $_POST['provincias'] ?? ''; 
$dni        = $_POST['dni'] ?? '';
$telefono   = $_POST['telefono'] ?? '';
$tarjeta    = ucfirst(strtolower($_POST['tarjeta'] ?? ''));
$tipo_pago  = ucfirst(strtolower($_POST['tipo_pago'] ?? ''));
$cuotas     = $_POST['cuotas'] ?? '1';
$cuotas_text = ($cuotas == '1') ? '1 cuota' : "$cuotas cuotas";

if (!$orden_id || !$email || !$nombre) {
    exit("Faltan datos para enviar la factura.");
}

$db = new Database();
$conn = $db->getConnection();

$query = "
    SELECT p.nombre, ci.talle, ci.cantidad, p.precio
    FROM compra_items ci
    JOIN productos p ON ci.producto_id = p.id
    WHERE ci.orden_id = ?
";
$stmt = $conn->prepare($query);
if (!$stmt) {
    exit("Error al preparar la consulta: " . $conn->error);
}
$stmt->bind_param("i", $orden_id);
$stmt->execute();
$res = $stmt->get_result();

$items_html = "";
$total_factura = 0;
while ($row = $res->fetch_assoc()) {
    $subtotal = $row['precio'] * $row['cantidad'];
    $total_factura += $subtotal;
    $items_html .= "<tr>
        <td>{$row['nombre']}</td>
        <td>{$row['talle']}</td>
        <td>{$row['cantidad']}</td>
        <td>$" . number_format($row['precio'], 2, ',', '.') . "</td>
        <td>$" . number_format($subtotal, 2, ',', '.') . "</td>
    </tr>";
}

$fecha = date("d/m/Y");

$detalle_pago = "$tarjeta $tipo_pago";
if (strtolower($tipo_pago) === 'Crédito' && in_array((int)$cuotas, [3, 6, 9, 12])) {
    $valor_cuota = $total_factura / (int)$cuotas;
    $detalle_pago .= " ($cuotas_text de $" . number_format($valor_cuota, 2, ',', '.') . ")";
} else {
    $detalle_pago .= " ($cuotas_text)";
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ramiro.caballero.t1vl@gmail.com';
    $mail->Password   = 'bpdn pfxx ipeh teoa'; // clave de aplicación
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('elmillotienda@gmail.com', 'El Millo');
    $mail->addAddress($email, $nombre);
    $mail->AddEmbeddedImage('../img_index/logo.png', 'logo_millo');

    // Email
    $mail->isHTML(true);
    $mail->Subject = "Factura de compra - El Millo (#$orden_id)";
    $mail->Body = "
    <div style='font-family:Arial,sans-serif; color:#333; max-width:700px; margin:0 auto'>
        <h2 style='color:#900; border-bottom:2px solid #900;'>Factura de compra</h2>
        <p><strong>Número de orden:</strong> #$orden_id</p>
        <p><strong>Fecha:</strong> $fecha</p>
        <p><strong>Cliente:</strong> $nombre</p>
        <p><strong>DNI:</strong> $dni</p>
        <p><strong>Teléfono:</strong> $telefono</p>
        <p><strong>Dirección:</strong> $direccion</p>
        <p><strong>Localidad:</strong> $localidad</p>
        <p><strong>Provincias:</strong> $provincias</p>
        <p><strong>Forma de pago:</strong> " . $detalle_pago . "</p>

        <table border='1' cellpadding='8' cellspacing='0' style='width: 100%; border-collapse: collapse; margin-top: 10px'>
            <thead style='background-color:#f2f2f2'>
                <tr>
                    <th>Producto</th>
                    <th>Talle</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                $items_html
            </tbody>
        </table>

        <p style='margin-top:20px; font-size: 16px'><strong>Total:</strong> $" . number_format($total_factura, 2, ',', '.') . "</p>

        <br><br>
        <div style='text-align: center;'>
            <img src='cid:logo_millo' alt='El Millo Logo' style='width: 120px;'><br>
            <p style='font-size:12px; color: #666; margin-top:10px'>
                Gracias por comprar en El Millo. Este email es automático, por favor no respondas.
            </p>
        </div>
    </div>";

    $mail->send();

} catch (Exception $e) {
    error_log("Error al enviar correo: " . $mail->ErrorInfo);
}
