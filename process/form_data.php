<?php
require_once '../components/head-form_data.php';

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$mensaje = $_POST['mensaje'];
$estado = false;

if (empty($nombre) || empty($email) || empty($mensaje)) {
  echo "Por favor, completa todos los campos.";
} else {
  $estado = true;
}
?>

<main>
  <?php if (!$estado): ?>
    <figure><img src="../img/icon/check-error.webp" alt="Check Error"></figure>
    <p>
      <strong>Hubo un error</strong> al enviar tu mensaje.
      Por favor, intentalo de nuevo.
    </p>
    <a href="../index.php?vista=contacto">Volver al formulario</a>
  <?php else: ?>
    <figure><img src="../img/icon/check.webp" alt="Check"></figure>
    <p>
      Gracias por tu mensaje, <strong><?= $nombre ?></strong>.
      Nos pondremos en contacto contigo pronto.
    </p>
    <a href="../index.php?vista=home">Volver al inicio</a>
  <?php endif; ?>
</main>