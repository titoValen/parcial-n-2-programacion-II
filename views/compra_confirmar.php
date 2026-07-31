<?php
require_once 'data/conex.php';
require_once 'classes/Cart.php';

$id_user = $_SESSION['user']['id'];
$items = Cart::getItemsByUser($id_user);

$total = 0;
foreach ($items as $item) {
  $total += $item['price'] * $item['amount'];
}

$error = $_GET['error'] ?? null;
$mensajesError = [
  'carrito_vacio'   => 'Tu carrito está vacío.',
  'sin_stock'       => 'No hay stock suficiente para completar la compra. Revisá tu carrito.',
  'excepcion'       => 'Ocurrió un error al procesar la compra. Intentá de nuevo.',
  'metodo_invalido' => 'Elegí un método de pago válido.',
];
?>

<main class="compra-main">
  <h1>Confirmar compra</h1>

  <?php if ($error && isset($mensajesError[$error])): ?>
    <p class="compra-error"><?= htmlspecialchars($mensajesError[$error], ENT_QUOTES, 'UTF-8') ?></p>
  <?php endif; ?>

  <?php if (empty($items)): ?>
    <p class="compra-vacio">Tu carrito está vacío. <a href="?vista=producto">Ver productos</a></p>
  <?php else: ?>
    <section class="compra-resumen">
      <h2>Resumen del pedido</h2>

      <?php foreach ($items as $item): ?>
        <div class="compra-resumen__item">
          <span>
            <?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?>
            (talle <?= htmlspecialchars($item['size'], ENT_QUOTES, 'UTF-8') ?>) x<?= (int) $item['amount'] ?>
          </span>
          <span>$<?= number_format($item['price'] * $item['amount'], 0, ',', '.') ?></span>
        </div>
      <?php endforeach; ?>

      <p class="compra-resumen__total">Total: $<?= number_format($total, 0, ',', '.') ?></p>
    </section>

    <form class="compra-form" action="process/confirm_purchase.php" method="post">
      <fieldset class="compra-form__metodo">
        <legend>Método de pago</legend>

        <label>
          <input type="radio" name="payment_method" value="efectivo" checked>
          Efectivo
        </label>

        <label>
          <input type="radio" name="payment_method" value="transferencia">
          Transferencia
        </label>
      </fieldset>

      <button type="submit" class="compra-form__submit">Finalizar compra</button>
    </form>
  <?php endif; ?>
</main>