<?php
require_once 'data/conex.php';
require_once 'classes/Product.php';

$productos = Product::product();
?>

<main class="products-section">
  <h1>Productos</h1>

  <?php require_once 'components/filter.php'; ?>

  <!-- <div class="filter-wrapper">

    <div class="filter-group">
      <span class="filter-text">Categoría</span>
      <nav class="filter-nav">
        <a class="filter-btn <?= !$categoriaActiva ? 'active' : '' ?>" href="?vista=producto">Todos</a>
        <?php foreach ($categorias as $cat): ?>
          <a class="filter-btn <?= $categoriaActiva === $cat ? 'active' : '' ?>"
             href="?vista=producto&categoria=<?= urlencode($cat) ?>">
            <?= $cat ?>
          </a>
        <?php endforeach; ?>
      </nav>
    </div>

    <div class="filter-group">
      <span class="filter-text">Marca</span>
      <nav class="filter-nav">
        <a class="filter-btn <?= !$marcaActiva ? 'active' : '' ?>" href="?vista=producto">Todas</a>
        <?php foreach ($marcas as $marca): ?>
          <a class="filter-btn <?= $marcaActiva === $marca ? 'active' : '' ?>"
             href="?vista=producto&marca=<?= urlencode($marca) ?>">
            <?= $marca ?>
          </a>
        <?php endforeach; ?>
      </nav>
    </div>

  </div> -->

  <section class="products-grid">
    <?php foreach ($productos as $producto): ?>
      <?php require 'components/card.php'; ?>
    <?php endforeach; ?>
  </section>
</main>