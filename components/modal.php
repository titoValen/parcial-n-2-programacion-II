<?php
require_once __DIR__ . '/../classes/Category.php';
require_once __DIR__ . '/../classes/Brand.php';
require_once __DIR__ . '/../classes/User.php';

$categorias = Category::getAllCategories();
$marcas = Brand::getAllBrands();
$admins = User::getAllAdmins();
$adminCount = count($admins);
$currentAdminId = (int) ($_SESSION['user']['id'] ?? 0);
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

<dialog id="product-sizes-modal" class="admin-modal" aria-labelledby="product-sizes-title">
	<form class="admin-modal__form" action="process/product_size_update.php" method="post" data-modal-form="sizes">
		<input id="sizes-id-product" name="id_product" type="hidden">

		<div class="admin-modal__header">
			<h2 class="admin-modal__title" id="product-sizes-title">Gestionar talles — <span data-sizes-product-name></span></h2>
			<button class="admin-modal__close" type="button" data-modal-close aria-label="Cerrar modal">&times;</button>
		</div>

		<p class="admin-modal__message">Cargá el stock disponible para cada talle. Dejalo en 0 si no hay stock.</p>

		<div class="admin-modal__grid" data-sizes-container>
			<!-- Los inputs de cada talle se generan por JS al abrir el modal -->
		</div>

		<div class="admin-modal__actions">
			<button class="admin-modal__button admin-modal__button--ghost" type="button" data-modal-close>Cancelar</button>
			<button class="admin-modal__button admin-modal__button--primary" type="submit">Guardar talles</button>
		</div>
	</form>
</dialog>

<dialog id="catalog-management-modal" class="admin-modal" aria-labelledby="catalog-management-title">
	<form class="admin-modal__form" action="process/catalog_manage.php" method="post" data-modal-form="catalog">
		<div class="admin-modal__header">
			<h2 class="admin-modal__title" id="catalog-management-title">Gestionar categorías y marcas</h2>
			<button class="admin-modal__close" type="button" data-modal-close aria-label="Cerrar modal">&times;</button>
		</div>

		<div class="admin-modal__grid">
			<label class="admin-modal__field" for="catalog-category-name">
				<span>Nueva categoría</span>
				<input id="catalog-category-name" name="category_name" type="text" placeholder="Ej: Running">
			</label>

			<label class="admin-modal__field" for="catalog-brand-name">
				<span>Nueva marca</span>
				<input id="catalog-brand-name" name="brand_name" type="text" placeholder="Ej: Jordan">
			</label>
		</div>

		<div class="admin-modal__grid">
			<label class="admin-modal__field admin-modal__field--full" for="catalog-category-id">
				<span>Eliminar categoría</span>
				<select id="catalog-category-id" name="delete_category_id">
					<option value="" selected>Seleccioná una categoría</option>
					<?php foreach ($categorias as $categoria): ?>
						<option value="<?= htmlspecialchars($categoria->getId(), ENT_QUOTES, 'UTF-8') ?>">
							<?= htmlspecialchars($categoria->getName(), ENT_QUOTES, 'UTF-8') ?>
						</option>
					<?php endforeach; ?>
				</select>
			</label>

			<label class="admin-modal__field admin-modal__field--full" for="catalog-brand-id">
				<span>Eliminar marca</span>
				<select id="catalog-brand-id" name="delete_brand_id">
					<option value="" selected>Seleccioná una marca</option>
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

