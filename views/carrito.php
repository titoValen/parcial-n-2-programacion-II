<?php
require_once 'data/conex.php';
require_once 'classes/Cart.php';

$id_user = $_SESSION['user']['id'];
$items = Cart::getItemsByUser($id_user);

$total = 0;
foreach ($items as $item) {
  $total += $item['price'] * $item['amount'];
}
?>

<main class="carrito-main">
  <h1>Tu carrito</h1>

  <?php if (empty($items)): ?>
    <p class="carrito-vacio">Tu carrito está vacío. <a href="?vista=producto">Ver productos</a></p>
  <?php else: ?>
    <div class="carrito-lista">
      <?php foreach ($items as $item): ?>
        <article class="carrito-item">
          <figure class="carrito-item__figure">
            <img src="img/zapatillas/<?= htmlspecialchars($item['image'] ?? '', ENT_QUOTES, 'UTF-8') ?>.webp"
              alt="<?= htmlspecialchars($item['alt'] ?? $item['name'], ENT_QUOTES, 'UTF-8') ?>">
          </figure>

          <div class="carrito-item__info">
            <h2><?= htmlspecialchars($item['name'], ENT_QUOTES, 'UTF-8') ?></h2>
            <p>Talle: <?= htmlspecialchars($item['size'], ENT_QUOTES, 'UTF-8') ?></p>
            <p>Precio unitario: $<?= number_format($item['price'], 0, ',', '.') ?></p>

            <form class="carrito-item__cantidad" action="process/cart_update.php" method="post">
              <input type="hidden" name="id_cart" value="<?= $item['id_cart'] ?>">
              <label for="cantidad-<?= $item['id_cart'] ?>">Cantidad:</label>
              <input
                id="cantidad-<?= $item['id_cart'] ?>"
                type="number"
                name="cantidad"
                value="<?= $item['amount'] ?>"
                min="1"
                max="<?= $item['stock_disponible'] ?>">
              <button type="submit">Actualizar</button>
            </form>

            <form class="carrito-item__quitar" action="process/cart_delete.php" method="post">
              <input type="hidden" name="id_cart" value="<?= $item['id_cart'] ?>">
              <button type="submit">Quitar</button>
            </form>
          </div>

          <p class="carrito-item__subtotal">
            Subtotal: $<?= number_format($item['price'] * $item['amount'], 0, ',', '.') ?>
          </p>
        </article>
      <?php endforeach; ?>
    </div>

    <div class="carrito-total">
      <p class="carrito-total__monto">Total: $<?= number_format($total, 0, ',', '.') ?></p>
      <a class="carrito-confirmar" href="?vista=compra_confirmar">Confirmar compra</a>
    </div>
  <?php endif; ?>
</main>