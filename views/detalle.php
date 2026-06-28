<?php
require_once 'data/conex.php';
require_once 'classes/Product.php';

$producto = Product::productById($_GET['id'] ?? null);
?>

<main class="detalle-main">
  <?php if (!$producto): ?>

    <p>Producto no encontrado.</p>
    <a href="?vista=producto">Volver a productos</a>

  <?php else: ?>

    <article class="detalle-card">
      <figure class="detalle-figure">
        <img src="<?= htmlspecialchars($producto->getImagePath(), ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($producto->getAlt(), ENT_QUOTES, 'UTF-8') ?>">
      </figure>

      <div class="detalle-info">
        <h1 class="detalle-title"><?= $producto->getBrand() ?> <?= $producto->getName() ?></h1>

        <p class="detalle-description"><?= $producto->getDescription() ?></p>

        <ul class="detalle-data">
          <li><strong>Precio:</strong> $<?= number_format($producto->getPrice(), 0, ',', '.') ?></li>
          <li><strong>Categoría:</strong> <?= $producto->getCategory() ?></li>
          <li><strong>Marca:</strong> <?= $producto->getBrand() ?></li>
        </ul>

        <a class="detalle-back" href="?vista=producto">Volver a productos</a>
      </div>
    </article>

  <?php endif; ?>
</main>