<?php
session_start();

require_once __DIR__ . '/../data/conex.php';
require_once __DIR__ . '/../classes/Product.php';

$name = $_POST['name'] ?? '';
$description = $_POST['description'] ?? '';
$price = $_POST['price'] ?? '';
$alt = $_POST['alt'] ?? '';
$id_category = $_POST['id_category'] ?? '';
$id_brand = $_POST['id_brand'] ?? '';
$stock = $_POST['stock'] ?? '';

$uploadedImage = $_FILES['image'] ?? null;
$allowedExtensions = ['webp', 'jpg', 'jpeg', 'png'];
$imageName = null;
$targetDirectory = __DIR__ . '/../img/zapatillas/';
$notice = '';

if (
	$name !== '' &&
	$description !== '' &&
	$price !== '' &&
	$alt !== '' &&
	$id_category !== '' &&
	$id_brand !== '' &&
	$stock !== ''
) {
	$productId = Product::createProduct($name, $description, $price, null, $alt, $id_category, $id_brand, $stock);

	if ($productId > 0) {
		if ($uploadedImage && $uploadedImage['error'] === UPLOAD_ERR_OK) {
			$originalName = $uploadedImage['name'];
			$extension = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

			if (in_array($extension, $allowedExtensions, true)) {
				if (!is_dir($targetDirectory)) {
					mkdir($targetDirectory, 0775, true);
				}

				$imageName = 'product_' . $productId;
				$targetFile = $targetDirectory . $imageName . '.' . $extension;

				if (move_uploaded_file($uploadedImage['tmp_name'], $targetFile)) {
					Product::updateProductImage($productId, $imageName);
					$notice = 'Producto creado correctamente.';
				} else {
					$notice = 'El producto se creó, pero no se pudo guardar la imagen.';
				}
			} else {
				$notice = 'El producto se creó, pero la imagen no tiene una extensión permitida.';
			}
		} else {
			$notice = 'Producto creado sin imagen.';
		}
	} else {
		$notice = 'No se pudo crear el producto.';
	}
}

header('Location: ../index.php?vista=admin');
exit;
