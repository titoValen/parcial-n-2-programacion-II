<?php
$estado = null;
$nombre = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = trim($_POST['nombre'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $mensaje = trim($_POST['mensaje'] ?? '');

  $estado = !empty($nombre) && !empty($email) && !empty($mensaje);
} else {
  header('Location: index.php?vista=contacto');
  exit;
}
?>

<main>
  <?php if (!$estado): ?>
    <div class="res-form res-form--error">
      <figure class="res-form__icon"><img src="img/icon/check-error.webp" alt="Check Error"></figure>
      <p class="res-form__message res-form__message--error">
        <strong>Hubo un error</strong> al enviar tu mensaje.
        Por favor, intentalo de nuevo.
      </p>
      <a class="res-form__button res-form__button--error" href="index.php?vista=contacto">Volver al formulario</a>
    </div>
  <?php else: ?>
    <div class="res-form res-form--success">
      <figure class="res-form__icon"><img src="./img/icon/check.webp" alt="Check"></figure>
      <p class="res-form__message res-form__message--success">
        Gracias por tu mensaje, <strong><?= htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8') ?></strong>.
        Nos pondremos en contacto contigo pronto.
      </p>
      <a class="res-form__button res-form__button--success" href="index.php?vista=home">Volver al inicio</a>
    </div>
  <?php endif; ?>
</main>