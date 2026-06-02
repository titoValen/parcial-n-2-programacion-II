<?php
require_once 'classes/Producto.php';
require_once 'config/endpoint.php';

$productos = Producto::obtenerProduct($url);

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$producto = null;

foreach ($productos as $p) {
  if ($p->getId() === $id) {
    $producto = $p;
    break;
  }
}
?>

<main class="detalle-main">
  <?php if (!$producto): ?>

    <p>Producto no encontrado.</p>
    <a href="?vista=producto">Volver a productos</a>

  <?php else: ?>

    <article class="detalle-card">
      <figure class="detalle-figure">
        <img src="<?= $producto->getImage() ?>" alt="<?= $producto->getAlt() ?>">
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