<?php
require_once 'data/conex.php';
require_once 'classes/Product.php';

$productos = Product::product();
?>

<main class="products-section">
  <h1>Productos</h1>

  <?php require_once 'components/filter.php'; ?>

  <section class="products-grid">
    <?php foreach ($productos as $producto): ?>
      <?php require 'components/card.php'; ?>
    <?php endforeach; ?>
  </section>

  <p class="products-empty-state" hidden>No se encontró nada con esos filtros.</p>
</main>