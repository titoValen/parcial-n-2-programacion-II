<?php if (isset($producto)): ?>
  <article class="card" id="producto-<?php echo $producto->getId(); ?>"
    data-category="<?php echo htmlspecialchars($producto->getCategory()); ?>"
    data-brand="<?php echo htmlspecialchars($producto->getBrand()); ?>">
    <div class="card-header">
      <span class="card-price">$<?php echo number_format($producto->getPrice(), 0, ',', '.'); ?></span>
    </div>

    <div class="card-body">
      <figure>
        <img src="<?php echo $producto->getImagePath(); ?>" alt="<?php echo $producto->getAlt(); ?>">
      </figure>
      <h2 class="card-title"><?php echo $producto->getBrand(); ?>   <?php echo $producto->getName(); ?></h2>
    </div>

    <div class="card-footer">
      <a class="card-btn" href="?vista=detalle&id=<?php echo $producto->getId(); ?>">Ver detalles</a>
    </div>
  </article>
<?php endif; ?>