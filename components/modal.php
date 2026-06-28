<?php
require_once __DIR__ . '/../classes/Category.php';
require_once __DIR__ . '/../classes/Brand.php';

$categorias = Category::getAllCategories();
$marcas = Brand::getAllBrands();
?>

<dialog id="product-create-modal" class="admin-modal" aria-labelledby="product-create-title">
	<form class="admin-modal__form" action="process/product_add.php" method="post" enctype="multipart/form-data" data-modal-form="create">
		<div class="admin-modal__header">
			<h2 class="admin-modal__title" id="product-create-title">Agregar producto</h2>
			<button class="admin-modal__close" type="button" data-modal-close aria-label="Cerrar modal">&times;</button>
		</div>

		<div class="admin-modal__grid">
			<label class="admin-modal__field" for="create-name">
				<span>Nombre</span>
				<input id="create-name" name="name" type="text" required>
			</label>

			<label class="admin-modal__field admin-modal__field--full" for="create-description">
				<span>Descripción</span>
				<textarea id="create-description" name="description" rows="4" required></textarea>
			</label>

			<label class="admin-modal__field" for="create-price">
				<span>Precio</span>
				<input id="create-price" name="price" type="number" min="0" step="1" required>
			</label>

			<label class="admin-modal__field" for="create-image">
				<span>Imagen</span>
				<input id="create-image" name="image" type="file" accept="image/webp, image/jpeg, image/png" required>
			</label>

			<label class="admin-modal__field admin-modal__field--full" for="create-alt">
				<span>Alt</span>
				<input id="create-alt" name="alt" type="text" required>
			</label>

			<label class="admin-modal__field" for="create-category">
				<span>Categoría</span>
				<select id="create-category" name="id_category" required>
					<option value="" selected disabled>Seleccioná una categoría</option>
					<?php foreach ($categorias as $categoria): ?>
						<option value="<?= htmlspecialchars($categoria->getId(), ENT_QUOTES, 'UTF-8') ?>">
							<?= htmlspecialchars($categoria->getName(), ENT_QUOTES, 'UTF-8') ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>

			<label class="admin-modal__field" for="create-stock">
				<span>Stock disponible</span>
				<input id="create-stock" name="stock" type="number" min="0" step="1" required>
			</label>

			<label class="admin-modal__field" for="create-brand">
				<span>Marca</span>
				<select id="create-brand" name="id_brand" required>
					<option value="" selected disabled>Seleccioná una marca</option>
					<?php foreach ($marcas as $marca): ?>
						<option value="<?= htmlspecialchars($marca->getId(), ENT_QUOTES, 'UTF-8') ?>">
							<?= htmlspecialchars($marca->getName(), ENT_QUOTES, 'UTF-8') ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>
		</div>

		<div class="admin-modal__actions">
			<button class="admin-modal__button admin-modal__button--ghost" type="button" data-modal-close>Cancelar</button>
			<button class="admin-modal__button admin-modal__button--primary" type="submit">Guardar producto</button>
		</div>
	</form>
</dialog>

<dialog id="product-edit-modal" class="admin-modal" aria-labelledby="product-edit-title">
	<form class="admin-modal__form" action="process/product_update.php" method="post" enctype="multipart/form-data" data-modal-form="edit">
		<input id="edit-id" name="id" type="hidden">

		<div class="admin-modal__header">
			<h2 class="admin-modal__title" id="product-edit-title">Editar producto</h2>
			<button class="admin-modal__close" type="button" data-modal-close aria-label="Cerrar modal">&times;</button>
		</div>

		<div class="admin-modal__grid">
			<label class="admin-modal__field" for="edit-name">
				<span>Nombre</span>
				<input id="edit-name" name="name" type="text" required>
			</label>

			<label class="admin-modal__field admin-modal__field--full" for="edit-description">
				<span>Descripción</span>
				<textarea id="edit-description" name="description" rows="4" required></textarea>
			</label>

			<label class="admin-modal__field" for="edit-price">
				<span>Precio</span>
				<input id="edit-price" name="price" type="number" min="0" step="1" required>
			</label>

			<label class="admin-modal__field" for="edit-image">
				<span>Imagen</span>
				<input id="edit-image" name="image" type="file" accept="image/webp, image/jpeg, image/png">
				<small class="admin-modal__hint" data-current-image>Subí una nueva imagen solo si querés cambiar la actual.</small>
			</label>

			<label class="admin-modal__field admin-modal__field--full" for="edit-alt">
				<span>Alt</span>
				<input id="edit-alt" name="alt" type="text" required>
			</label>

			<label class="admin-modal__field" for="edit-category">
				<span>Categoría</span>
				<select id="edit-category" name="id_category" required>
					<option value="" disabled>Seleccioná una categoría</option>
					<?php foreach ($categorias as $categoria): ?>
						<option value="<?= htmlspecialchars($categoria->getId(), ENT_QUOTES, 'UTF-8') ?>">
							<?= htmlspecialchars($categoria->getName(), ENT_QUOTES, 'UTF-8') ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>

			<label class="admin-modal__field" for="edit-stock">
				<span>Stock disponible</span>
				<input id="edit-stock" name="stock" type="number" min="0" step="1" required>
			</label>

			<label class="admin-modal__field" for="edit-brand">
				<span>Marca</span>
				<select id="edit-brand" name="id_brand" required>
					<option value="" disabled>Seleccioná una marca</option>
					<?php foreach ($marcas as $marca): ?>
						<option value="<?= htmlspecialchars($marca->getId(), ENT_QUOTES, 'UTF-8') ?>">
							<?= htmlspecialchars($marca->getName(), ENT_QUOTES, 'UTF-8') ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>
		</div>

		<div class="admin-modal__actions">
			<button class="admin-modal__button admin-modal__button--ghost" type="button" data-modal-close>Cancelar</button>
			<button class="admin-modal__button admin-modal__button--primary" type="submit">Guardar cambios</button>
		</div>
	</form>
</dialog>

<dialog id="product-delete-modal" class="admin-modal admin-modal--delete" aria-labelledby="product-delete-title">
	<form class="admin-modal__form" action="process/product_delete.php" method="get" data-modal-form="delete">
		<input id="delete-id" name="id" type="hidden">

		<div class="admin-modal__header">
			<h2 class="admin-modal__title" id="product-delete-title">Eliminar producto</h2>
			<button class="admin-modal__close" type="button" data-modal-close aria-label="Cerrar modal">&times;</button>
		</div>

		<p class="admin-modal__message">
			¿Estás seguro de que querés eliminar <strong data-delete-name>este producto</strong>?
		</p>

		<div class="admin-modal__actions">
			<button class="admin-modal__button admin-modal__button--ghost" type="button" data-modal-close>Cancelar</button>
			<button class="admin-modal__button admin-modal__button--danger" type="submit">Continuar</button>
		</div>
	</form>
</dialog>
