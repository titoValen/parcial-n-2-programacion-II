<?php
require_once 'data/conex.php';
require_once 'classes/User.php';
require_once 'classes/Buy.php';

$id_user = $_SESSION['user']['id'];
$usuario = User::getById($id_user);
$compras = Buy::getPurchasesByUser($id_user);

$error = $_GET['error'] ?? null;
$ok = $_GET['ok'] ?? null;

$mensajesError = [
  'incompleto'          => 'Completá nombre y email.',
  'email_en_uso'        => 'Ese email ya está en uso por otra cuenta.',
  'password_incorrecta' => 'La contraseña no es correcta. No se eliminó la cuenta.',
];

$mensajesOk = [
  'perfil_actualizado' => 'Tus datos se actualizaron correctamente.',
];
?>

<main class="perfil-main">
  <h1>Mi perfil</h1>

  <?php if ($error && isset($mensajesError[$error])): ?>
    <p class="perfil-mensaje perfil-mensaje--error"><?= htmlspecialchars($mensajesError[$error], ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>

  <?php if ($ok && isset($mensajesOk[$ok])): ?>
    <p class="perfil-mensaje perfil-mensaje--ok"><?= htmlspecialchars($mensajesOk[$ok], ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>

  <section class="perfil-datos">
    <h2>Datos personales</h2>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->getName(), ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail(), ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Dirección:</strong> <?= htmlspecialchars($usuario->getAddress() ?: 'No especificada', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario->getPhone() ?: 'No especificado', ENT_QUOTES, 'UTF-8') ?></p>

    <div class="perfil-datos__acciones">
      <button type="button" class="perfil-datos__editar" data-perfil-modal-open="edit">Editar perfil</button>
      <a href="process/log_out.php" class="perfil-datos__logout">Cerrar sesión</a>
      <button type="button" class="perfil-datos__eliminar" data-perfil-modal-open="delete">Eliminar cuenta</button>
    </div>
  </section>

  <section class="perfil-compras">
    <h2>Historial de compras</h2>

    <?php if (empty($compras)): ?>
      <p>Todavía no realizaste ninguna compra.</p>
    <?php else: ?>
      <?php foreach ($compras as $compra): ?>
        <?php $detalle = Buy::getDetailByBuyId($compra['id']); ?>
        <article class="perfil-compra">
          <header class="perfil-compra__header">
            <span>Pedido #<?= (int) $compra['id'] ?></span>
            <span><?= htmlspecialchars(date('d/m/Y H:i', strtotime($compra['date'])), ENT_QUOTES, 'UTF-8') ?></span>
            <span>Estado: <?= htmlspecialchars($compra['state'], ENT_QUOTES, 'UTF-8') ?></span>
            <span>Pago: <?= htmlspecialchars($compra['payment_method'], ENT_QUOTES, 'UTF-8') ?></span>
          </header>

          <ul class="perfil-compra__items">
            <?php foreach ($detalle as $item): ?>
              <li>
                <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
                (talle <?= htmlspecialchars($item['size'], ENT_QUOTES, 'UTF-8') ?>) x<?= (int) $item['amount'] ?>
                — $<?= number_format($item['unit_price'] * $item['amount'], 0, ',', '.') ?>
              </li>
            <?php endforeach; ?>
          </ul>

          <p class="perfil-compra__total">Total: $<?= number_format($compra['total'], 0, ',', '.') ?></p>
        </article>
      <?php endforeach; ?>
    <?php endif; ?>
  </section>
</main>

<dialog id="perfil-edit-modal" class="perfil-modal" aria-labelledby="perfil-edit-title">
  <form class="perfil-modal__form" action="process/edit_profile.php" method="post">
    <div class="perfil-modal__header">
      <h2 id="perfil-edit-title">Editar perfil</h2>
      <button type="button" class="perfil-modal__close" data-perfil-modal-close aria-label="Cerrar">&times;</button>
    </div>

    <label for="edit-perfil-name">Nombre</label>
    <input id="edit-perfil-name" name="name" type="text" value="<?= htmlspecialchars($usuario->getName(), ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="edit-perfil-email">Email</label>
    <input id="edit-perfil-email" name="email" type="email" value="<?= htmlspecialchars($usuario->getEmail(), ENT_QUOTES, 'UTF-8') ?>" required>

    <label for="edit-perfil-address">Dirección</label>
    <input id="edit-perfil-address" name="address" type="text" value="<?= htmlspecialchars($usuario->getAddress(), ENT_QUOTES, 'UTF-8') ?>">

    <label for="edit-perfil-phone">Teléfono</label>
    <input id="edit-perfil-phone" name="phone" type="tel" value="<?= htmlspecialchars($usuario->getPhone(), ENT_QUOTES, 'UTF-8') ?>">

    <label for="edit-perfil-password">Nueva contraseña</label>
    <input id="edit-perfil-password" name="new_password" type="password" minlength="6" placeholder="Dejar vacío para no cambiarla">

    <div class="perfil-modal__actions">
      <button type="button" data-perfil-modal-close>Cancelar</button>
      <button type="submit">Guardar cambios</button>
    </div>
  </form>
</dialog>

<dialog id="perfil-delete-modal" class="perfil-modal perfil-modal--delete" aria-labelledby="perfil-delete-title">
  <form class="perfil-modal__form" action="process/delete_profile.php" method="post">
    <div class="perfil-modal__header">
      <h2 id="perfil-delete-title">Eliminar cuenta</h2>
      <button type="button" class="perfil-modal__close" data-perfil-modal-close aria-label="Cerrar">&times;</button>
    </div>

    <p>Esta acción es <strong>permanente</strong>. Se van a borrar tu cuenta, tu carrito y tu historial de compras.</p>

    <label for="delete-perfil-password">Confirmá tu contraseña</label>
    <input id="delete-perfil-password" name="password" type="password" required>

    <div class="perfil-modal__actions">
      <button type="button" data-perfil-modal-close>Cancelar</button>
      <button type="submit" class="perfil-modal__danger">Eliminar cuenta</button>
    </div>
  </form>
</dialog>

<script src="js/perfil-modal.js"></script>