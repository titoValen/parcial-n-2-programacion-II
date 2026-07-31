<?php
require_once 'data/conex.php';
require_once 'classes/User.php';
require_once 'classes/Buy.php';

$id_user = $_SESSION['user']['id'];
$usuario = User::getById($id_user);
$compras = Buy::getPurchasesByUser($id_user);
?>

<main class="perfil-main">
  <h1>Mi perfil</h1>

  <section class="perfil-datos">
    <h2>Datos personales</h2>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario->getName(), ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($usuario->getEmail(), ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Dirección:</strong> <?= htmlspecialchars($usuario->getAddress() ?: 'No especificada', ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Teléfono:</strong> <?= htmlspecialchars($usuario->getPhone() ?: 'No especificado', ENT_QUOTES, 'UTF-8') ?></p>
    <div class="container-btns">
      <a href="" class="perfil-datos__editar">Editar perfil</a>
      <a href="process/log_out.php" class="perfil-datos__cerrar">Cerrar sesión</a>
      <a href="" class="perfil-datos__eliminar">Eliminar cuenta</a>
    </div>
  </section>

  <section class="perfil-compras">
    <h2>Historial de compras</h2>

    <?php if (empty($compras)): ?>
      <p>Todavía no realizaste ninguna compra.</p>
    <?php else: ?>
      <div class="perfil-compras__list">
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
      </div>
    <?php endif; ?>
  </section>
</main>