<?php if (isset($producto)): ?>
  <article class="card" id="producto-<?php echo $producto->getId(); ?>">
    <div class="card-header">
      <span class="card-price">$<?php echo number_format($producto->getPrice(), 0, ',', '.'); ?></span>
    </div>

    <div class="card-body">
      <figure>
        <img src="img/zapatillas/<?php echo $producto->getImage(); ?>.webp" alt="<?php echo $producto->getAlt(); ?>">
      </figure>
      <h2 class="card-title"><?php echo $producto->getBrand(); ?> <?php echo $producto->getName(); ?></h2>
    </div>

    <div class="card-footer">
      <a class="card-btn" href="?vista=detalle&id=<?php echo $producto->getId(); ?>">Ver detalles</a>
    </div>
  </article>
<?php endif; ?>