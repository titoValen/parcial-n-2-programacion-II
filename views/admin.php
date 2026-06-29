<?php
require_once "data/conex.php";
require_once "classes/Product.php";

$productos = Product::product();
?>
<main class="admin-main">
  <div class="admin-header">
    <h1 class="admin-header__title">Panel de administración</h1>
    <div class="admin-actions">
      <button class="admin-actions__add" type="button" data-modal-open="create">Agregar producto</button>
      <a class="admin-actions__logout" href="process/log_out.php">Cerrar sesión</a>
    </div>
  </div>

  <div class="admin-container">
    <?php foreach ($productos as $p): ?>
      <div class="admin-card">
        <figure class="admin-card__image-container">
          <img class="admin-card__image" src="<?= htmlspecialchars($p->getImagePath(), ENT_QUOTES, 'UTF-8') ?>"
            alt="<?= htmlspecialchars($p->getAlt(), ENT_QUOTES, 'UTF-8') ?>">
        </figure>
        <div class="admin-card__info">
          <h2 class="admin-card__name"><?= htmlspecialchars($p->getName(), ENT_QUOTES, 'UTF-8') ?></h2>
          <p class="admin-card__description"><?= htmlspecialchars($p->getDescription(), ENT_QUOTES, 'UTF-8') ?></p>
          <p class="admin-card__price">Precio: $<?= htmlspecialchars($p->getPrice(), ENT_QUOTES, 'UTF-8') ?></p>
          <p class="admin-card__category">Categoría: <?= htmlspecialchars($p->getCategory(), ENT_QUOTES, 'UTF-8') ?></p>
          <p class="admin-card__stock">Stock: <?= htmlspecialchars($p->getStock(), ENT_QUOTES, 'UTF-8') ?></p>
          <p class="admin-card__brand">Marca: <?= htmlspecialchars($p->getBrand(), ENT_QUOTES, 'UTF-8') ?></p>
        </div>
        <div class="admin-card__actions">
          <button
            class="admin-card__edit"
            type="button"
            data-modal-open="edit"
            data-product-id="<?= htmlspecialchars($p->getId(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-name="<?= htmlspecialchars($p->getName(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-description="<?= htmlspecialchars($p->getDescription(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-price="<?= htmlspecialchars($p->getPrice(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-image="<?= htmlspecialchars($p->getImage(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-alt="<?= htmlspecialchars($p->getAlt(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-category-id="<?= htmlspecialchars($p->getIdCategory(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-stock="<?= htmlspecialchars($p->getStock(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-brand-id="<?= htmlspecialchars($p->getIdBrand(), ENT_QUOTES, 'UTF-8') ?>"
          >Editar</button>
          <button
            class="admin-card__delete"
            type="button"
            data-modal-open="delete"
            data-product-id="<?= htmlspecialchars($p->getId(), ENT_QUOTES, 'UTF-8') ?>"
            data-product-name="<?= htmlspecialchars($p->getName(), ENT_QUOTES, 'UTF-8') ?>"
          >Eliminar</button>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</main>

<?php require_once __DIR__ . '/../components/modal.php'; ?>