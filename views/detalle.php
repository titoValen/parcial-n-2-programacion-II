<?php
require_once 'data/conex.php';
require_once 'classes/Product.php';
require_once 'classes/Product_Size.php';

$producto = Product::productById($_GET['id'] ?? null);
$randomProducts = Product::relatedProducts($producto->getId(), $producto->getIdCategory(), $producto->getIdBrand(), 3);
$talles = Product_Size::getByProduct($producto->getId());
?>

<main class="detalle-main">
  <?php if (!$producto): ?>

    <p>Producto no encontrado.</p>
    <a href="?vista=producto">Volver a productos</a>

  <?php else: ?>
    <a class="detalle-back" href="?vista=producto">
      <figure class="detalle-back-icon">
        <img src="img/icon/back.svg" alt="Icono de regreso">
      </figure>
    </a>

    <article class="detalle-card">
      <figure class="detalle-figure">
        <img src="<?= htmlspecialchars($producto->getImagePath(), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($producto->getAlt(), ENT_QUOTES, 'UTF-8') ?>">
      </figure>

      <div class="detalle-content">
        <div class="detalle-info">
          <h1 class="detalle-title"><?= $producto->getBrand() ?> <?= $producto->getName() ?></h1>

          <p class="detalle-description"><?= $producto->getDescription() ?></p>

          <ul class="detalle-data">
            <li><strong>Precio:</strong> $<?= number_format($producto->getPrice(), 0, ',', '.') ?></li>
            <li><strong>Categoría:</strong> <?= $producto->getCategory() ?></li>
            <li><strong>Marca:</strong> <?= $producto->getBrand() ?></li>
          </ul>
        </div>

        <div class="detalle-actions">
          <?php if (empty($talles)): ?>
            <p class="detalle-sin-stock">No hay stock disponible en ningún talle.</p>
          <?php else: ?>
            <form class="detalle-form" action="process/cart_add.php" method="post">
              <input type="hidden" name="id" value="<?= $producto->getId() ?>">

              <label for="talle">Talle:</label>
              <select id="talle" name="id_size" required>
                <option value="">Elegí un talle</option>
                <?php foreach ($talles as $t): ?>
                  <option value="<?= $t->getIdSize() ?>" data-stock="<?= $t->getStock() ?>">
                    <?= $t->getSize() ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span id="stock-info" class="stock-info"></span>

              <label for="cantidad">Cantidad:</label>
              <input type="number" id="cantidad" name="cantidad" value="1" min="1" disabled>

              <button type="submit" id="btn-agregar" disabled>Agregar al carrito</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </article>

    <div class="separador"></div>

    <div class="detalle-related">
      <h2>Productos relacionados</h2>
      <section class="products-grid">
        <?php
        $productoActual = $producto;
        foreach ($randomProducts as $producto):
        ?>
          <?php require 'components/card.php'; ?>
        <?php endforeach; ?>
        <?php $producto = $productoActual; ?>
      </section>
    </div>

  <?php endif; ?>
</main>

<script src="js/detalle-stock.js"></script>