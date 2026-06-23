<?php
require_once "data/conex.php";
require_once "classes/Product.php";

$productos = Product::product();
?>
<header>
  <h1 class="admin-title">Panel de administración</h1>
</header>

<main class="admin-main">
  <div class="admin-container">
    <?php foreach ($productos as $p): ?>
      <div class="admin-card">
        <img class="admin-card__image" src="img/zapatillas/<?= htmlspecialchars($p->getImage(), ENT_QUOTES, 'UTF-8') ?>.webp"
          alt="<?= htmlspecialchars($p->getAlt(), ENT_QUOTES, 'UTF-8') ?>">
        <h2 class="admin-card__name"><?= htmlspecialchars($p->getName(), ENT_QUOTES, 'UTF-8') ?></h2>
        <p class="admin-card__description"><?= htmlspecialchars($p->getDescription(), ENT_QUOTES, 'UTF-8') ?></p>
        <p class="admin-card__price">Precio: $<?= htmlspecialchars($p->getPrice(), ENT_QUOTES, 'UTF-8') ?></p>
        <p class="admin-card__category">Categoría: <?= htmlspecialchars($p->getCategory(), ENT_QUOTES, 'UTF-8') ?></p>
        <p class="admin-card__stock">Stock: <?= htmlspecialchars($p->getStock(), ENT_QUOTES, 'UTF-8') ?></p>
        <p class="admin-card__brand">Marca: <?= htmlspecialchars($p->getBrand(), ENT_QUOTES, 'UTF-8') ?></p>
        <div class="admin-card__actions">
          <a class="admin-card__edit"
            href="index.php?vista=edit_product&id=<?= htmlspecialchars($p->getId(), ENT_QUOTES, 'UTF-8') ?>">Editar</a>
          <a class="admin-card__delete"
            href="index.php?vista=delete_product&id=<?= htmlspecialchars($p->getId(), ENT_QUOTES, 'UTF-8') ?>">Eliminar</a>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>