<dialog id="admin-management-modal" class="admin-modal admin-modal--manage" aria-labelledby="admin-management-title">
	<div class="admin-modal__form admin-management">
		<div class="admin-modal__header">
			<h2 class="admin-modal__title" id="admin-management-title">Gestionar administradores</h2>
			<button class="admin-modal__close" type="button" data-modal-close aria-label="Cerrar modal">&times;</button>
		</div>

		<p class="admin-modal__message">
			Podés crear, editar o eliminar administradores, pero siempre debe quedar al menos uno activo.
		</p>

		<div class="admin-management__toolbar" role="tablist" aria-label="Acciones de administrador">
			<button class="admin-management__tab is-active" type="button" data-admin-action-tab="create">Crear admin</button>
			<button class="admin-management__tab" type="button" data-admin-action-tab="edit">Editar admin</button>
			<button class="admin-management__tab" type="button" data-admin-action-tab="delete">Eliminar admin</button>
		</div>

		<div class="admin-management__panels">
			<section class="admin-management__panel is-active" data-admin-panel="create">
				<form class="admin-management__form" action="process/create_admin.php" method="post" data-modal-form="manage-create">
					<div class="admin-modal__grid">
						<label class="admin-modal__field" for="admin-create-name">
							<span>Nombre</span>
							<input id="admin-create-name" name="name" type="text" required>
						</label>

						<label class="admin-modal__field" for="admin-create-email">
							<span>Email</span>
							<input id="admin-create-email" name="email" type="email" required>
						</label>

						<label class="admin-modal__field admin-modal__field--full" for="admin-create-password">
							<span>Password</span>
							<input id="admin-create-password" name="password" type="password" required>
						</label>
					</div>

					<div class="admin-modal__actions admin-modal__actions--compact">
						<button class="admin-modal__button admin-modal__button--primary" type="submit">Crear admin</button>
					</div>
				</form>
			</section>

			<section class="admin-management__panel" data-admin-panel="edit" hidden>
				<form class="admin-management__form" action="process/edit_admin.php" method="post" data-modal-form="manage-edit">
					<div class="admin-modal__grid">
						<label class="admin-modal__field admin-modal__field--full" for="admin-edit-id">
							<span>Seleccionar admin</span>
							<select id="admin-edit-id" name="id" data-admin-select="edit" required>
								<?php foreach ($admins as $admin): ?>
									<option
										value="<?= htmlspecialchars($admin->getId(), ENT_QUOTES, 'UTF-8') ?>"
										data-admin-name="<?= htmlspecialchars($admin->getName(), ENT_QUOTES, 'UTF-8') ?>"
										data-admin-email="<?= htmlspecialchars($admin->getEmail(), ENT_QUOTES, 'UTF-8') ?>"
										data-admin-role="<?= htmlspecialchars($admin->getRole(), ENT_QUOTES, 'UTF-8') ?>"
										<?= (int) $admin->getId() === $currentAdminId ? 'selected' : '' ?>>
										<?= htmlspecialchars($admin->getName(), ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($admin->getEmail(), ENT_QUOTES, 'UTF-8') ?>)
									</option>
								<?php endforeach; ?>
							</select>
						</label>

						<label class="admin-modal__field" for="admin-edit-name">
							<span>Nombre</span>
							<input id="admin-edit-name" name="name" type="text" required>
						</label>

						<label class="admin-modal__field" for="admin-edit-email">
							<span>Email</span>
							<input id="admin-edit-email" name="email" type="email" required>
						</label>

						<label class="admin-modal__field" for="admin-edit-role">
							<span>Rol</span>
							<select id="admin-edit-role" name="role" required>
								<option value="admin">admin</option>
								<option value="cliente">cliente</option>
							</select>
						</label>

						<label class="admin-modal__field admin-modal__field--full" for="admin-edit-password">
							<span>Password</span>
							<input id="admin-edit-password" name="password" type="password" placeholder="Dejar vacío para conservar la actual">
						</label>
					</div>

					<div class="admin-modal__actions admin-modal__actions--compact">
						<button class="admin-modal__button admin-modal__button--primary" type="submit">Guardar admin</button>
					</div>
				</form>
			</section>

			<section class="admin-management__panel admin-management__panel--danger" data-admin-panel="delete" hidden>
				<form class="admin-management__form" action="process/delete_admin.php" method="post" data-modal-form="manage-delete">
					<div class="admin-modal__grid">
						<label class="admin-modal__field admin-modal__field--full" for="admin-delete-id">
							<span>Seleccionar admin</span>
							<select id="admin-delete-id" name="id" data-admin-select="delete" required <?= $adminCount <= 1 ? 'disabled' : '' ?>>
								<?php foreach ($admins as $admin): ?>
									<option
										value="<?= htmlspecialchars($admin->getId(), ENT_QUOTES, 'UTF-8') ?>"
										data-admin-name="<?= htmlspecialchars($admin->getName(), ENT_QUOTES, 'UTF-8') ?>"
										data-admin-email="<?= htmlspecialchars($admin->getEmail(), ENT_QUOTES, 'UTF-8') ?>"
										data-admin-role="<?= htmlspecialchars($admin->getRole(), ENT_QUOTES, 'UTF-8') ?>"
										<?= (int) $admin->getId() === $currentAdminId ? 'selected' : '' ?>>
										<?= htmlspecialchars($admin->getName(), ENT_QUOTES, 'UTF-8') ?> (<?= htmlspecialchars($admin->getEmail(), ENT_QUOTES, 'UTF-8') ?>)
									</option>
								<?php endforeach; ?>
							</select>
						</label>
					</div>

					<p class="admin-management__warning" data-admin-delete-warning>
						<?php if ($adminCount <= 1): ?>
							No podés eliminar al único administrador existente.
						<?php else: ?>
							Esta acción elimina al administrador seleccionado y no se puede deshacer.
						<?php endif; ?>
					</p>

					<div class="admin-modal__actions admin-modal__actions--compact">
						<button class="admin-modal__button admin-modal__button--danger" type="submit" <?= $adminCount <= 1 ? 'disabled' : '' ?>>Eliminar admin</button>
					</div>
				</form>
			</section>
		</div>
	</div>
</dialog>