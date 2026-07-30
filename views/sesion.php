<?php
$error = $_GET['error'] ?? null;

$mensajesError = [
  'credenciales'     => 'Email o contraseña incorrectos.',
  'incompleto'       => 'Completá los campos obligatorios (nombre, email y contraseña).',
  'email_existente'  => 'Ese email ya está registrado. Probá iniciar sesión.',
  'registro_fallido' => 'No se pudo completar el registro. Intentá de nuevo.',
];
?>

<main class="auth-main">
  <div class="auth-container">

    <section class="auth-box" id="login-box">
      <h2>Iniciar sesión</h2>

      <?php if ($error && isset($mensajesError[$error])): ?>
        <p class="auth-error" id="auth-error-message"><?= htmlspecialchars($mensajesError[$error], ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>

      <form class="auth-form" action="process/login.php" method="post">
        <label for="login-email">Email</label>
        <input id="login-email" name="email" type="email" required>

        <label for="login-password">Contraseña</label>
        <input id="login-password" name="password" type="password" required>

        <button type="submit">Ingresar</button>
      </form>
      <span id="register-toggle">No tienes cuenta? <strong>Registrarme</strong></span>
    </section>

    <section class="auth-box" id="register-box">
      <h2>Crear cuenta</h2>
      
      <?php if ($error && isset($mensajesError[$error])): ?>
        <p class="auth-error" id="auth-error-message"><?= htmlspecialchars($mensajesError[$error], ENT_QUOTES, 'UTF-8') ?></p>
      <?php endif; ?>

      <form class="auth-form" action="process/register.php" method="post">
        <label for="reg-name">Nombre</label>
        <input id="reg-name" name="name" type="text" required>

        <label for="reg-email">Email</label>
        <input id="reg-email" name="email" type="email" required>

        <label for="reg-password">Contraseña</label>
        <input id="reg-password" name="password" type="password" required minlength="6">

        <label for="reg-address">Dirección</label>
        <input id="reg-address" name="address" type="text">

        <label for="reg-phone">Teléfono</label>
        <input id="reg-phone" name="phone" type="tel">

        <button type="submit">Registrarme</button>
      </form>
      <span id="login-toggle">Ya tienes cuenta? <strong>Iniciar sesión</strong></span>
    </section>

  </div>
</main>