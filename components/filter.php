<?php
require_once 'classes/Brand.php';
require_once 'classes/Category.php';
?>

<button class="filter-button filter-toggle-button">
  <figure class="filter-icon-container filter-button-icon">
    <img class="filter-icon" src="img/icon/filter.svg" alt="Icono de filtro">
  </figure>
</button>

<aside class="filter-panel">
  <div class="filter-group">
    <h3 class="filter-title">Categoría</h3>
    <ul class="filter-list filter-list-category">
      <?php foreach (Category::getAllCategories() as $category): ?>
        <li class="filter-item filter-item-category">
          <?= $category->getName() ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
  <div class="filter-group">
    <h3 class="filter-title">Marca</h3>
    <ul class="filter-list filter-list-brand">
      <?php foreach (Brand::getAllBrands() as $brand): ?>
        <li class="filter-item filter-item-brand">
          <?= $brand->getName() ?>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</aside>